<?php

namespace App\Repositories\Admin\Smtp;

interface SmtpSettingRepositoryInterface
{
    public function getSmtpSetting();
    public function storeOrUpdateSmtpSetting($data);
}