<?php

namespace App\Services\Admin\Media;

use App\Repositories\Admin\Media\MediaRepository;
use App\Services\ImageUploadService;
use App\Models\Media;

class MediaService
{
    protected $mediaRepository;
    protected $imageUploadService;

    public function __construct(MediaRepository $mediaRepository, ImageUploadService $imageUploadService)
    {
        $this->mediaRepository = $mediaRepository;
        $this->imageUploadService = $imageUploadService;
    }

    public function storeMedia($data)
    {
        $existingMedia = Media::first(); // Assuming a single-row table

        $mediaData = [];

        // Process and upload new media files
        if (isset($data['logo'])) {
            if ($existingMedia && $existingMedia->logo) {
                $this->imageUploadService->deleteFile($existingMedia->logo);
            }
            $mediaData['logo'] = $this->imageUploadService->uploadImage($data['logo'], 'media');
        }

        if (isset($data['favicon'])) {
            if ($existingMedia && $existingMedia->favicon) {
                $this->imageUploadService->deleteFile($existingMedia->favicon);
            }
            $mediaData['favicon'] = $this->imageUploadService->uploadImage($data['favicon'], 'media');
        }

        if (isset($data['loader'])) {
            if ($existingMedia && $existingMedia->loader) {
                $this->imageUploadService->deleteFile($existingMedia->loader);
            }
            $mediaData['loader'] = $this->imageUploadService->uploadImage($data['loader'], 'media');
        }

        if (isset($data['footer_image'])) {
            if ($existingMedia && $existingMedia->footer_image) {
                $this->imageUploadService->deleteFile($existingMedia->footer_image);
            }
            $mediaData['footer_image'] = $this->imageUploadService->uploadImage($data['footer_image'], 'media');
        }

        return $this->mediaRepository->storeMedia($mediaData);
    }

    public function getMedia()
    {
        return $this->mediaRepository->getMedia();
    }


    public function get($column)
    {
        return $this->mediaRepository->get($column);
    }
}
