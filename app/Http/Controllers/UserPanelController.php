<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['findMeetups']);
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
        $newProfilePhotoName = '';
        if (!$request->profilePhotoNotEmpty) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $user->profile_photo = null;
        } elseif ($request->hasFile('profilePhoto')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $newProfilePhotoName = $request->file('profilePhoto')->hashName();
            $user->profile_photo = "profilePhoto/$newProfilePhotoName";
        }

        $user->save();

        if ($newProfilePhotoName) {
            $request->file('profilePhoto')->storeAs(
                'profilePhoto',
                $newProfilePhotoName,
                'public'
            );
        }
        $request->session()->flash('message', __('User data updated'));
        // $request->session()->flash('alert-class', 'alert-danger');
        return redirect()->back();
    }
}
