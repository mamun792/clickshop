<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Admin\Report\ReportRepositoryInterface;

use Illuminate\Http\Request;


class InventoryController extends Controller
{

    protected $reportRepository;


    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function index(Request $request)
    {

      $stockReports = $this->reportRepository->getStockReport();

        foreach ($stockReports as &$report) {
            foreach ($report['product_attributes'] as &$attribute) {
                $attribute['initial_stock'] = $attribute['quantity'] + $attribute['sold_quantity'];
            }
        }
        


        return view('admin.inventory.index', compact('stockReports'));
    }








    public function stockOutProducts()
    {

        $stockOutReports = $this->reportRepository->getOutStockReport();
        return view('admin.inventory.stock-out-products', compact('stockOutReports'));
    }


    public function upcommingStockOutProducts()
    {
         $upcommingStockOutReports = $this->reportRepository->getUpcommingStockOutReport();
        return view('admin.inventory.upcomming-stock-out-products', compact('upcommingStockOutReports'));
    }
}
