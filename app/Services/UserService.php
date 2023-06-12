<?php

namespace App\Services;


use App\Models\Author;
use App\Models\Category;
use App\Models\Source;

class UserService
{
    public function setUserPreferences($user, $preferences = [])
    {
        if (!empty($preferences)) {
            if (isset($preferences['sources'])) {
                $source = Source::whereIn('id', $preferences['sources'])->get();
            }

            if (isset($preferences['categories'])) {
                $category = Category::whereIn('id', $preferences['sources'])->get();
            }

            if (isset($preferences['authors'])) {
                $author = Author::whereIn('id', $preferences['auhors'])->get();
            }


        }

        return true;
    }
}
