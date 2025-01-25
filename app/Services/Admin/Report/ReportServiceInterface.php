<?php

namespace  App\Services\Admin\Report;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;

interface ReportServiceInterface
{
    public function getAllOrders(Request $request): LengthAwarePaginator;

    public function getOfficialSaleReport(Request $request): LengthAwarePaginator;

    public function getPurchaseReport(Request $request): LengthAwarePaginator;

    public function getStockReport(): LengthAwarePaginator;

    public function getOutStockReport(): LengthAwarePaginator;

    public function getUpcommingStockOutReport(): LengthAwarePaginator;

   
}