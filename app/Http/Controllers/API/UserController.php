<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function setUserPreferences(Request $request) {
        $user = auth()->user();
        $type = 'source';
//        incomplete

        $response = [];
        return response($response, 201);
    }

    public function getUserPreferences(Request $request) {
        $user = auth()->user();
        $user = User::find($user->id);
        $response = [
            'source' => $user->source,
            'author' => $user->author,
            'categories' => $user->category
        ];

        return response($response, 201);
    }
}
