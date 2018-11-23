<?php

namespace App\Http\Controllers;

use App\Comment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function add(Request $request , $id)
    {
    	$this->validate($request, [
    		'comment' => 'required'
    	]);
    	$comment = new Comment();
    	$comment->post_id = $id;
    	$comment->user_id = Auth::id();
    	$comment->comments = $request->comment;
    	$comment->save();
    	Toastr::success('Comment SuccessFully Posted', 'SuccessMsg');
    	return redirect()->back();
    }
}
