<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function getArticles($request)
    {
        $from = null;
        $until = null;
        $filters = [];

        if ($request->query->has('sourceId')) {
            $filters['source_id'] = $request->get('sourceId');
        }

        if ($request->query->has('categoryId')) {
            $filters['category_id'] = $request->get('categoryId');
        }

        if ($request->query->has('from')) {
            $from = new \DateTime($request->get('from'));
        }

        if ($request->query->has('until')) {
            $until = new \DateTime($request->get('until'));
            $until = $until->setTime(23,59,59);
        }

        if (!empty($filters)) {
            $articles = Article::with(['source', 'category', 'author'])->where($filters);

            if (!is_null($from) && !is_null($until)) {
                $articles = $articles->whereBetween('published_at', [$from, $until]);
            }

            $articles = $articles->paginate(10);
        } else {
            $articles = Article::with(['source', 'category', 'author'])->paginate(10);
        }

        return $articles;
    }
}
