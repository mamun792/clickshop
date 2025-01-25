<?php

namespace App\Services\Admin\Brands;

interface BrandsServiceInterface
{
    public function get();
    public function store($request);
    public function getById($id);
    public function update($request, $id);
    public function delete($id);
}