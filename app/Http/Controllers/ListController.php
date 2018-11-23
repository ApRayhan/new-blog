<?php

namespace App\Http\Controllers;


use App\Item;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function index()
    {
    	$lists = Item::all();
        return view('list', compact('lists'));
    }
    public function create(Request $request)
    {
    	$list = new Item();
    	$list->title = $request->title;
    	$list->save();
    	return 'done';
    }
    public function delete(Request $request)
    {
    	Item::whare('id', $request->id)->delete();
    	return $request->all();
    }
}
