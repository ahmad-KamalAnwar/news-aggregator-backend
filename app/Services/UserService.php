<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Models\User;

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

    public function getUserPrefrences($user)
    {
        $sources = [];
        $categories = [];
        $authors = [];
        $user = User::find($user->id);

        if (!empty($user->source)) {
            foreach ($user->source as $source) {
                $sourceId = $source->pivot->preferable_id;
                if (!in_array($sourceId, $sources)) {
                    $sources[] .= $source->pivot->preferable_id;
                }
            }
        }

        if (!empty($user->category)) {
            foreach ($user->category as $category) {
                $categoryId = $category->pivot->preferable_id;
                if (!in_array($categoryId, $categories)) {
                    $categories[] .= $category->pivot->preferable_id;
                }
            }
        }

        if (!empty($user->author)) {
            foreach ($user->author as $author) {
                $authorId = $author->pivot->preferable_id;
                if (!in_array($authorId, $authors)) {
                    $authors[] .= $author->pivot->preferable_id;
                }
            }
        }

        return [
            'sources' => $sources,
            'authors' => $authors,
            'categories' => $categories
        ];
    }
}
