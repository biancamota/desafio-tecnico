<?php

namespace Bm\Store\Controller;

use Bm\Store\Service\SaleService;
use Bm\Store\Util\JsonResponse;

class SaleController
{
    protected $saleService;

    public function __construct()
    {
        $this->saleService = new SaleService;
    }

    public function getAll()
    {
        $sales = $this->saleService->getAll();
        return JsonResponse::send($sales);
    }

    public function getById($args)
    {
        $sale = $this->saleService->getById($args['sales']);
        if (!$sale) {
            return JsonResponse::send('Sale not found', 404);
        }
        return JsonResponse::send($sale);
    }

    public function store($request)
    {
        $response = $this->saleService->store($request);

        if (!empty($response)) {
            return JsonResponse::send($response, 400);
        }

        return JsonResponse::send('Sale saved successfully', 201);
    }

    public function update($request, $args)
    {
        $sale = $this->saleService->getById($args['sales']);

        if (!$sale) {
            return JsonResponse::send('Sale not found', 404);
        }

        $this->saleService->update($args['sales'], $sale);

        return JsonResponse::send('Sale updated successfully');
    }

    public function delete($args)
    {
        $sale = $this->saleService->getById($args['sales']);

        if (!$sale) {
            return JsonResponse::send('Sale not found', 404);
        }

        $this->saleService->delete($args['sales']);

        return JsonResponse::send('Sale deleted successfully');
    }
}
