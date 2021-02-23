<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting');
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required|image',
        ]);

        $image  = $request->file('image');
        $slug   = str_slug($request->name);

        $user = User::findOrFail(Auth::id());

        if (isset($image)) {

            // MAKE UNIQUE NAME FOR IMAGE
            $imagename = time() . '.' . $request->image->extension();

            // CHECK CATEGORY DERECTORY IS EXISTS

            if (!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }

            if (Storage::disk('public')->exists('profile/' . $user->image)) {
                Storage::disk('public')->delete('profile/' . $user->image);
            }

            // RESIZE IMAGE FOR CATEGORY AND UPLOAD
            $userImage = Image::make($image)->resize(500, 500)->save();
            Storage::disk('public')->put('post/' . $imagename, $userImage);
        } else {
            $imagename = $user->image;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imagename;
        $user->about = $request->about;
        $user->save();
        Toastr::success('Profile Successfully Updated:', 'success');
        return redirect()->back();
    }


    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password'  => 'required|confirmed',

        ]);

        $hashedPassword = Auth::user()->password;

        if(Hash::check($request->old_password,$hashedPassword))

         {

                    if(!Hash::check($request->password,$hashedPassword))
                    {
                        $user = User::find(Auth::id());
                        $user->password = Hash::make($request->password);
                        $user->save();
                        Toastr::success('Password Successfully Changed', 'Success');
                        Auth::logout();
                        return redirect()->back();
                    } else {

                        Toastr::error('New Password cannot be the same as old password', 'Error');
                        return redirect()->back();
                    }
        } else {

        Toastr::error('Current Password not Match', 'Error');
        return redirect()->back();
    }
}

}

