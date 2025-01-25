<?php

namespace App\Repositories\Admin\Brands;

use App\Models\Brand;
use App\Services\ImageUploadService;

class BrandsRepository implements BrandsRepositoryInterface
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function get()
    {
        return Brand::all();
    }

    public function store($request)
    {

            $imagePath = $this->imageUploadService->uploadImage($request->file('photo'), 'brands');

            $user_id = auth()->user()->id;
            $brand = new Brand();
            $brand->user_id = $user_id;
            $brand->company = $request->company;
            $brand->photo = $imagePath ?? null;
            $brand->save();
            return $brand;



    }


    public function getById($id)
    {
        return Brand::findorFail($id);
    }

    public function update($request, $id)
    {
        $brand = Brand::findorFail($id);
        // old image delete

         if ($request->hasFile('photo')) {
            $this->imageUploadService->deleteFile($brand->photo);
         }


            $imagePath = $this->imageUploadService->uploadImage($request->file('photo'), 'brands');

            $brand->photo = $imagePath ?? null;

        $brand->company = $request->company;
        $brand->save();
        return $brand;
    }

    public function delete($id)
    {
        $brand = Brand::findorFail($id);
        // image delete
        $this->imageUploadService->deleteFile($brand->photo);

        $brand->delete();
    }
}
