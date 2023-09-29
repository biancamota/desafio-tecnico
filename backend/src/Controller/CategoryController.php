<?php

namespace Bm\Store\Controller;

use Bm\Store\Entity\Category;
use Bm\Store\Repository\CategoryRepository;
use Bm\Store\Util\JsonResponse;

class CategoryController
{
    protected $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository;
    }

    public function getAll()
    {
        $data = $this->categoryRepository->getAll();
        $categories = [];
        foreach ($data as $category) {
            $categories[] = $category->toJsonArray();
        }
        return JsonResponse::send($categories);
    }

    public function getById($args)
    {
        $category = $this->categoryRepository->getById($args['categories']);
        if (!$category) {
            return JsonResponse::send('Category not found', 404);
        }
        return JsonResponse::send($category->toJsonArray());
    }

    public function store($request)
    {
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return JsonResponse::send(['errors' => $validationErrors], 400);
        }

        $category = new Category;
        $category->name = $request->name;

        $this->categoryRepository->create($category);

        return JsonResponse::send('Category saved successfully', 201);
    }

    public function update($request, $args)
    {
        $category = $this->categoryRepository->getById($args['categories']);

        if (!$category) {
            return JsonResponse::send('Category not found', 404);
        }

        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return JsonResponse::send(['errors' => $validationErrors], 400);
        }

        $category->name = $request->name;

        $this->categoryRepository->update($args['categories'], $category);

        return JsonResponse::send('Category updated successfully');
    }

    public function delete($args)
    {
        $category = $this->categoryRepository->getById($args['categories']);

        if (!$category) {
            return JsonResponse::send('Category not found', 404);
        }

        $this->categoryRepository->delete($args['categories']);

        return JsonResponse::send('Category deleted successfully');
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
}
