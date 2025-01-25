<?php

namespace App\Factories;

use App\Repositories\Admin\CouriarApiSetting\CouriarApiSettingRepository;
use App\Services\Admin\CouriarApiSetting\CouriarApiSettingService;
use App\Services\Admin\CouriarApiSetting\CouriarApiSettingServiceInterface;

class CourierServiceFactory
{
    public static function create(string $courierName): CouriarApiSettingServiceInterface
    {
        return match ($courierName) {
            'steadfast' => new CouriarApiSettingService(new CouriarApiSettingRepository()),
            default => throw new \InvalidArgumentException('Invalid courier service.'),
        };
    }
}
