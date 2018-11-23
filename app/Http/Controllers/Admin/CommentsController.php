<?php

namespace App\Http\Controllers\admin;

use App\Comment;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index()
    {
    	$comments = Comment::latest()->get();
    	return view('admin.comments', compact('comments'));
    }
    public function delete($id)
    {
    	Comment::findOrFail($id)->delete();
    	Toastr::success('Comment SuccessFully Deleted', 'Success');
    	return redirect()->back();
    }
}
