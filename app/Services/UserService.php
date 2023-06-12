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
                $sources = Source::whereIn('id', $preferences['sources'])->get();

                foreach ($sources as $source) {
                    $user->source()->save($source);
                }
            }

            if (isset($preferences['categories'])) {
                $categories = Category::whereIn('id', $preferences['categories'])->get();

                foreach ($categories as $category) {
                    $user->category()->save($category);
                }
            }

            if (isset($preferences['authors'])) {
                $authors = Author::whereIn('id', $preferences['authors'])->get();

                foreach ($authors as $author) {
                    $user->author()->save($author);
                }
            }
        }

        return $user;
    }
}
