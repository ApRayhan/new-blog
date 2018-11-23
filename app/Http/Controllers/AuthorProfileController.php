<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthorProfileController extends Controller
{
    public function index($username)
    {
    	$user = User::where('user_name', $username)->first();
    	$posts = $user->posts()->approved()->status()->get();
    	
    	return view('authorprofile', compact('user', 'posts'));
    }
}
