<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function getArticles($filters = [])
    {
        if (!empty($filters)) {
            $articles = Article::where($filters)->paginate(10);
        } else {
            $articles = Article::paginate(10);
        }

        return $articles;
    }
}
