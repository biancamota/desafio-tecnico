<?php

namespace Bm\Store\Service;

use Bm\Store\Entity\Sale;
use Bm\Store\Repository\SaleRepository;

class SaleService
{
    protected $saleRepository;

    public function __construct()
    {
        $this->saleRepository = new SaleRepository;
    }

    public function getAll()
    {
        $data = $this->saleRepository->getAll();
        $sales = [];
        foreach ($data as $sale) {
            $sales[] = $sale->toJsonArray();
        }
        return $sales;
    }

    public function getById($args)
    {
        $sale = $this->saleRepository->getById($args['sales']);

        return $sale ? $sale->toJsonArray() : null;
    }

    public function store($request)
    {
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return ['errors' => $validationErrors];
        }

        $sale = new Sale;
        $sale->date = $request->date;
        $sale->total_purchase = $request->total_purchase;
        $sale->total_taxes = $request->total_taxes;

        $this->saleRepository->create($sale);

        return [];
    }

    public function update($request, $args)
    {
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return ['errors' => $validationErrors];
        }

        $sale = new Sale;
        $sale->date = $request->date;
        $sale->total_purchase = $request->total_purchase;
        $sale->total_taxes = $request->total_taxes;

        $this->saleRepository->update($args['sales'], $sale);

        return [];
    }

    public function delete($args)
    {
        $this->saleRepository->delete($args['sales']);

        return [];
    }
    private function validate($sale)
    {
        $validationErrors = [];

        if (empty($sale->date)) {
            $validationErrors[] = 'Date cannot be empty';
        }

        if (empty($sale->total_purchase)) {
            $validationErrors[] = 'Total purchase cannot be empty';
        }

        if (empty($sale->total_taxes)) {
            $validationErrors[] = 'Total taxes cannot be empty';
        }

        return $validationErrors;
    }
}
