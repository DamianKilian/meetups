<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;

class AppService
{
    public static function setLocaleFromPrefix()
    {
        $segment1 = request()->segment(1);
        // $segment1 must be locale (must be in 'app.available_locales')
        if (in_array($segment1, Config::get('app.available_locales'))) {
            app()->setLocale($segment1);
            Cookie::queue('locale', $segment1, 576000, '/');
        } elseif ($segment1) {
            abort(404);
        }
        URL::defaults(['__locale' => app()->getLocale()]);
    }

    public static function trans($key)
    {
        $locale = app()->getLocale();
        if (request()->getDefaultLocale() === $locale) {
            return $key;
        }
        $trans = json_decode(file_get_contents(base_path() . "/resources/lang/routes/$locale.json"), true);
        return $trans[$key];
    }
}
