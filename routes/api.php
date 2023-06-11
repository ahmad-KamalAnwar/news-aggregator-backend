<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SourceController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/preferences', [UserController::class, 'setUserPreferences']);
    Route::get('/user/preferences', [UserController::class, 'getUserPreferences']);
    Route::get('/article', [ArticleController::class, 'getArticles']);
    Route::get('/source', [SourceController::class, 'getSources']);
    Route::get('/category', [CategoryController::class, 'getCategories']);
    Route::get('/author', [AuthorController::class, 'getAuthors']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
