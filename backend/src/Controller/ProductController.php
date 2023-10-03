<?php

namespace Bm\Store\Controller;

use Bm\Store\Entity\Product;
use Bm\Store\Service\ProductService;
use Bm\Store\Util\JsonResponse;

class ProductController
{
    protected $productService;

    public function __construct()
    {
        $this->productService = new ProductService;
    }

    public function getAll()
    {
        $products = $this->productService->getAll();

        return JsonResponse::send($products);
    }

    public function getById($args)
    {
        $product = $this->productService->getById($args['products']);

        if (!$product) {
            return JsonResponse::send('Product not found', 404);
        }

        return JsonResponse::send($product);
    }

    public function store($request)
    {
        $response = $this->productService->store($request);

        if (!empty($response)) {
            return JsonResponse::send($response, 400);
        }

        return JsonResponse::send('Product saved successfully', 201);
    }

    public function update($request, $args)
    {
        $product = $this->productService->getById($args['products']);

        if (!$product) {
            return JsonResponse::send('Product not found', 404);
        }

        $response =  $this->productService->update($args['products'], $product);

        if (!empty($response)) {
            return JsonResponse::send($response, 400);
        }

        return JsonResponse::send('Product updated successfully');
    }

    public function delete($args)
    {
        $product = $this->productService->getById($args['products']);

        if (!$product) {
            return JsonResponse::send('Product not found', 404);
        }

        $this->productService->delete($args['products']);

        return JsonResponse::send('Product deleted successfully');
    }
}
