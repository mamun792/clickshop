<?php

namespace App\Services\Admin\CourierConfigService;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\CourierSetting;

class CourierConfigService
{


    public static function loadSettings()
    {
        try {
           if(!Cache::has('courier_settings')) {
                $settings = self::getSettingsFromCache();
                // Log::info('Courier settings loaded from the database.', ['settings' => $settings]);
                if ($settings) {
                    self::applySettings($settings);
                    Cache::put('courier_settings', $settings, now()->addMinutes(30));
                } else {
                    self::handleMissingSettings();
                }
            } else {
                self::applySettings(Cache::get('courier_settings'));
            }
        } catch (Exception $e) {
            Log::error('Error loading courier settings: ' . $e->getMessage());
            self::setDefaultSettings();
        }
    }

    protected static function getSettingsFromCache()
    {
        return  CourierSetting::first();
    }

    protected static function applySettings($settings)
    {
       // Log::info('Applying courier settings from the database.', ['settings' => $settings]);

      

        Config::set('steadfast-courier.api_key', $settings->api_key);
        Config::set('steadfast-courier.secret_key',$settings->secret_key);


        Config::set('pathao-courier.pathao_client_id', $settings->pathao_client_id);
        Config::set('pathao-courier.pathao_client_secret', $settings->pathao_client_secret);
        Config::set('pathao-courier.pathao_secret_token', $settings->pathao_secret_token);
        Config::set('pathao-courier.pathao_store_id', $settings->pathao_store_id);
    }

    protected static function handleMissingSettings()
    {
        if (!Cache::has('courier_settings_missing_logged')) {
            Log::warning('Courier settings not found in the database. Using default configuration.');
            Cache::put('courier_settings_missing_logged', true, now()->addMinutes(30));
        }
        self::setDefaultSettings();
    }


    protected static function setDefaultSettings()
    {
        Config::set('steadfast-courier.api_key', 'default_api_key');
        Config::set('steadfast-courier.secret', 'default_secret_key');

        Config::set('pathao-courier.pathao_client_id', 'default_client_id');
        Config::set('pathao-courier.pathao_client_secret', 'default_client_secret');
        Config::set('pathao-courier.pathao_secret_token', 'default_secret_token');
        Config::set('pathao-courier.pathao_store_id', 'default_store_id');
    }
}
