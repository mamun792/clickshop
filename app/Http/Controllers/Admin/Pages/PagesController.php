<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Page\PageRequest;
use App\Models\Page;
use App\Services\Admin\Pages\PageServiceInterface;
use Illuminate\Support\Facades\Log;

class PagesController extends Controller
{
    protected $pageService;

    public function __construct(PageServiceInterface $pageService)
    {
        $this->pageService = $pageService;
    }

    public function privacyPolicy()
    {
        $page = $this->pageService->findByTypeOrNew(Page::TYPES['POLICIES']);
        return view('admin.pages.policies', compact('page'));
    }

    public function termsConditions()
    {
        $page = $this->pageService->findByTypeOrNew(Page::TYPES['TERMS']);
        return view('admin.pages.terms', compact('page'));
    }

    public function refundPolicy()
    {
        $page = $this->pageService->findByTypeOrNew(Page::TYPES['REFUND']);
        return view('admin.pages.refund', compact('page'));
    }

    public function salesSupport()
    {
        $page = $this->pageService->findByTypeOrNew(Page::TYPES['SALES_SUPPORT']);
        return view('admin.pages.sales', compact('page'));
    }

    public function shippingDelivery()
    {
        $page = $this->pageService->findByTypeOrNew(Page::TYPES['SHIPPING_DELIVERY']);
        return view('admin.pages.shipping', compact('page'));
    }



    public function store(PageRequest $request, string $type)
    {
        try {
            $page = $this->pageService->findOrCreateByType($type);
            $page = $this->pageService->createOrUpdatePage($request->validated(), $page);

            return redirect()->back()->with('success', 'Page updated successfully.');
        } catch (\Exception $e) {

            Log::error('Error updating page: ' . $e->getMessage());


            return redirect()->back()->with('error', 'An error occurred while updating the page. Please try again.');
        }
    }
}
