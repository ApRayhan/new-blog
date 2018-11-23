<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function show($slug)
    {
    	$post = Post::where('slug', $slug)->first();
    	$randomposts = Post::all()->random(3);
    	$blogkey = 'blog_' . $post->id;
    	if (!Session::has($blogkey)) 
    	{
    		$post->increment('view_count');
    		Session::put($blogkey, 1);
    	}
    	return view('post', compact('post', 'randomposts'));
    }

    public function categoryByPost($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->approved()->status()->get();
        return view('categorybypost', compact('category', compact('posts')));
    }

    public function categoryBytags($slug)
    {
        $tags = Tag::where('slug', $slug)->first();
        $posts = $tags->posts()->approved()->status()->get();
        return view('postbytag', compact('tags', 'posts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $posts = Post::where('title', 'LIKE', "% $query %")->get();
        return view('search', compact('posts', 'query'));
    }
}
