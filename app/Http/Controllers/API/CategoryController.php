<?php

namespace App\Http\Controllers\API;

use App\Services\CategoryService;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getCategories() {
        $response = $this->categoryService->getAllCatogories();

        return response($response, 201);
    }
}
