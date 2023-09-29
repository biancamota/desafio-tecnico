<?php

namespace Bm\Store\Controller;

use Bm\Store\Entity\Product;
use Bm\Store\Repository\CategoryRepository;
use Bm\Store\Repository\ProductRepository;
use Bm\Store\Util\JsonResponse;

class ProductController
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
        $this->categoryRepository = new CategoryRepository;
    }

    public function getAll()
    {
        $data = $this->productRepository->getAll();
        $products = [];
        foreach ($data as $product) {
            $products[] = $product->toJsonArray();
        }
        return JsonResponse::send($products);
    }

    public function getById($args)
    {
        $product = $this->productRepository->getById($args['products']);
        if (!$product) {
            return JsonResponse::send('Product not found', 404);
        }
        return JsonResponse::send($product->toJsonArray());
    }

    public function store($request)
    {
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return JsonResponse::send(['errors' => $validationErrors], 400);
        }

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->categoryId;

        $this->productRepository->create($product);

        return JsonResponse::send('Product saved successfully', 201);
    }

    public function update($request, $args)
    {
        $product = $this->productRepository->getById($args['products']);

        if (!$product) {
            return JsonResponse::send('Product not found', 404);
        }

        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return JsonResponse::send(['errors' => $validationErrors], 400);
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->categoryId;

        $this->productRepository->update($args['products'], $product);

        return JsonResponse::send('Product updated successfully');
    }

    public function delete($args)
    {
        $product = $this->productRepository->getById($args['products']);

        if (!$product) {
            return JsonResponse::send('Product not found', 404);
        }

        $this->productRepository->delete($args['products']);

        return JsonResponse::send('Product deleted successfully');
    }

    private function validate($product): array
    {
        $errors = [];

        if (empty($product->name) || empty($product->price) || empty($product->category_id)) {
            $errors[] = 'All fields (name, price, category) are required';
        }

        if (!is_numeric($product->price) || $product->price < 0) {
            $errors[] = 'Price must be a valid non-negative decimal number';
        }

        $existingCategory = $this->categoryRepository->getById($product->category_id);
        if (!$existingCategory) {
            $errors[] = 'Category not found';
        }

        return $errors;
    }
}
