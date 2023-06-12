<?php

namespace App\Services;


use App\Models\Source;

class UserService
{
    public function setUserPreferences($user, $preferences = [])
    {
        if (!empty($preferences)) {
            if (isset($preferences['sources'])) {
                $source = Source::whereIn('id', [1,2,3])->get();
                dd($source);
            }
            dd($user, $preferences);
        }

        return true;
    }
}
