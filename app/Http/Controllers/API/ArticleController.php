<?php

namespace App\Http\Controllers\API;

use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ArticleController extends Controller
{
    /**
     * @var ArticleService
     */
    protected $articleService;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function getArticles(Request $request) {
        $filters = [];

        if ($request->query->has('sourceId')) {
            $filters['sourceId'] = $request->get('sourceId');
        }

        if ($request->query->has('categoryId')) {
            $filters['categoryId'] = $request->get('categoryId');
        }

        if ($request->query->has('authorId')) {
            $filters['authorId'] = $request->get('authorId');
        }

        $articles = $this->articleService->getArticles($filters);

        return response([
            'articles' => $articles
        ], 200);
    }
}
