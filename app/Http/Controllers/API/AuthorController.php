<?php

namespace App\Http\Controllers\API;

use App\Services\AuthorService;
use Illuminate\Routing\Controller;

class AuthorController extends Controller
{
    /**
     * @var AuthorService
     */
    protected $authorService;

    /**
     * AuthorController constructor.
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function getAuthors() {
        $response = $this->authorService->getAllAuthors();

        return response($response, 201);
    }
}
