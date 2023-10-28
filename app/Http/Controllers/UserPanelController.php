<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassRequest;
use App\Models\PrivMessage;
use App\Models\PrivTalk;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getFromAndToStr($toUserId)
    {
        $user = auth()->user();
        return $user->id > $toUserId ? $user->id . '&' . $toUserId : $toUserId . '&' . $user->id;
    }

    public function getPrivMessages(Request $request)
    {
        $fromAndToStr = $this->getFromAndToStr($request->toUserId);
        $privMessages = DB::table('priv_messages')
            ->select('priv_messages.id', 'priv_messages.priv_message')
            ->join('priv_talks', 'priv_messages.priv_talk_id', '=', 'priv_talks.id')
            ->where('priv_talks.from_and_to_virtual', $fromAndToStr)->limit($request->privMessagesNum)->get();
        return response()->json([
            'privMessages' => $privMessages,
        ]);
    }

    public function getPrivTalk(Request $request)
    {
        $privTalkId = null;
        $fromAndToStr = $this->getFromAndToStr($request->toUserId);
        $privTalk = PrivTalk::where('from_and_to_virtual', $fromAndToStr)->first();
        if ($privTalk) {
            $privTalkId = $privTalk->id;
        }
        return response()->json([
            'privTalkId' => $privTalkId,
        ]);
    }

    public function privMessage(Request $request)
    {
        $user = auth()->user();
        $fromAndToStr = $this->getFromAndToStr($request->toUserId);
        $privTalk = PrivTalk::where('from_and_to_virtual', $fromAndToStr)->first();
        if (!$privTalk) {
            $privTalk = PrivTalk::create([
                'from_user_id' => $user->id,
                'to_user_id' => $request->toUserId,
            ]);
        }
        PrivMessage::create([
            'priv_message' => $request->privMessage,
            'user_id' => $user->id,
            'priv_talk_id' => $privTalk->id,
        ]);
        return response()->json([
            'privTalkId' => $privTalk->id,
        ]);
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
        $regionJson = Region::select(['name', 'id'])->where('id', auth()->user()->region_id)->first()->toJson();
        return view('user-panel', [
            'regionJson' => $regionJson,
        ]);
    }

    public function updateUser(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'birthDate' => 'date|nullable',
            'gender' => 'in:male,female|nullable',
            'region' => 'nullable',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->birth_date = $request->birthDate;
        $user->gender = $request->gender;
        $user->region_id = $request->region;
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
