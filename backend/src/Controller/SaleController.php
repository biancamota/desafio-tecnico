<?php

namespace Bm\Store\Controller;

use Bm\Store\Entity\Sale;
use Bm\Store\Repository\SaleRepository;
use Bm\Store\Util\JsonResponse;

class SaleController
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
        return JsonResponse::send($sales);
    }

    public function getById($args)
    {
        $sale = $this->saleRepository->getById($args['sales']);
        if (!$sale) {
            return JsonResponse::send('Sale not found', 404);
        }
        return JsonResponse::send($sale->toJsonArray());
    }

    public function store($request)
    {
        $sale = new Sale;
        $sale->date = $request->date;
        $sale->total_purchase = $request->total_purchase;
        $sale->total_taxes = $request->total_taxes;

        $this->saleRepository->create($sale);

        return JsonResponse::send('Sale saved successfully', 201);
    }

    public function update($request, $args)
    {
        $sale = $this->saleRepository->getById($args['sales']);

        if (!$sale) {
            return JsonResponse::send('Sale not found', 404);
        }

        $sale->date = $request->date;
        $sale->total_purchase = $request->total_purchase;
        $sale->total_taxes = $request->total_taxes;

        $this->saleRepository->update($args['sales'], $sale);

        return JsonResponse::send('Sale updated successfully');
    }

    public function delete($args)
    {
        $sale = $this->saleRepository->getById($args['sales']);

        if (!$sale) {
            return JsonResponse::send('Sale not found', 404);
        }

        $this->saleRepository->delete($args['sales']);

        return JsonResponse::send('Sale deleted successfully');
    }
}
