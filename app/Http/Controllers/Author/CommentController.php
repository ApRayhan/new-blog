<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
    	$comments = Auth::user()->posts->comments;
    	return view('author.comments', compact('comments'));
    }

    public function delete($id)
    {
    	# code...
    }
}
