<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Tag::all(); 
 
        return view('categories.index', compact('categories'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Tag::create([
            'name' => $request->input('name'),
        ]);
 
        return redirect()->route('categories.index');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $category)
    {
        //
        return view('categories.edit',  ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $category)
    {
        //Modifier la balise
        $category->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('categories.index'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('categories.index');
        //
    }
}
