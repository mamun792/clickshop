<?php

namespace App\Repositories\Admin\Report;

use App\Helpers\CacheHelper;
use App\Models\Order;

use App\Models\Product;

use App\Models\PurchaseGroup;
use App\Models\SiteInfo;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;




class ReportRepository implements ReportRepositoryInterface
{
    public function getAllOrders(Request $request): LengthAwarePaginator
    {
        $query = Order::with(['items.options', 'items.product'])
            ->orderBy('created_at', 'desc');

        $query = $this->applyFilters($query, $request);

        return $query->paginate(10);
    }


    public function getOfficialSaleReport(Request $request): LengthAwarePaginator
    {
        $query = Order::with(['items.options', 'items.product'])
            ->where('order_type', 'pos')
            ->orderBy('created_at', 'desc');

        $query = $this->applyFilters($query, $request);

        return $query->paginate(10);
    }

    public function getPurchaseReport(Request $request): LengthAwarePaginator
    {
        $query = PurchaseGroup::with('purchase.supplier')
            ->orderBy('created_at', 'desc');




        $query = $this->applyFilters($query, $request);

        return $query->paginate(10);
    }





    public function getStockReport(): LengthAwarePaginator
    {
        $products = Product::with([
            'productAttributes' => function ($query) {
                $query->select(['product_id', 'combination_id', 'attribute_id', 'attribute_option_id', 'quantity', 'sold_quantity']);
            },
            'productAttributes.attribute',
            'productAttributes.attributeOption',
        ])
            ->select('id', 'product_name', 'featured_image', 'sold_quantity', 'quantity', 'product_code', 'price')
            ->paginate(10);

        $products->getCollection()->transform(function ($product) {
            // Group product attributes by combination_id
            $product->productCombinations = $product->productAttributes->groupBy('combination_id')->map(function ($attributes, $combinationId) {
                return [
                    'combination_id' => $combinationId,
                    'attributes' => $attributes->map(function ($attribute) {
                        return [
                            'attribute_id' => $attribute->attribute_id,
                            'attribute_name' => $attribute->attribute->name ?? null,
                            'option_id' => $attribute->attribute_option_id,
                            'option_name' => $attribute->attributeOption->name ?? null,
                            'quantity' => $attribute->quantity,
                            'sold_quantity' => $attribute->sold_quantity,
                        ];
                    })->filter(), // Remove empty attributes
                ];
            })->filter(); // Remove empty groups

            unset($product->productAttributes); // Remove original attributes property
            return $product;
        });

        return $products;
    }









    protected function applyFilters($query, Request $request)
    {
        // Filter by date range
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($request->start_date) {
            $query->where('created_at', '>=', $request->start_date);
        } elseif ($request->end_date) {
            $query->where('created_at', '<=', $request->end_date);
        }

        // Filter by predefined date ranges
        if ($request->date_filter) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', now()->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', now()->subDay()->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month);
                    break;
            }
        }

        return $query;
    }



    // public function getOutStockReport(): LengthAwarePaginator
    // {


    //     $quantity_indicator =  0;

    //     $query = Product::with(['productAttributes.attribute', 'productAttributes.attributeOption'])
    //         ->where(function ($query) use ($quantity_indicator) {

    //             $query->whereDoesntHave('productAttributes')
    //                 ->orWhere(function ($query) use ($quantity_indicator) {

    //                     $query->whereHas('productAttributes', function ($subQuery) use ($quantity_indicator) {
    //                         $subQuery->selectRaw('sum(quantity) as total_quantity')
    //                             ->groupBy('product_id')
    //                             ->havingRaw('sum(quantity) <= ?', [$quantity_indicator]);
    //                     });
    //                 });
    //         });


    //     return $query->paginate(2);
    // }

    public function getOutStockReport(): LengthAwarePaginator
    {
        $quantity_indicator = 0;

        $query = Product::with(['productAttributes.attribute', 'productAttributes.attributeOption'])
            ->where(function ($query) use ($quantity_indicator) {
                // For products that have no attributes or their total stock is <= quantity_indicator
                $query->whereDoesntHave('productAttributes')
                    ->orWhere(function ($query) use ($quantity_indicator) {
                        $query->whereHas('productAttributes', function ($subQuery) use ($quantity_indicator) {
                            $subQuery->selectRaw('sum(quantity) as total_quantity')
                                ->groupBy('product_id')
                                ->havingRaw('sum(quantity) <= ?', [$quantity_indicator]);
                        });
                    });
            })
            // Include a check for the main product quantity as well
            ->where(function ($query) use ($quantity_indicator) {
                $query->orWhere('quantity', '<=', $quantity_indicator);
            });

        return $query->paginate(2);
    }




    public function getUpcommingStockOutReport()
    {

        $siteInfo = SiteInfo::first();
        $quantityIndicator = $siteInfo ? $siteInfo->quantity_indicator : 0;


        $products = Product::with([
            'productAttributes' => function ($query) {
                $query->select(['product_id', 'combination_id', 'attribute_id', 'attribute_option_id', 'quantity', 'sold_quantity']);
            },
            'productAttributes.attribute',
            'productAttributes.attributeOption',
        ])
            ->where('quantity', '<=', $quantityIndicator)
            ->select('id', 'product_name', 'sold_quantity', 'quantity', 'product_code', 'price')
            ->paginate(10);

        $products->getCollection()->transform(function ($product) {
            // Group product attributes by combination_id
            $product->productCombinations = $product->productAttributes->groupBy('combination_id')->map(function ($attributes, $combinationId) {
                return [
                    'combination_id' => $combinationId,
                    'attributes' => $attributes->map(function ($attribute) {
                        return [
                            'attribute_id' => $attribute->attribute_id,
                            'attribute_name' => $attribute->attribute->name ?? null,
                            'option_id' => $attribute->attribute_option_id,
                            'option_name' => $attribute->attributeOption->name ?? null,
                            'quantity' => $attribute->quantity,
                            'sold_quantity' => $attribute->sold_quantity,
                        ];
                    })->filter(),
                ];
            })->filter();

            unset($product->productAttributes);
            return $product;
        });

        return $products;
    }
}
