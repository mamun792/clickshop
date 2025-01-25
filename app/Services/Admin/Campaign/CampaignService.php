<?php
namespace App\Services\Admin\Campaign;

use App\Models\Campaign;
use App\Models\Product;
use App\Repositories\Admin\Campaign\CampaignRepositoryInterface;

class CampaignService implements CampaignServiceInterface
{
    protected $campaignRepository;

    public function __construct(CampaignRepositoryInterface $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    public function all()
    {
        return $this->campaignRepository->all();
    }

    public function store($request)
    {
        $this->campaignRepository->store($request);
    }

    public function edit($id)
    {
        return $this->campaignRepository->edit($id);
    }

    public function update($request, $id)
    {
        $this->campaignRepository->update($request, $id);
    }

    public function delete($id)
    {
        $this->campaignRepository->delete($id);
    }

    public function allProducts()
    {
        return $this->campaignRepository->allProducts();
    }

    public function storeProduct($request)
    {
        $campaign = Campaign::findOrFail($request->input('campaign_id'));
        $product = Product::findOrFail($request->input('product_id'));
        
       
        // Attach product to campaign using the repository
        $this->campaignRepository->attachProductToCampaign($campaign, $product);
    }

    public function productCampaigns()
    {
        return $this->campaignRepository->productCampaigns();
    }

    public function updateProductCampaigns($request)
    {
        // Validate incoming request data
        $request->validate([
            'product_idss' => 'required|exists:products,id',
            'product_id' => 'required|exists:products,id',
            'campaign_ids' => 'required|array',
        ]);

        $oldProductCampaigns = $this->campaignRepository->getOldProductCampaigns($request->product_idss);

        if ($oldProductCampaigns->isEmpty()) {
            return redirect()->back()->with('error', 'No campaigns found for the old product.');
        }

        // Delete old campaigns
        $this->campaignRepository->deleteOldProductCampaigns($request->product_idss, $oldProductCampaigns->pluck('campaign_id'));

        // Associate new campaigns with the selected product
        $this->campaignRepository->associateCampaignsWithProduct($request->product_id, $request->campaign_ids);

        return redirect()->route('admin.promotions.add.product.campain')->with('success', 'Product campaigns updated successfully');
    }
}