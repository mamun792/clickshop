<?php

namespace App\Repositories\Admin\Pos;

interface POSRepositoryInterface
{
    public function getAllProductsWithDetails(array $filters = []);
    public function apigetAllProductsWithDetails();
    public function getAllCategories();
    public function getAllBrands();
}