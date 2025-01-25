<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Handle image upload.
     *
     * @param \Illuminate\Http\File|\Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string|null
     */
    public function uploadImage($file, $folder = 'uploads')
    {

        if (!$this->validateImage($file)) {
            return null;
        }


        $filename = $this->generateUniqueFileName($file);


        $destinationPath = public_path("{$folder}");


        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }


        $file->move($destinationPath, $filename);


        return asset("{$folder}/{$filename}");
    }

    /**
     * Validate the uploaded image.
     *
     * @param \Illuminate\Http\File|\Illuminate\Http\UploadedFile $file
     * @return bool
     */
    private function validateImage($file)
    {
        $validator = Validator::make(['image' => $file], [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp'
        ]);

        return !$validator->fails();
    }

    /**
     * Generate a unique file name using UUID.
     *
     * @param \Illuminate\Http\File|\Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function generateUniqueFileName($file)
    {
        $extension = $file->getClientOriginalExtension();
        return Str::uuid() . '.' . $extension;
    }

    /**
     * Handle image removal from storage.
     *
     * @param string $filePath
     * @return bool
     */



    public function deleteFile($filePath)
    {

        $file = str_replace(url('/'), '', $filePath);


        $fullPath = public_path($file);


        clearstatcache();

        // Check if the file exists
        if (file_exists($fullPath)) {
           
            if (is_writable($fullPath)) {
                @unlink($fullPath);
            }
        }
    }



}
