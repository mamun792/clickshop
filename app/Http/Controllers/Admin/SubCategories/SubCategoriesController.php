<?php

namespace App\Http\Controllers\Admin\SubCategories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;

class SubCategoriesController extends Controller
{

    use FileUploadTrait;


    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->where('status', 'Active')->get();
        $subcategories = SubCategory::latest()->with('category_data')->get();
        return view('admin.subcategories.index', compact('categories', 'subcategories'));
    }

    public function create()
    {
        return view('admin.subcategories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
             'category_id' => 'required',
            'slug' => 'nullable|unique:categories,slug,' , 
        ]);

    
        SubCategory::create($data);


        return redirect()->back()->with('success', 'Data created successfully');


    }

    public function show($id)
    {
        return view('admin.subcategories.show');
    }

    public function edit($id)
    {
        $subcategories = SubCategory::find($id);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.subcategories.edit', compact('subcategories', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $sub_category = SubCategory::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
             'category_id' => 'required',
            'slug' => 'nullable|unique:categories,slug,' , 
        ]);

        $sub_category->update($data);


        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory updated');
    }

    public function updateStatus(Request $request)
    {
        $sub_category = SubCategory::findOrFail($request->id);
        $sub_category->status = $request->status;
        $sub_category->save();

        return response()->json(['success' => true, 'status' => $sub_category->status]);
    }


    public function destroy($id)
    {
       

       SubCategory::find($id)->delete();

       return redirect()->back()->with('success', 'SubCategory item deleted');
    }
}
