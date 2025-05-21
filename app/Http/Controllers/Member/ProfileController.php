<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\Subscription;
use App\Models\TransactionDetail;
use App\Models\UserSub;
use App\Traits\HasImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use HasImage;

    public function index()
    {
        // get user login
        $user = Auth::user();
        $subs = Subscription::first();
        $plan = "";
        $rm_date = "";
        // remain date
        $remain_days = UserSub::where('user_id', Auth::id())->first()?->remain_date ?? false;
        
        if($remain_days) {
            // get series count
            $series_count = TransactionDetail::whereHas('transaction', function ($q) use ($user) {
                $q->where('user_id', $user->id);
                $q->where('status', 1);
            })->count();            

            if($series_count == 1) {
                $plan = "Beginner";
            } elseif($series_count == 2) {
                $plan = "Intermediate";
            } elseif($series_count == 3) {
                $plan = "Advanced";
            }           

            $from = Carbon::parse($remain_days)->startOfDay();
            $now = Carbon::now()->startOfDay();
            $diffInDays = $from->diffInDays($now, false); 

            if ($diffInDays > 0) {
                $rm_date = "Expired";
            } elseif ($diffInDays === 0) {
                $rm_date = "Today";
            } else {
                $rm_date = "" . abs($diffInDays) . " days left";
            }
            
        }

        // return to view
        return view('member.profile.index', compact('user', 'subs', 'rm_date', 'plan'));
    }

    public function updateProfile(Request $request, User $user)
    {
        // call method uploadImage from trait hasImage
        $avatar = $this->uploadImage($request, $path = 'public/avatars/', $name='avatar');

        // get request data from input
        $data = $request->except('avatar');

        // update user
        $user->update($data);

        // check if user upload new avatar
        if($request->file('avatar')){
            // delete old avatar
            Storage::disk('local')->delete('public/avatars/'. basename($user->avatar));

            // update user avatar
            $user->update([
                'avatar' => $avatar->hashName(),
            ]);
        }
        // return back with toastr
        return back()->with('toast_success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request, User $user)
    {
        // validate request
        $request->validate([
            'password' => 'confirmed|required|min:6',
        ]);

        // check old password
        if(!(Hash::check($request->get('current_password'), Auth::user()->password))){
            return back()->with('toast_error', 'Your current password does not matches with the password you provided.');
        }else{
            // update old password
            $user->update([
                'password' => Hash::make($request->get('password')),
            ]);
        }

        // return back with toastr
        return back()->with('toast_success', 'Password changed successfully');
    }
}
