<?php

namespace App\Services\Admin\Pages;

use App\Models\Page;
use App\Repositories\Admin\Pages\PageRepositoryInterface;

class PageService implements PageServiceInterface
{
    protected $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    // findByTypeOrNew($type)
    public function findByTypeOrNew($type): Page
    {
        return $this->pageRepository->findByTypeOrNew($type);
    }

    /**
     * Find a page by type or create a new one if it doesn't exist.
     *
     * @param string $type
     * @return Page
     */
    public function findOrCreateByType(string $type): Page
    {
        return $this->pageRepository->findOrCreateByType($type);
    }

    /**
     * Store or update a page.
     *
     * @param array $data
     * @param Page $page
     * @return Page
     */
    public function createOrUpdatePage(array $data, Page $page): Page
    {
        return $this->pageRepository->createOrUpdate($data, $page);
    }
}