<?php

namespace App\Services\Admin\Report;

use App\Models\Order;
use App\Repositories\Admin\Report\ReportRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportService implements ReportRepositoryInterface
{
    protected $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getAllOrders(Request $request): LengthAwarePaginator
    {
        return $this->reportRepository->getAllOrders($request);
    }

    public function getOfficialSaleReport(Request $request): LengthAwarePaginator
    {
        return $this->reportRepository->getOfficialSaleReport($request);
    }

    public function getPurchaseReport(Request $request): LengthAwarePaginator
    {
        return $this->reportRepository->getPurchaseReport($request);
    }

    public function getStockReport(): LengthAwarePaginator
    {
        return $this->reportRepository->getStockReport();
    }


    public function getOutStockReport(): LengthAwarePaginator
    {
        return $this->reportRepository->getOutStockReport();
    }

    public function getUpcommingStockOutReport(): LengthAwarePaginator
    {
        return $this->reportRepository->getUpcommingStockOutReport();
    }
   
}