<?php

namespace App\Repositories\Admin\Campaign;

use App\Models\Campaign;
use App\Models\Product;
use App\Models\ProductCampaign;
use Nette\Utils\Random;

class CampaignRepository implements CampaignRepositoryInterface
{
    public function all()
    {
        return Campaign::with('productCampaigns')->latest()->get();
    }

    public function store($request)
    {
        $campaign = new Campaign();
        $campaign->name = $request->name;
        $campaign->start_date = $request->start_date;
        $campaign->expiry_date = $request->expiry_date;
        $campaign->discount = $request->discount;
        $campaign->code = $request->code ?? Random::generate(6);
        $campaign->save();
    }

    public function edit($id)
    {
        return Campaign::findorFail($id);
    }

    public function update($request, $id)
    {
        $campaign = Campaign::find($id);
        $campaign->name = $request->name;
        $campaign->start_date = $request->start_date;
        $campaign->expiry_date = $request->expiry_date;
        $campaign->discount = $request->discount;
        $campaign->code = $request->code ?? Random::generate(6);
        $campaign->save();
    }

    public function delete($id)
    {
        $campaign = Campaign::find($id);
        $campaign->delete();
    }

    public function allProducts()
    {
        return Product::latest()->get();
    }

    public function attachProductToCampaign($campaign, $product)
    {
       
        if (!$campaign->products()->where('product_id', $product->id)->exists()) {
           
            $campaign->products()->attach($product, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function productCampaigns()
    {
        return Product::with('campaigns')->orderBy('created_at', 'desc')->get();

    }

    public function getOldProductCampaigns($productId)
    {
        return ProductCampaign::where('product_id', $productId)->get();
    }

    public function deleteOldProductCampaigns($productId, $campaignIds)
    {
        return ProductCampaign::where('product_id', $productId)
            ->whereIn('campaign_id', $campaignIds)
            ->delete();
    }

    public function associateCampaignsWithProduct($productId, array $campaignIds)
    {
        foreach ($campaignIds as $campaignId) {
            $existingCampaign = ProductCampaign::where('product_id', $productId)
                ->where('campaign_id', $campaignId)
                ->first();

            if (!$existingCampaign) {
                ProductCampaign::create([
                    'product_id' => $productId,
                    'campaign_id' => $campaignId,
                ]);
            }
        }
    }
}