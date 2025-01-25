<?php

namespace App\Services\Admin\Campaign;


interface CampaignServiceInterface
{
    public function all();

    public function store($request);

    public function edit($id);

    public function update($request, $id);

    public function delete($id);

    public function allProducts();

    public function storeProduct($request);

    public function productCampaigns();

    public function updateProductCampaigns($request);
}