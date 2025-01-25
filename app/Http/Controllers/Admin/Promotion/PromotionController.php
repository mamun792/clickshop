<?php

namespace App\Http\Controllers\Admin\Promotion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Campain\CampainRequest;
use App\Models\Campaign;
use App\Models\Product;

use App\Services\Admin\Campaign\CampaignServiceInterface;
use Illuminate\Http\Request;


class PromotionController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignServiceInterface $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function index()
    {
        $campaigns = $this->campaignService->all();
        return view('admin.promotion.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.promotion.create');
    }

    public function store(CampainRequest $request)
    {

        try {
            $this->campaignService->store($request);
            return redirect()->route('admin.promotions.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $campaign = $this->campaignService->edit($id);
            return view('admin.promotion.edit', compact('campaign'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        // 
    }

    public function update(Request $request, $id)
    {
        try {
            $this->campaignService->update($request, $id);
            return redirect()->route('admin.promotions.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $this->campaignService->delete($id);
            return redirect()->route('admin.promotions.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function addProduct()
    {
        $products = $this->campaignService->allProducts();
        $campaigns = $this->campaignService->all();

        return view('admin.promotion.add-product', compact('products',  'campaigns'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'campaign_id' => 'required|exists:campaigns,id',
        ]);


        try {
            $this->campaignService->storeProduct($request);
            return redirect()->route('admin.promotions.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function editProduct($id)
    {
        $product = Product::findOrFail($id);


        $campaigns = Campaign::all();

        $products = Product::latest()->get();

        $associatedCampaigns = $product->campaigns;
        return view('admin.promotion.edit-product', compact('product', 'campaigns', 'associatedCampaigns', 'products'));
    }




    public function updateProduct(Request $request)
    {
        return $this->campaignService->updateProductCampaigns($request);
    }




    public function destroyProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->campaigns()->detach();
            return redirect()->back()->with('success', 'Product removed from all campaigns');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
