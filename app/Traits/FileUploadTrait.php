<?php


namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

use Intervention\Image\Laravel\Facades\Image;

trait FileUploadTrait
{
    public function uploadFile(UploadedFile $file, string $path = '/uploads'): string
    {
        try {
            $ext = $file->getClientOriginalExtension();
            $fileName = 'media_' . uniqid() . '.' . $ext;
            $destinationPath = public_path($path);

            // Ensure directory exists
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true); // Create the directory if it doesn't exist
            }

            $file->move($destinationPath, $fileName);

            // Return full URL of the uploaded file
            return url($path . '/' . $fileName);
        } catch (\Exception $e) {
            // Handle exception and return error message
            throw new \Exception("Failed to upload file: " . $e->getMessage());
        }
    }






    public function uploadMultipleFiles(array $uploadedFiles, string $path = '/uploads'): array
    {
        $savedImages = [];
        $errors = [];

        // Check if files are uploaded and valid
        if (empty($uploadedFiles) || !is_array($uploadedFiles)) {
            return [
                'savedImages' => $savedImages,
                'errors' => ['No valid files uploaded.'],
            ];
        }

        foreach ($uploadedFiles as $key => $file) {
            try {
                // Read the image using Intervention Image
                $image = Image::read($file);
                $width = $image->width();
                $height = $image->height();
                $aspectRatio = $width / $height;

                // // Validate aspect ratio
                // if (abs($aspectRatio - (2 / 3)) > 0.01) {
                //     throw new \Exception("Image {$file->getClientOriginalName()} must have a 2:3 aspect ratio.pixel size 1000*1500 px / 500 * 750 px");
                // }

                $ext = $file->getClientOriginalExtension();
                $fileName = 'media_' . uniqid() . '.' . $ext;
                $destinationPath = public_path($path);

                // Ensure directory exists
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);

                // Return full URL of the uploaded file
                $savedImages[] = url($path . '/' . $fileName);
            } catch (\Exception $e) {
                // Capture errors and add them to the errors array
                $errors[] = "Error processing image {$file->getClientOriginalName()}: " . $e->getMessage();
            }
        }

        return [
            'savedImages' => $savedImages,
            'errors' => $errors,
        ];
    }

    // remove existing file from server and upload new file to server and return the file path
    public function updateFile(UploadedFile $file, string $oldFilePath, string $path = '/uploads'): string
    {
        // Remove the old file
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        // Upload the new file
        return $this->uploadFile($file, $path);
    }

    // remove existing file from server and upload new file to server and return the file path multiple files
    public function updateProductGallery(Request $request, $product)
    {
        // Check if gallery images are present in the request
        if ($request->hasFile('gallery_images')) {
            // Decode existing gallery images from the database
            $existingGalleryImages = json_decode($product->gallery_images, true);

            // Ensure the gallery images are properly structured
            $validImages = [];
            if (is_array($existingGalleryImages)) {
                foreach ($existingGalleryImages as $entry) {
                    if (is_string($entry) && !empty($entry)) {
                        $validImages[] = $entry; // Collect valid strings
                    } elseif (is_array($entry)) {
                        // Handle arrays of URLs
                        foreach ($entry as $url) {
                            if (is_string($url) && !empty($url)) {
                                $validImages[] = $url; // Collect valid URLs
                            }
                        }
                    } else {
                        Log::warning('Skipping invalid gallery image entry: ' . json_encode($entry));
                    }
                }
            }

            // // Delete valid images
            // foreach ($validImages as $oldImage) {
            //     $filePath = public_path(parse_url($oldImage, PHP_URL_PATH));
            //     if (file_exists($filePath)) {
            //         if (@unlink($filePath)) {
            //             Log::info('File successfully deleted: ' . $filePath);
            //         } else {
            //             Log::error('Failed to delete file: ' . $filePath);
            //         }
            //     } else {
            //         Log::warning('File not found: ' . $filePath);
            //     }
            // }

            // Upload new gallery images
            $uploadResult = $this->uploadMultipleFiles($request->file('gallery_images'), 'gallery');

            // Return the saved images
            return $uploadResult['savedImages'];  // Ensure this is returned
        }

        // Return an empty array if no gallery images were provided
        return [];
    }



    public function deleteFeaturedImage($featuredImage)
    {
        if ($featuredImage) {
            // Extract the file name from the URL if it's a full URL
            $featuredImageName = basename(parse_url($featuredImage, PHP_URL_PATH));

            // Assuming the featured image is stored in the 'featured_image' folder under 'public'
            $featuredImagePath = public_path('featured_image/' . $featuredImageName);

            if (file_exists($featuredImagePath)) {
                unlink($featuredImagePath);
                Log::info('Featured image deleted successfully: ' . $featuredImageName);
            } else {
                Log::info('Featured image not found: ' . $featuredImagePath);
            }
        }
    }

    // Delete gallery images if they exist
    public function deleteGalleryImages($galleryImagesJson)
    {
        $galleryImages = json_decode($galleryImagesJson, true);

        if (is_array($galleryImages)) {
            foreach ($galleryImages as $image) {
                // Extract the file name from the URL if it's a full URL
                $galleryImageName = basename(parse_url($image, PHP_URL_PATH));

                // Assuming the gallery images are stored in the 'products' folder under 'public'
                $galleryImagePath = public_path('products/' . $galleryImageName);

                if (file_exists($galleryImagePath)) {
                    unlink($galleryImagePath);
                    Log::info('Gallery image deleted successfully: ' . $galleryImageName);
                } else {
                    Log::info('Gallery image not found: ' . $galleryImagePath);
                }
            }
        }
    }


}
