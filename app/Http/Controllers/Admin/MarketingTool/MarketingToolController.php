<?php

namespace App\Http\Controllers\Admin\MarketingTool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MarketingTool\MarketingToolStoreRequest;
use App\Services\Admin\MarketingTool\MarketingToolService;
use Illuminate\Http\Request;

class MarketingToolController extends Controller
{

    protected $marketingToolService;

    public function __construct(MarketingToolService $marketingToolService)
    {
        $this->marketingToolService = $marketingToolService;
    }


    public function index()
    {
         $marketingTools = $this->marketingToolService->getLatest();
         $groupedTools = $marketingTools->groupBy('name'); // Group tools by their name
      return view('admin.marketing-tool.index', compact('marketingTools','groupedTools'));
    }

    public function create()
    {
        return view('admin.marketing-tool.create');
    }

    public function store(MarketingToolStoreRequest $request)
    {
       
      try {
        $this->marketingToolService->create($request->validated());
        return redirect()->route('admin.marketing-tools.index')->with('success', 'Marketing tool created successfully');
      } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong');
      }
    }

    public function edit($id)
    {
        $marketingTool = $this->marketingToolService->find($id);
        return view('admin.marketing-tool.edit', compact('marketingTool'));
    }

    public function update(MarketingToolStoreRequest $request, $id)
    {
        try {
            $this->marketingToolService->Update($request->validated(), $id);
            return redirect()->route('admin.marketing-tools.index')->with('success', 'Marketing tool updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        try {
            $this->marketingToolService->delete($id);
            return redirect()->route('admin.marketing-tools.index')->with('success', 'Marketing tool deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
