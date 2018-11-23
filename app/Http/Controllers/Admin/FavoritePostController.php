<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritePostController extends Controller
{
    public function index()
    {
    	$posts = Auth::user()->user_favorite_posts;
    	return view('admin.favorite', compact('posts'));
    }
    public function destroy($id)
    {
    	return $id;
    }
}
