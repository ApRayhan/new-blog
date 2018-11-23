<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = Category::latest()->get();
        return view('admin.category.index', compact('categorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//      Validate all Data
        $this->validate($request, [
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpg,png,jpeg',
        ]);
//      Take The Image 
        $image = $request->file('image');
        $slug = str_slug($request->name);

        if (isset($image)) {
//          Corrent Date & Time
            $time = Carbon::now()->toDateString();
//           Make Image Unique Name
            $imagename = $slug . '-' . $time . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//         Ceck The Folder is Exists or not if Not Exists Then Create New Folder 
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }
//          Resize Image For Category
            $categoryimg = Image::make($image)->resize(1600, 479)->save($image->getClientOriginalExtension());
//          Then Image Save In Category Folder
            Storage::disk('public')->put('category/'.$imagename, $categoryimg);

//         Ceck The Folder is Exists or not if Not Exists Then Create New Folder 
            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }
//          Resize Image For Category Slider
            $categorysliderimg = Image::make($image)->resize(500, 333)->save($image->getClientOriginalExtension());
//          Then Image Save In Slider Folder
            Storage::disk('public')->put('category/slider/'.$imagename, $categorysliderimg);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category SuccessFully Added', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//      Validate all Data
        $this->validate($request, [
            'name' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
        ]);
//      Take The Image 
        $category = Category::find($id);
        $image = $request->file('image');
        $slug = str_slug($request->name);

        if (isset($image)) {
//          Corrent Date & Time
            $time = Carbon::now()->toDateString();
//           Make Image Unique Name
            $imagename = $slug . '-' . $time . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//         Ceck The Folder is Exists or not if Not Exists Then Create New Folder 
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }
//          Delete Old Category Image From Category
            if (Storage::disk('public')->exists('category/'.$category->image)) {
                Storage::disk('public')->delete('category/'.$category->image);
            }
//          Resize Image For Category
            $categoryimg = Image::make($image)->resize(1600, 479)->save($image->getClientOriginalExtension());
//          Then Image Save In Category Folder
            Storage::disk('public')->put('category/'.$imagename, $categoryimg);

//         Ceck The Folder is Exists or not if Not Exists Then Create New Folder 
            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }
//          Delete Old Category Slider Image From Category
            if (Storage::disk('public')->exists('category/slider/'.$category->image)) {
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }
//          Resize Image For Category Slider
            $categorysliderimg = Image::make($image)->resize(500, 333)->save($image->getClientOriginalExtension());
//          Then Image Save In Slider Folder
            Storage::disk('public')->put('category/slider/'.$imagename, $categorysliderimg);
        } else {
        $imagename = $category->image;
    }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category SuccessFully Deleted :)', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
//      Delete The Category Image
        if (Storage::disk('public')->exists('category/'. $category->image)) {
            Storage::disk('public')->delete('category/'. $category->image);
        }
//      Delete The Category Slider Image
        if (Storage::disk('public')->exists('category/slider/'. $category->image)) {
            Storage::disk('public')->delete('category/slider/'. $category->image);
        }
        $category->delete();
        Toastr::success('Category SuccessFully Deleted :)', 'success');
        return redirect()->route('admin.category.index');
    }
}
