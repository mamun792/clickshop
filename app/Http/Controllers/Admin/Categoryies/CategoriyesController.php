<?php

namespace App\Http\Controllers\Admin\Categoryies;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Admin\category\CategoryService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class CategoriyesController extends Controller
{

    use FileUploadTrait;




    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {


        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'slug' => 'nullable|unique:categories,slug,',
            'status' => 'nullable|in:active,deactive',
        ]);

        // Upload image and get path if image is provided
        if ($request->hasFile('image')) {
            // Call the uploadFile method to handle the file upload
            $data['image'] = $this->uploadFile($request->file('image'), 'Category');
        }

        Category::create($data);


        return redirect()->back()->with('success', 'New data created');
    }

    public function show($category)
    {
        return view('admin.categories.show');
    }

    public function edit($id)
    {
        $category = Category::findorFail($id);

        return view('admin.categories.edit', compact('category'));
    }



    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'slug' => 'nullable|unique:categories,slug,' . $category->id,
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($category->image && file_exists(public_path('Category/' . basename($category->image)))) {
                unlink(public_path('Category/' . basename($category->image)));
            }

            // Upload the new image
            $data['image'] = $this->uploadFile($request->file('image'), 'Category');
        }

        // Update the category
        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }


    public function updateStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['success' => true, 'status' => $category->status]);
    }




    public function destroy($id)
    {

        $category = Category::findOrFail($id);

        // If there is an old image, delete it from the public directory
        if ($category->image && file_exists(public_path('Category/' . basename($category->image)))) {
            unlink(public_path('Category/' . basename($category->image)));
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category item deleted');
    }
}
