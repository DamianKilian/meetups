<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
            'email' => 'required|string|email|unique:users,email,'.$user->id,
            'birthDate' => 'date|nullable',
            'gender' => 'in:male,female,nullable',
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
