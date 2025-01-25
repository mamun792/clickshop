<?php

namespace App\Repositories\Admin\SidebarSlider;

use App\Models\SidebarSlider;
use App\Services\ImageUploadService;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SidebarSliderRepository implements SidebarSliderRepositoryInterface
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }



    public function store($request)
    {

        try {

            if ($request->hasFile('image_path')) {

                $imagePath = $this->imageUploadService->uploadImage($request->file('image_path'), 'slider');

                if (!$imagePath) {
                    return null;
                }


                return $this->createSlider($imagePath);
            }


            return null;

        } catch (Exception $e) {

            Log::error("Error in storing sidebar slider: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new SidebarSlider entry in the database.
     *
     * @param string $imagePath
     * @return SidebarSlider
     */
    private function createSlider($imagePath)
    {

        $slider = new SidebarSlider();
        $slider->image_path = $imagePath;
        $slider->save();

        return $slider;
    }

    public function update($request, $id)
    {
        try {
            $slider = SidebarSlider::find($id);

            // old image deletion  logic

            if($request->hasFile('image_path')){
                $this->imageUploadService->deleteFile($slider->image_path);
            }



            if ($request->hasFile('image_path')) {
                $imagePath = $this->imageUploadService->uploadImage($request->file('image_path'), 'slider');


                if (!$imagePath) {
                    return null;
                }

                $slider->image_path = $imagePath;
            }

            // old image deletion  logic


            $slider->save();

            return $slider;

        } catch (Exception $e) {
            Log::error("Error in updating sidebar slider: " . $e->getMessage());
            return null;
        }
    }






    public function delete($id)
    {
        $slider = SidebarSlider::findorFail($id);

        $this->imageUploadService->deleteFile($slider->image_path);
        $slider->delete();
    }

    public function get()
    {
       

        return SidebarSlider::latest()->get();
    }

    public function getById($id)
    {
        return SidebarSlider::find($id);
    }
}
