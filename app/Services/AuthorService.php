<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function getAllAuthors()
    {
        $authors = Author::all();

        return $authors;
    }
}
