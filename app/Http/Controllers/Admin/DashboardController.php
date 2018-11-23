<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    	$post = Post::all();
    	$user = User::all();
    	$comments = Comment::all();
    	$top_post = Post::status()->approved()
    							->withCount('comments')
    							->withCount('favorite_to_users')
    							->orderBy('view_count', 'desc')
    							->orderBy('comments_count', 'desc')
    							->orderBy('favorite_to_users_count', 'desc')
    							->take(4)->get();
    	$top_user = User::withCount('posts')
    					->withCount('comments')
    					->withCount('user_favorite_posts')
    					->orderBy('posts_count', 'desc')
    					->orderBy('comments_count', 'desc')
    					->orderBy('user_favorite_posts_count', 'desc')
    					->take(5)->get();
    	$today_register = User::where('role_id', 2)
    						->whereDate('created_at', Carbon::today())
    						->count();
    	$panding_posts = Post::where('is_approved', false)->get();
    	$tag = Tag::all();
    	$category = Category::all();
    	return view('admin.dashboard', compact('post', 'user', 'top_post', 'top_user', 'today_register', 'panding_posts', 'tag', 'category', 'comments'));
    }
}
