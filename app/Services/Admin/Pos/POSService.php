<?php

namespace App\Services\Admin\Pos;

use App\Repositories\Admin\Pos\POSRepositoryInterface;

class POSService implements POSServiceInterface
{
    protected $posRepository;

    public function __construct(POSRepositoryInterface $posRepository)
    {
        $this->posRepository = $posRepository;
    }

    public function getAllProducts(array $data)
    {
          $products = $this->posRepository->getAllProductsWithDetails($data);
        
          return $products;
      
    
      
    }
    
    public function getAllCategories()
    {
        $categories = $this->posRepository->getAllCategories();
        
        return $categories;
    }

    public function getAllBrands()
    {
        $brands = $this->posRepository->getAllBrands();
        
        return $brands;
    }
    public function apigetAllProducts()
    {
        $products = $this->posRepository->apigetAllProductsWithDetails();
        
        return $products;
    }
    
    
}