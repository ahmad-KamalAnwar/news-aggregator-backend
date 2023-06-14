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
            $existingPreferences = $this->getUserPrefrences($user);
            $this->addPreferences($user, $preferences, $existingPreferences);
            $this->removePreferences($user, $preferences, $existingPreferences);
        }

        return $this->getUserPrefrences($user);
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

    private function addPreferences($user, $preferences, $existingPreferences)
    {
        if (!empty($preferences['sources'])) {
            $sources = Source::whereIn('id', $preferences['sources'])->get();

            foreach ($sources as $source) {
                if (!in_array($source->id, $existingPreferences['sources'])) {
                    $user->source()->save($source);
                }
            }
        }

        if (!empty($preferences['categories'])) {
            $categories = Category::whereIn('id', $preferences['categories'])->get();

            foreach ($categories as $category) {
                if (!in_array($category->id, $existingPreferences['categories'])) {
                    $user->category()->save($category);
                }
            }
        }

        if (!empty($preferences['authors'])) {
            $authors = Author::whereIn('id', $preferences['authors'])->get();

            foreach ($authors as $author) {
                if (!in_array($author->id, $existingPreferences['authors'])) {
                    $user->author()->save($author);
                }
            }
        }
    }

    private function removePreferences($user, $preferences, $existingPreferences)
    {
        if (!empty($preferences['sources'])) {
            foreach ($existingPreferences['sources'] as $existingSourceId) {
                if (!in_array($existingSourceId, $preferences['sources'])) {
                    $source = Source::where('id', $existingSourceId)->first();

                    if ($source) {
                        $source->user($user->id)->detach();
                    }
                }
            }
        }

        if (!empty($preferences['categories'])) {
            foreach ($existingPreferences['categories'] as $existingCategoryId) {
                if (!in_array($existingCategoryId, $preferences['categories'])) {
                    $category = Category::where('id', $existingCategoryId)->first();
                    $category->user($user)->detach();
                }
            }
        }

        if (!empty($preferences['authors'])) {
            foreach ($existingPreferences['authors'] as $existingAuthorId) {
                if (!in_array($existingAuthorId, $preferences['authors'])) {
                    $author = Author::where('id', $existingAuthorId)->first();
                    $author->user($user)->detach();
                }
            }
        }
    }
}
