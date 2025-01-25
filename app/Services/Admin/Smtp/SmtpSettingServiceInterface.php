<?php

namespace App\Services\Admin\Smtp;


interface SmtpSettingServiceInterface
{
    public function getSmtpSetting();
    public function storeOrUpdateSmtpSetting($data);
}

