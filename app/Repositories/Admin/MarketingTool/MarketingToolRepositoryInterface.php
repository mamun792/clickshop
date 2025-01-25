<?php

namespace App\Repositories\Admin\MarketingTool;

interface MarketingToolRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);

    public function getLatest();

    public function delete($id);
}