<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCatogories()
    {
        $categories = Category::all();

        return $categories;
    }
}
