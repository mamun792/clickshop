<?php

namespace App\Http\Controllers\Admin\Pos;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SiteInfo;
use App\Models\User;
use App\Services\Admin\Manage_site\SiteServiceInterface;
use App\Services\Admin\Pos\POSServiceInterface;
use Illuminate\Http\Request;


class POSController extends Controller
{
    protected $posService;
    protected $siteService;

    public function __construct(POSServiceInterface $posService, SiteServiceInterface $siteService)
    {
        $this->posService = $posService;
        $this->siteService = $siteService;
    }

    public function index(Request $request)
    {

        try {
            $categories = $this->posService->getAllCategories();
            $brands = $this->posService->getAllBrands();
             $products = $this->posService->getAllProducts($request->all());
            $deliveryCharges =  $this->siteService->getDeliveryCharge();

      $user=User::where('role','user')->first();

            return view('admin.pos.index', compact('products', 'deliveryCharges', 'categories', 'brands','user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function apiinformations()
    {

        try {
            $data = SiteInfo::get();
          return ApiResponse::success(
            ['success' => true, 'data' =>$data],
            'site data pass sucess'
        );

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
