<?php

namespace App\Repositories\Admin\Brands;

interface BrandsRepositoryInterface
{
    public function get();
    public function store($request);
    public function getById($id);
    public function update($request, $id);
    public function delete($id);
}