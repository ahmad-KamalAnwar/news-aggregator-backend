<?php

namespace App\Http\Controllers\API;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function setUserPreferences(Request $request) {
        $preferences = [];
        $user = auth()->user();

        if ($request->has('sources')) {
            $preferences['sources'] = $request->get('sources');
        }

        if ($request->has('categories')) {
            $preferences['categories'] = $request->get('categories');
        }

        if ($request->has('authors')) {
            $preferences['authors'] = $request->get('authors');
        }

        $response = $this->userService->setUserPreferences($user, $preferences);

        return response($response, 201);
    }

    public function getUserPreferences(Request $request) {
        $user = auth()->user();
        $response = $this->userService->getUserPrefrences($user);

        return response($response, 200);
    }
}
