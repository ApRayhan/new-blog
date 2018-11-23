<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function index()
    {
    	$authors = User::author()
    					->withCount('posts')
    					->withCount('comments')
    					->withCount('user_favorite_posts')
    					->get();
    	return view('admin.authors', compact('authors'));
    }

    public function destroy($id)
    {
    	return $id;
    }
}
