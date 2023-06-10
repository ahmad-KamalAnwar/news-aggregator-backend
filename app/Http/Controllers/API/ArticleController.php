<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class ArticleController extends Controller
{
    public function getArticles(Request $request) {
        // implement filters source, author and category
        // get Article
    }
}
