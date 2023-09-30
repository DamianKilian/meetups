<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'changeLocale', 'getRegions', 'findMeetups']);
    }

    public function getRegions()
    {
        return response()->json(Region::select(['id', 'name'])->get());
    }

    public function findMeetups(Request $request)
    {
        $users = User::select(['name', 'email', 'created_at', 'gender', 'birth_date', 'profile_photo'])
            ->when(Auth::id(), function (Builder $query, int $id) {
                $query->whereNotIn('id', [$id]);
            })
            ->when($request->name, function (Builder $query, string $name) {
                if (2 < strlen($name)) {
                    $query->where('name', 'like', "%$name%");
                }
            })
            ->when($request->email, function (Builder $query, string $email) {
                $query->where('email', $email);
            })
            ->when($request->gender, function (Builder $query, string $gender) {
                $query->where('gender', $gender);
            })
            ->when($request->fromBirthDate, function (Builder $query, string $fromBirthDate) {
                $query->whereDate('birth_date', '>=', $fromBirthDate);
            })
            ->when($request->toBirthDate, function (Builder $query, string $toBirthDate) {
                $query->whereDate('birth_date', '<=', $toBirthDate);
            })
            ->when($request->region, function (Builder $query, string $region) {
                $query->where('region_id', $region);
            })
            ->limit(5)
            ->get();
        foreach ($users as $user) {
            $user->profile_photo = $user->profile_photo ? asset(asset('storage/' . $user->profile_photo)) : null;
        }
        return response()->json($users);
    }

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
