<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * ArticleService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getArticles($request, $user)
    {
        $fromDate = null;
        $toDate = null;
        $filters = [];
        $preferences = $this->userService->getUserPrefrences($user);

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
        } else {
            $articles = Article::with(['source', 'category', 'author']);
        }

        if (!empty($preferences['sources'])) {
            $articles = $articles->whereIn('source_id', $preferences['sources']);
        }

        if (!empty($preferences['categories'])) {
            $articles = $articles->whereIn('category_id', $preferences['categories']);
        }

        if (!empty($preferences['authors'])) {
            $articles = $articles->whereIn('author_id', $preferences['authors']);
        }

        $articles = $articles->paginate(10);

        return $articles;
    }
}
