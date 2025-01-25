<?php

namespace App\Services;

use App\Models\User;
use Laravolt\Avatar\Facade as Avatar;

class AvatarService
{
    /**
     * Get the avatar for the given customer.
     *
     * @param  string  $image
     * @param  string  $name
     * @return string
     */
    public function getAvatar($image, $name)
    {
        
        if (!empty($image) && file_exists(public_path($image))) {
            return asset($image);
        }

       
        return Avatar::create($name)->toBase64();
    }
}