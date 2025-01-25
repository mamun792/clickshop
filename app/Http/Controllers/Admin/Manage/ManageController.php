<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Manage_site\StoreOrUpdateSiteRequest;
use App\Http\Requests\Admin\Smtp\SmtpSettingRequest;
use App\Repositories\Admin\Smtp\SmtpSettingRepositoryInterface;
use App\Services\Admin\Manage_site\SiteServiceInterface;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ManageController extends Controller
{
    protected $siteService;
    protected $imageUploadService;
    protected $smtpSettingRepository;

    public function __construct(SiteServiceInterface $siteService, ImageUploadService $imageUploadService, SmtpSettingRepositoryInterface $smtpSettingRepository)
    {
        $this->siteService = $siteService;
        $this->imageUploadService = $imageUploadService;
        $this->smtpSettingRepository = $smtpSettingRepository;
    }


    public function index()
    {

       $siteInfo = $this->siteService->getSiteInfo()->first(); 
 
        return view('admin.manage-site.index', compact('siteInfo'));
    }

    public function smtpSetting()
    {
        $smtp = $this->smtpSettingRepository->getSmtpSetting();
        return view('admin.manage-site.smtp-setting',compact('smtp'));
    }

    public function storeOrUpdateSite(StoreOrUpdateSiteRequest $request)
    {
  

        try {

            if ($request->hasFile('store_gateway_image')) {

                $imageUrl = $this->imageUploadService->uploadImage($request->file('store_gateway_image'), 'assets/image/admin/manage');


                $request->merge(['site_image_url' => $imageUrl]);
            }



            $request->merge([
                'enable_facebook_login' => $request->has('enable_facebook_login') ? 1 : 0,
                'enable_google_login' => $request->has('enable_google_login') ? 1 : 0,
            ]);

            $this->siteService->storeOrUpdateSite($request->all());


            return redirect()->back()->with('success', 'Site info updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function storeOrUpdateSmtp(SmtpSettingRequest $request)
    {

        try {
            $data = $request->all();


            if (empty($data['use_smtp'])) {
                $data = Arr::except($data, [
                    'smtp_host',
                    'smtp_port',
                    'smtp_encryption',
                    'smtp_username',
                    'smtp_password',
                ]);
            }

            $this->smtpSettingRepository->storeOrUpdateSmtpSetting($data);
            return redirect()->back()->with('success', 'SMTP settings updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function contactPage()
    {
        $siteInfo = $this->siteService->getSiteInfo()->first();
        return view('admin.manage-site.contact-page', compact('siteInfo'));
    }

    public function socialMediaLinks()
    {
        $siteInfo = $this->siteService->getSiteInfo()->first();
        return view('admin.manage-site.social-media-links', compact('siteInfo'));
    }

}
