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

    public function getArticles(Request $request)
    {
        $user = auth()->user();
        $articles = $this->articleService->getArticles($request, $user);

        return response([
            'articles' => $articles
        ], 200);
    }
}
