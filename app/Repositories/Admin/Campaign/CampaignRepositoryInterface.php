<?php

namespace App\Repositories\Admin\Campaign;


interface CampaignRepositoryInterface
{
    public function all();

    public function store($request);

    public function edit($id);

    public function update($request, $id);

    public function delete($id);

    public function allProducts();
   public function attachProductToCampaign($campaign, $product);
   public function productCampaigns();


   public function getOldProductCampaigns($productId);
    public function deleteOldProductCampaigns($productId, $campaignIds);
    public function associateCampaignsWithProduct($productId, array $campaignIds);
    
}

