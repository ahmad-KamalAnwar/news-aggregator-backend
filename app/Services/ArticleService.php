<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function getArticles($filters = [])
    {
        if (!empty($filters)) {
            $articles = Article::with(['source', 'category', 'author'])->where($filters)->paginate(10);
        } else {
            $articles = Article::with(['source', 'category', 'author'])->paginate(10);
        }

        return $articles;
    }
}
