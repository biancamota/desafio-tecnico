<?php

namespace Bm\Store\Service;

use Bm\Store\Entity\Product;
use Bm\Store\Repository\CategoryRepository;
use Bm\Store\Repository\ProductRepository;

class ProductService
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
        return $products;
    }

    public function getById($args)
    {
        $product = $this->productRepository->getById($args);

        return $product ? $product->toJsonArray() : null;
    }

    public function store($request)
    {
        $this->parsedDataRequest($request);
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return ['errors' => $validationErrors];
        }

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        $this->productRepository->create($product);

        return [];
    }

    public function update($request, $args)
    {
        $product = $this->productRepository->getById($args);

        if (!$product) {
            return ['Product not found'];
        }

        $this->parsedDataRequest($request);
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return ['errors' => $validationErrors];
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        $this->productRepository->update($args, $product);

        return [];
    }

    public function delete($args)
    {
        $this->productRepository->delete($args);

        return [];
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

    private function parsedDataRequest(&$request)
    {
        $request->price = (float) $request->price;
        $request->category_id = (int) $request->category_id;
    }
}
