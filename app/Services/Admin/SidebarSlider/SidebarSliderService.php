<?php

namespace App\Services\Admin\SidebarSlider;

use App\Helpers\ApiResponse;
use App\Repositories\Admin\SidebarSlider\SidebarSliderRepositoryInterface;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Response;

class SidebarSliderService implements SidebarSliderServiceInterface
{
    protected $sidebarSliderRepository;

    public function __construct(SidebarSliderRepositoryInterface $sidebarSliderRepository)
    {
        $this->sidebarSliderRepository = $sidebarSliderRepository;
    }

    public function store($request)
    {
       
        $this->sidebarSliderRepository->store($request);
    }

    public function update($request, $id)
    {
        $this->sidebarSliderRepository->update($request, $id);
    }

    public function delete($id)
    {
        $this->sidebarSliderRepository->delete($id);
    }

    public function get()
    {
       
         return  $sliders = $this->sidebarSliderRepository->get();
           
           
    }

    public function getById($id)
    {
        return $this->sidebarSliderRepository->getById($id);
    }
}