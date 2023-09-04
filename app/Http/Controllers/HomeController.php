<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'changeLocale']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('home');
    }

    public function aboutUs()
    {
        return view('about-us');
    }

    public function contact()
    {
        return view('contact');
    }

    public function changeLocale(Request $request)
    {
        $routeParameters = json_decode(urldecode($request->routeParameters), true);
        $routeParameters['__locale'] = $request->__locale;
        return redirect()->route($request->currentRouteName, $routeParameters);
    }
}
