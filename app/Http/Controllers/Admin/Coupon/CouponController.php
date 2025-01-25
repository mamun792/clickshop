<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\StoreCouponRequest;
use App\Http\Requests\Admin\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\Product;
use App\Services\Admin\Coupon\CouponServiceInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }


    public function index()
    {
       $coupons = $this->couponService->allProductsInCoupon();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $coupons= $this->couponService->allCoupons();
        return view('admin.coupons.create', compact('coupons'));
    }

    public function store(StoreCouponRequest $request)
    {

        try {
            $this->couponService->createCoupon($request->validated());
            return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function show($coupon)
    {
        $coupon = $this->couponService->findCoupon($coupon);
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit($coupon)
    {
        $coupon = $this->couponService->findCoupon($coupon);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
      
        try {
            $this->couponService->updateCoupon($coupon, $request->validated());
            return redirect()->route('admin.coupons.create')->with('success', 'Coupon updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
      
        try {

            $coupon = Coupon::findOrFail($id);

            // Pass the Coupon model to the deleteCoupon method
            $this->couponService->deleteCoupon($coupon);
         
            return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
       
    }

    public function addProduct($coupon)
    {
       $coupon = Coupon::findOrFail($coupon);

       $products = $this->couponService->allProducts();
        return view('admin.coupons.addProduct', compact('products', 'coupon'));
    }

    public function checkUniqueCode(Request $request)
    {
        try {
            $code = $request->input('code');

            $isUnique = !Coupon::where('code', $code)->exists();

             return response()->json(['isUnique' => $isUnique]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong']);
        }
    }


    public function storeProduct(Request $request)
    {

        $validated = $request->validate([
            'coupon_id' => 'required|exists:coupons,id', 
            'example_length' => 'required|integer',
            'product_ids' => 'array|nullable', 
            'product_ids.*' => 'exists:products,id', 
        ]);
    
        // Find the coupon
        $coupon = Coupon::findOrFail($request->input('coupon_id'));
        $coupon->update($request->except('_token'));

      
        $coupon->products()->sync($request->input('product_ids'));

        return redirect()->back()->with('success', 'Products added to coupon successfully');
    }
    
    



    public function deleteCouponWithProduct(Request $request, $id)
    {

        try {
            $coupon = Coupon::find($request->coupon_id);

            if (!$coupon) {
                return redirect()->back()->with('error', 'Coupon not found');
            }

            $productIds = explode(',', $request->product_ids);


            $coupon->products()->detach($productIds);

            return redirect()->back()->with('success', 'Product removed from coupon successfully');
        } catch (\Exception $e) {
            Log::error('Error removing products from coupon: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
