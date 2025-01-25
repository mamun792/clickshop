<?php


namespace App\Services\Admin\Pages;

use App\Models\Page;


interface   PageServiceInterface
{

    public function findByTypeOrNew($type): Page;
     /**
     * Find a page by type or create a new one if it doesn't exist.
     *
     * @param string $type
     * @return Page
     */
    public function findOrCreateByType(string $type): Page;

    /**
     * Store or update a page.
     *
     * @param array $data
     * @param Page $page
     * @return Page
     */
    public function createOrUpdatePage(array $data, Page $page): Page;
}