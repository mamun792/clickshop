<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\BlogRequest;
use App\Http\Requests\Admin\Product\ProductRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use FileUploadTrait;

    public function index()
    {
        $blogs = Blog::latest()->with('blog_category')->get();

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blog_category = BlogCategory::orderBy('name', 'asc')->get();
        return view('admin.blogs.create', compact('blog_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {

        // Validate the request data
        $validatedData = $request->validated();

        // dd($validatedData);

        // Handle featured image upload
        if ($request->hasFile('image')) {
            $validatedData['image'] = $this->uploadFile($request, 'image');
        }

        // Convert tags array to a comma-separated string
        if ($request->has('tags') && is_array($request->tags)) {
            $validatedData['tags'] = implode(',', $request->tags); // Convert array to string
        }

        // Create the blog entry in the database
        Blog::create($validatedData); // Pass the $validatedData directly

        return redirect()->back()->with('success', 'New blog has created');
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
        $blogs = Blog::findOrFail($id);


        // Decode the tags JSON string
        $blogs->tags = json_decode($blogs->tags, true);

        $blog_category = BlogCategory::orderBy('name', 'asc')->get();

        return view('admin.blogs.edit', compact('blogs', 'blog_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)

    {
        $blog = Blog::findOrFail($id);



        // Use the validated data from the BlogRequest
        $validatedData = $request->validated();

    

        if ($request->hasFile('image')) {
            // If there is an old image, delete it from the public directory
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }

            // Upload new image and set its path
            $imagePath = $this->uploadFile($request, 'image', $blog->image);
            $validatedData['image'] = $imagePath;
        }

        // Convert tags array to a comma-separated string
        if ($request->has('tags') && is_array($request->tags)) {
            $validatedData['tags'] = implode(',', $request->tags); // Convert array to string
        }

        // Update blog with the validated data
        $blog->update($validatedData);

        // Redirect with success message
        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $blog = Blog::find($id);

         // If there is an old image, delete it from the public directory
         if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }

        Blog::find($id)->delete();

        return redirect()->back()->with('success', 'Blog item deleted');
    }



}
