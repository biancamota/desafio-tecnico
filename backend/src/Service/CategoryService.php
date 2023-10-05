<?php

namespace Bm\Store\Service;

use Bm\Store\Entity\Category;
use Bm\Store\Repository\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository;
    }

    public function getAll(): array
    {
        $data = $this->categoryRepository->getAll();
        $categories = [];
        foreach ($data as $category) {
            $categories[] = $category->toJsonArray();
        }
        return $categories;
    }

    public function getById($args)
    {
        $category = $this->categoryRepository->getById($args);

        return $category ? $category->toJsonArray() : null;
    }

    public function store($request)
    {
        $response = [];
        $this->parsedDataRequest($request);
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            $response['errors'] = $validationErrors;
        }

        $category = new Category;
        $category->name = $request->name;
        $category->taxe = $request->taxe;

        $this->categoryRepository->create($category);

        return $response;
    }

    public function update($request, $args)
    {
        $category = $this->categoryRepository->getById($args);

        if (!$category) {
            return ['Category not found'];
        }

        $this->parsedDataRequest($request);
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            $response['errors'] = $validationErrors;
        }

        $category->name = $request->name;
        $category->taxe = $request->taxe;

        $this->categoryRepository->update($args, $category);

        return [];
    }

    public function delete($args)
    {
        $this->categoryRepository->delete($args);

        return [];
    }

    private function validate($category): array
    {
        $errors = [];

        if (empty($category->name)) {
            $errors[] = 'Category name cannot be empty';
        }

        $existingCategory = $this->categoryRepository->getWhere('name', $category->name);
        if (!empty($existingCategory)) {
            $errors[] = 'Category with the same name already exists';
        }

        return $errors;
    }

    private function parsedDataRequest(&$request)
    {
        $request->taxe = $request->taxe ? (float) $request->taxe : 0;
    }
}
