<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
    	$user     = Auth::user();
    	$post     = $user->posts;
    	$top_post =  $user->posts()->status()->approved()
    					  ->withCount('comments')
    					  ->withCount('favorite_to_users')
    					  ->orderBy('view_count', 'desc')
    					  ->orderBy('comments_count', 'desc')
    					  ->orderBy('favorite_to_users_count', 'desc')
    					  ->take(5)->get();
    	$pending_post = $user->posts()->where('is_approved', false)->get();
    	$total_view = $post->sum('view_count');
    	return view('author.dashboard', compact('top_post', 'pending_post', 'total_view'));
    }
}
