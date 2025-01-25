<?php

namespace App\Http\Controllers\Admin\Sliders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\BannerRequest;
use App\Services\Admin\SidebarSlider\SidebarSliderServiceInterface;

use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sidebarSliderService;


    public function __construct(SidebarSliderServiceInterface $sidebarSliderService,)
    {
        $this->sidebarSliderService = $sidebarSliderService;
    }

    public function Banner()
    {
        $banners = $this->sidebarSliderService->get();

        return view('admin.sliders.banner', compact('banners'));
    }

    public function storeBanner(BannerRequest $request)
    {

        try {
            

            $this->sidebarSliderService->store($request);
            return redirect()->back()->with('success', 'Slider added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function editBanner($id)
    {
        $banner = $this->sidebarSliderService->getById($id);
        return view('admin.sliders.edit-banner', compact('banner'));
    }

    public function updateBanner(BannerRequest $request, $id)
    {
        try {
            $this->sidebarSliderService->update($request, $id);
            return redirect()->back()->with('success', 'Slider updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroyBanner($id)
    {
        try {
            $this->sidebarSliderService->delete($id);
            return redirect()->back()->with('success', 'Slider deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
