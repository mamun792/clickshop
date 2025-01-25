<?php

namespace App\Http\Controllers\Admin\Brands;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Brand\BrandRequest;
use App\Models\Cart;
use App\Models\CartAttribute;
use App\Models\ProductAttribute;
use App\Repositories\Admin\Brands\BrandsRepositoryInterface;

use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
      protected  $brandService;


    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService, BrandsRepositoryInterface $brandService)
    {
        $this->imageUploadService = $imageUploadService;
        $this->brandService = $brandService;
    }
   
     


    public function index()
    {
        // return ProductAttribute::all();
        $brands = $this->brandService->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(BrandRequest $request)
    {
       
       try {
            $brand = $this->brandService->store($request);
            return redirect()->back()->with('success', 'Brand created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    { 
       $brand = $this->brandService->getById($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update($id, Request $request)
    {
    
        $brand = $this->brandService->update($request, $id);
        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully');
    }

    public function destroy($id)
    {
       
        $brand = $this->brandService->delete($id);
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully');
    }
}
