<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function getArticles($request)
    {
        $fromDate = null;
        $toDate = null;
        $filters = [];

        if ($request->query->has('sourceId')) {
            $filters['source_id'] = $request->get('sourceId');
        }

        if ($request->query->has('categoryId')) {
            $filters['category_id'] = $request->get('categoryId');
        }

        if ($request->query->has('fromDate')) {
            $fromDate = new \DateTime($request->get('fromDate'));
        }

        if ($request->query->has('toDate')) {
            $toDate = new \DateTime($request->get('toDate'));
            $toDate = $toDate->setTime(23,59,59);
        }

        if (!empty($filters)) {
            $articles = Article::with(['source', 'category', 'author'])->where($filters);

            if (!is_null($fromDate) && !is_null($toDate)) {
                $articles = $articles->whereBetween('published_at', [$fromDate, $toDate]);
            }

            $articles = $articles->paginate(10);
        } else {
            $articles = Article::with(['source', 'category', 'author'])->paginate(10);
        }

        return $articles;
    }
}
