<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class AppService
{
    public static function setLocaleFromPrefix()
    {
        $segment1 = request()->segment(1);
        $locale = null;
        if (in_array($segment1, Config::get('app.available_locales'))) {
            $locale = $segment1;
            app()->setLocale($locale);
        }
        return $locale;
    }
}
