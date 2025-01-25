<?php

namespace App\Http\Controllers\Admin\BlogCategory;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog_categories = BlogCategory::latest()->get();

        return view('admin.blog-category.index', compact('blog_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'slug' => 'required|string|max:255|unique:blog_categories,slug',
        ]);

        // Save to database
        BlogCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        // Redirect with success message
        return redirect()->route('blog-category.index')->with('success', 'Blog category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        return view('admin.blog-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = BlogCategory::findOrFail($id);

        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $id,
            'slug' => 'required|string|max:255|unique:blog_categories,slug,' . $id,
        ]);

        // Update the category
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        // Redirect with success message
        return redirect()->route('blog-category.index')->with('success', 'Blog category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        BlogCategory::find($id)->delete();

        return redirect()->back()->with('success', 'Category item deleted');
    }


    public function toggleStatus(Request $request)
    {
        $category = BlogCategory::findOrFail($request->id);

        // Update the status
        $category->status = $request->status;
        $category->save();

        return response()->json(['success' => true, 'status' => $category->status]);
    }



}
