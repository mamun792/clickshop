<?php

namespace App\Repositories\Admin\Smtp;

use App\Models\SmtpSetting;
use Illuminate\Support\Facades\Log;

class SmtpSettingRepository implements SmtpSettingRepositoryInterface
{
    public function getSmtpSetting()
    {
        return SmtpSetting::first();
    }

    public function storeOrUpdateSmtpSetting($data)
    {
        // add auth user id
        $data['user_id'] = auth()->id();
       // Log::info('SmtpSettingRepository@storeOrUpdateSmtpSetting: ' . json_encode($data));

       return SmtpSetting::updateOrCreate(['id' => 1], $data);
    }
}