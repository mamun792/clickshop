<?php

namespace App\Http\Controllers\Admin\Attributes;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Http\Request;

class AttributesController extends Controller
{
    public function index()
    {
        $attributes = Attribute::orderBy('name', 'asc')->with('attribute_option')->get();
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $attributes = Attribute::orderBy('name', 'asc')->with('attribute_option')->get();
        return view('admin.attributes.create', compact('attributes'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        Attribute::create($data);

        return redirect()->back()->with('success', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $attributes = Attribute::where('id', $id)->with('attribute_option')->first();

        return view('admin.attributes.edit', compact('attributes'));
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute->update($data);


        return redirect()->back()->with('success', 'Attribute updated successfully');
    }

    public function destroy($id)
    {
        Attribute::find($id)->delete();
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute deleted successfully');
    }

    public function addOption($attribute_id)
    {
         $Atibute=Attribute::find($attribute_id);
        
        return view('admin.attributes.add-option', compact('attribute_id','Atibute'));
    }

    public function storeOption(Request $request, $id)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255',
            'attribute_id' => 'required|exists:attributes,id', // Ensures attribute_id exists in the attributes table
            'quantity' => 'nullable|integer|min:0', // Allows nullable but enforces integer and positive value if provided
            'price' => 'nullable|numeric|min:0', // Allows nullable but enforces numeric value and minimum 0


        ]);

        AttributeOption::create($data);

        return redirect()->back()->with('success', 'Data inserted successfully');
    }

    public function editOption($id)
    {
        $attributes_option = AttributeOption::find($id);
        return view('admin.attributes.edit-option', compact('attributes_option'));
    }

    public function updateOption(Request $request, $id)
    {
        $attribute_option = AttributeOption::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute_option->update($data);


        return redirect('/admin/attributes')->with('success', 'Attribute option updated');
    }

    public function destroyOption($id)
    {
        AttributeOption::find($id)->delete();
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute deleted successfully');
    }



}
