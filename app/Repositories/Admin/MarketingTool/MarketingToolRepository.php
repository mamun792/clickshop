<?php

namespace App\Repositories\Admin\MarketingTool;

use App\Models\MarketingTool;

class MarketingToolRepository implements MarketingToolRepositoryInterface
{
    public function all()
    {
        return MarketingTool::all();
    }

    public function create(array $data)
    {
        return MarketingTool::create($data);
    }

    public function find($id)
    {
        return MarketingTool::find($id);
    }

    public function update(array $data, $id)
    {
        return MarketingTool::find($id)->update($data);
    }

    public function delete($id)
    {
        return MarketingTool::destroy($id);
    }

    public function getLatest()
    {
        return MarketingTool::latest()->get();
    }
}