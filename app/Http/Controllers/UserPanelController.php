<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['findMeetups']);
    }

    public function findMeetups(Request $request)
    {
        $users = User::select(['name', 'email', 'created_at', 'gender', 'birth_date'])->where('name', $request->name)
            ->when(Auth::check(), function (Builder $query, string $role) {
                $query->whereNotIn('id', [Auth::id()]);
            })
            ->get();
        return response()->json($users);
    }

    public function changePass(ChangePassRequest $request)
    {
        $user = auth()->user();
        $user->password = Hash::make($request->get('newPassword'));
        $user->save();
        $request->session()->flash('message', __('User password changed'));
        return redirect()->back();
    }

    public function userPanel()
    {
        return view('user-panel');
    }

    public function updateUser(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'birthDate' => 'date|nullable',
            'gender' => 'in:male,female|nullable',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->birth_date = $request->birthDate;
        $user->gender = $request->gender;
        $user->save();
        $request->session()->flash('message', __('User data updated'));
        // $request->session()->flash('alert-class', 'alert-danger');
        return redirect()->back();
    }
}
