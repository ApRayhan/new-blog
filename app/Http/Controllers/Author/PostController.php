<?php

namespace App\Http\Controllers\Author;

use App\Category;
use App\Http\Controllers\Controller;
use App\Notifications\Newpostbyauthor;
use App\Post;
use App\Tag;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('author.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorys = Category::all();
        $tags = Tag::all();
        return view('author.post.create', compact('categorys', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required',
            'categorys' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
//      Take The Image From input Fild
        $image = $request->file('image');
//      Make The Titles Slug name
        $slug = str_slug($request->title);
//      Check The Image Is Set Or Not
        if (isset($image)) 
        {
//          Take The Corrent Date & Time
            $time = Carbon::now()->toDateString();
//          Make A Uniq Name For Image
            $imagename = $slug. '-'.  $time. '-'. uniqid(). '.'.$image->getClientOriginalExtension();
//          Check The Post Folder Is Exists Or Not If Not Then Create The Folder
            if (!Storage::disk('public')->exists('post')) 
            {
                 Storage::disk('public')->makeDirectory('post');
            } 
//          Resize The Image
            $postimg = Image::make($image)->resize(1600, 1066)->save($image->getClientOriginalExtension());
//          Now Move The Image in The Post Folder
            Storage::disk('public')->put('post/'.$imagename, $postimg);
        } else {
            $imagename = "default.png";
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title   = $request->title;
        $post->slug    = $slug;
        $post->image   = $imagename;
        $post->body    = $request->body;
        $post->is_approved = false;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->save();
        $post->categorys()->attach($request->categorys);
        $post->tags()->attach($request->tags);
        $user = User::where('role_id', 1)->get();
        Notification::send($user, new Newpostbyauthor($post));
        Toastr::success('Post SuccessFully Added :)' , 'success');
        return redirect()->route('author.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if ($post->user_id != Auth::id()) 
        {
            Toastr::info('You Do Not Have Any permition To Exis The Post', 'info');
            return redirect()->back();
        }
        return view('admin.post.show', compact('post')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if ($post->user_id != Auth::id()) 
        {
            Toastr::info('You Do Not Have Any permition To Edit The Post', 'info');
            return redirect()->back();
        }
        $categorys = Category::all();
        $tags = Tag::all();
        return view('author.post.edit', compact('categorys', 'tags', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id != Auth::id()) 
        {
            Toastr::info('You Do Not Have Any permition To Edit The Post', 'info');
            return redirect()->back();
        }
        $this->validate($request, [
            'title' => 'required',
            'image' => 'image',
            'categorys' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
//      Take The Image From input Fild
        $image = $request->file('image');
//      Make The Titles Slug name
        $slug = str_slug($request->title);
//      Check The Image Is Set Or Not
        if (isset($image)) 
        {
//          Take The Corrent Date & Time
            $time = Carbon::now()->toDateString();
//          Make A Uniq Name For Image
            $imagename = $slug. '-'.  $time. '-'. uniqid(). '.'.$image->getClientOriginalExtension();
//          Check The Post Folder Is Exists Or Not If Not Then Create The Folder
            if (!Storage::disk('public')->exists('post')) 
            {
                 Storage::disk('public')->makeDirectory('post');
            } 
//          Delete Old Image From Post Folder
            if (Storage::disk('public')->exists('post/'.$post->image)) 
            {
                Storage::disk('public')->delete('post/'.$post->image);
            }
//          Resize The Image
            $postimg = Image::make($image)->resize(1600, 1066)->save($image->getClientOriginalExtension());
//          Now Move The Image in The Post Folder
            Storage::disk('public')->put('post/'.$imagename, $postimg);
        } else {
            $imagename = $post->image;
        }
        $post->user_id = Auth::id();
        $post->title   = $request->title;
        $post->slug    = $slug;
        $post->image   = $imagename;
        $post->body    = $request->body;
        $post->is_approved = false;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->save();
        $post->categorys()->sync($request->categorys);
        $post->tags()->sync($request->tags);
        Toastr::success('Post SuccessFully Updated :)' , 'success');
        return redirect()->route('author.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->user_id != Auth::id()) 
        {
            Toastr::info('You Do Not Have Any permition To Edit The Post', 'info');
            return redirect()->back();
        }
        if (Storage::disk('public')->exists('post/'. $post->image)) 
        {
            Storage::disk('public')->delete('post/'. $post->image);
        }
        $post->categorys()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Post SuccessFully Deleted', 'Success');
        return redirect()->back();
    }
}
