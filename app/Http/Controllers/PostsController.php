<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function allposts()
    {
    	$posts = Post::latest()->approved()->status()->paginate(6);
    	return view('posts', compact('posts'));
    }
}
