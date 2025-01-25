<?php

namespace App\Repositories\Admin\Pages;

use App\Models\Page;

class PageRepository implements PageRepositoryInterface
{
   
    public function findByTypeOrNew($type): Page 
    {
        return Page::firstOrNew(['type' => $type]);
    }

        /**
     * Find a page by type or create a new one if it doesn't exist.
     *
     * @param string $type
     * @return Page
     */
    public function findOrCreateByType(string $type): Page
    {
        return Page::firstOrNew(['type' => $type]);
    }

    /**
     * Store or update a page.
     *
     * @param array $data
     * @param Page $page
     * @return Page
     */
    public function createOrUpdate(array $data, Page $page): Page
    {
        $page->fill($data);
        $page->save();

        return $page;
    }

    
}