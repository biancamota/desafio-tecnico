<?php

namespace Bm\Store\Controller;

use Bm\Store\Service\CategoryService;
use Bm\Store\Util\JsonResponse;

class CategoryController
{
    protected $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService;
    }

    public function getAll()
    {
        $categories = $this->categoryService->getAll();

        return JsonResponse::send($categories);
    }

    public function getById($args)
    {
        $category = $this->categoryService->getById($args['categories']);

        if (!$category) {
            return JsonResponse::send('Category not found', 404);
        }
        return JsonResponse::send($category);
    }

    public function store($request)
    {
        $response = $this->categoryService->store($request);

        if (!empty($response)) {
            return JsonResponse::send($response, 400);
        }

        return JsonResponse::send('Category saved successfully', 201);
    }

    public function update($request, $args)
    {
        $response = $this->categoryService->update($request, $args['categories']);

        if (!empty($response)) {
            return JsonResponse::send($response, 400);
        }

        return JsonResponse::send('Category updated successfully');
    }

    public function delete($args)
    {
        $category = $this->categoryService->getById($args['categories']);

        if (!$category) {
            return JsonResponse::send('Category not found', 404);
        }

        $this->categoryService->delete($args['categories']);

        return JsonResponse::send('Category deleted successfully');
    }
}
