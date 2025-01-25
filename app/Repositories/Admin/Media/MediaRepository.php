<?php

namespace App\Repositories\Admin\Media;

use App\Models\Media;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;


class MediaRepository
{
    public function storeMedia($data)
    {

        $media = Media::updateOrCreate(['id' => 1], $data);

        // Invalidate cache for updated keys
        foreach ($data as $key => $value) {
            Cache::forget("media_{$key}");

        }

        return $media;
    }

    public function getMedia()
    {
        return Media::first();
    }

    public function get($column)
    {
        // Check if the column exists in the 'media' table
        if (!Schema::hasColumn('media', $column)) {
            throw new \Exception("The column '{$column}' does not exist in the media table.");
        }

        // Retrieve and cache the value for the specified column
        return Cache::remember("media_{$column}", now()->addHours(24), function () use ($column) {
            return Media::query()->value($column);
        });
    }
}
