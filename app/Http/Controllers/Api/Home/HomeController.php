<?php

namespace App\Http\Controllers\Api\Home;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\MarketingTool;
use App\Models\Media;
use App\Models\Page;
use App\Services\Admin\Manage_site\SiteServiceInterface;
use App\Services\Admin\SidebarSlider\SidebarSliderServiceInterface;
use App\Services\Admin\Pos\POSServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    private $sidebarSliderService, $posService, $siteService;



    public function __construct(SidebarSliderServiceInterface $sidebarSliderService, POSServiceInterface $posService,SiteServiceInterface $siteService)
    {
        $this->sidebarSliderService = $sidebarSliderService;
        $this->posService = $posService;
        $this->siteService = $siteService;
    }

    public function index()
    {
        try {
            $sliders = $this->sidebarSliderService->get();
            $categories = Category::with('sub_category')->latest()->get();
            $products = $this->posService->apigetAllProducts();
            $campaignProducts = $this->posService->apigetAllProducts();
            $siteinfos = $this->siteService->getSiteInfo();
            $siteinfos['pages'] = Page::get();
            $siteinfos['media'] = Media::get();
            $siteinfos['marketing'] = MarketingTool::get();
            $blogs = Blog::latest()->with('blog_category')->get();
    
            // Initialize empty arrays if collections are empty
            $sliders = $sliders->isEmpty() ? [] : $sliders;
            $categories = $categories->isEmpty() ? [] : $categories;
            $products = $products->isEmpty() ? [] : $products;
            $blogs = $blogs->isEmpty() ? [] : $blogs;
            $siteinfos = $siteinfos->isEmpty() ? [] : $siteinfos;
    
            // Filter campaign products
            if (!$campaignProducts->isEmpty()) {
                $currentDate = now()->format('Y-m-d');
                
                $campaignProducts = $campaignProducts->filter(function ($product) use ($currentDate) {
                    // Check if product has campaign and campaign is active
                    return $product->product_campaign && 
                           $product->product_campaign->campaign && 
                           $currentDate >= $product->product_campaign->campaign->start_date && 
                           $currentDate <= $product->product_campaign->campaign->expiry_date;
                })->values(); // Reset array keys after filtering
            } else {
                $campaignProducts = [];
            }
    
            // Filter feature products
            $featureProducts = [];
            if (!$products->isEmpty()) {
                $featureProducts = $products->filter(function ($product) {
                    return isset($product->feature) && $product->feature !== 'None';
                })->values(); // Reset array keys after filtering
            }
    
            return ApiResponse::success([
                'sliders' => $sliders,
                'categories' => $categories,
                'products' => $products,
                'featureProducts' => $featureProducts, // Add feature products
                'compaign' => $campaignProducts, // Fixed spelling of 'campaign'
                'blogs' => $blogs,
                'siteinfos' => $siteinfos
            ]);
    
        } catch (\Exception $e) {
            return ApiResponse::error(
                __('messages.unexpected_error', ['action' => 'fetch sliders']),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    
}
