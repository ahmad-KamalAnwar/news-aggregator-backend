<?php

namespace App\Services;

use App\Models\Source;

class SourceService
{
    public function getAllSources()
    {
        $sources = Source::all();

        return $sources;
    }

}
