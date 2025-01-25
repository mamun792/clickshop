<?php

namespace App\Services\Admin\Smtp;

use App\Repositories\Admin\Smtp\SmtpSettingRepositoryInterface;
use Illuminate\Support\Arr;

class SmtpSettingService implements SmtpSettingServiceInterface
{
    protected $smtpSettingRepository;

    public function __construct(SmtpSettingRepositoryInterface $smtpSettingRepository)
    {
        $this->smtpSettingRepository = $smtpSettingRepository;
    }

    public function getSmtpSetting()
    {
        return $this->smtpSettingRepository->getSmtpSetting();
    }

    public function storeOrUpdateSmtpSetting($data)
    {
       
        return $this->smtpSettingRepository->storeOrUpdateSmtpSetting($data);
    }
}
