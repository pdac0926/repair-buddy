<?php

namespace App\Helper;

use App\Models\User;
use Illuminate\Support\Facades\App;
use File;

class Helper
{
    public static function userAvatar($avatar)
    {
        if (!App::environment(['local', 'staging']) || !app()->environment(['local', 'staging'])) {
            $path = 'storage/public/' . $avatar;
        } else {
            $path = 'storage/' . $avatar;
        }
        return $path;
    }
}