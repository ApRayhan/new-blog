<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
   public function index()
    {
    	return view('author.settings');
    }
    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email',
    		'image' => 'image|mimes:jpg,png,jpeg'
    	]);
    	$image = $request->file('image');
    	$slug  = str_slug($request->name);
    	$user = User::findOrFail(Auth::id());
//      Check The Image Is Set Or Not Is Set Then Goging to the next Step
    	if (isset($image)) 
    	{
    		$time = Carbon::now()->toDateString();
    		$imagename = $slug. '-' . $time . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
 //      Chech The File is Exists Or not If Not Then Create The Folder
    		if (! Storage::disk('public')->exists('profileimg') ) {
    			Storage::disk('public')->makeDirectory('profileimg');
    		}
 //       Delete The Old Image
    		if (Storage::disk('public')->exists('profileimg/'. $user->image)) 
    		{
    			Storage::disk('public')->delete('profileimg/'. $user->image);
    		}
    		$profileimg = Image::make($image)->resize(500, 500)->save($image->getClientOriginalExtension());
    		Storage::disk('public')->put('profileimg/'.$imagename, $profileimg);
    	} else {
    		$imagename = $user->image;
    	}

    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->about = $request->about;
    	$user->image = $imagename;
    	$user->save();
    	Toastr::success('Profile SuccessFully Updated', 'Success');
    	return redirect()->back();
    }
    public function updatepassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        $haspassword = Auth::user()->password;
//      Check The old Password And input Field password match or not
        if (Hash::check($request->old_password, $haspassword)) 
        {
           if (!Hash::check($request->password, $haspassword)) 
           {
                $user = User::findOrFail(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password SuccessFully Changed', 'SuccessFull');
                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::info('The Old Password  and New Password Not be as Same', 'info');
                return redirect()->back();
            }

        } else {
            Toastr::info('The Old Password Is Not True', 'info');
            return redirect()->back();
        }
    }
}
