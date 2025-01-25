<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\Product;
use App\Repositories\Admin\Report\ReportRepositoryInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }


    public function index(Request $request)
    {
        // return $request;
       $orders = $this->reportRepository->getAllOrders($request);
        return view('admin.report.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.report.create');
    }

    public function officialSaleReport(Request $request)
    {
       $officialSaleReports = $this->reportRepository->getOfficialSaleReport($request);
        return view('admin.report.official-sale-report', compact('officialSaleReports'));
    }

    public function purchaseReport(Request $request)
    {
        $purchaseReports = $this->reportRepository->getPurchaseReport($request);
        return view('admin.report.purchase-report', compact('purchaseReports'));
    }

    public function stockReport()
    {

        // $stockReports= Product::with(['productAttributes.attribute', 'productAttributes.attributeOption'])->get();
        $stockReports = $this->reportRepository->getStockReport();

        return view('admin.report.stock-report', compact('stockReports'));
    }



}
