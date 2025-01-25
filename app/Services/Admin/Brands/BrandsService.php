<?php

namespace App\Services\Admin\Brands;



class BrandsService implements BrandsServiceInterface
{
    protected $bandsRepository;

    public function __construct(BrandsServiceInterface $bandsRepository)
    {
        $this->bandsRepository = $bandsRepository;
    }

    public function get()
    {
        return $this->bandsRepository->get();
    }

    public function store($request)
    {
        return $this->bandsRepository->store($request);
    }

    public function getById($id)
    {
        return $this->bandsRepository->getById($id);
    }

    public function update($request, $id)
    {
        return $this->bandsRepository->update($request, $id);
    }

    public function delete($id)
    {
        return $this->bandsRepository->delete($id);
    }
}