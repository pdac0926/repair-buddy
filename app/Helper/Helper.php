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

        $avatarsFromDatabase = User::pluck('avatar')->toArray();
        if (!in_array($avatar, $avatarsFromDatabase)) {
            File::delete(public_path($avatar));
        }
        return $path;
    }
}