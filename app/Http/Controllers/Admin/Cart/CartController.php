<?php

namespace App\Http\Controllers\Admin\Cart;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartAttribute;
use App\Services\Admin\Cart\CartServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Container\Attributes\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }




    public function addToCart(Request $request)
    {
  Log::info('Request Data:', $request->all());

        try {

            $data = $this->cartService->addToCart($request->all());


            return ApiResponse::success(
                ['success' => true, 'data' => $data],
                'Product added to cart successfully'
            );
        } catch (\Exception $e) {

            $errorMessage = $e->getMessage();


            if (str_contains($errorMessage, 'Attributes are required')) {
                return ApiResponse::validationError(
                    ['message' => $errorMessage],
                    'Attributes missing for product'
                );
            } elseif (str_contains($errorMessage, 'No stock found')) {
                return ApiResponse::error(
                    'Insufficient stock for the selected attribute(s).',
                    Response::HTTP_BAD_REQUEST,
                    ['message' => $errorMessage]
                );
            } elseif (str_contains($errorMessage, 'Not enough stock')) {
                return ApiResponse::error(
                    'Not enough stock available.',
                    Response::HTTP_BAD_REQUEST,
                    ['message' => $errorMessage]
                );
            }


            return ApiResponse::error(
                'Something went wrong while adding to the cart.',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                ['message' => $errorMessage]
            );
        }
    }





    public function getCartItems(Request $request)
    {


        return  $data = $this->cartService->getCartItems($request->input('user_id'));
    }

    public function removeCartItem(Request $request)
    {
        try {

            $cart_id = $request->input('cart_id');
            $user_id = $request->input('user_id');


            $deleted = $this->cartService->deleteCartItem($user_id, $cart_id);

            if ($deleted) {
                return ApiResponse::success(
                    ['success' => true],
                    'Product removed from cart successfully'
                );
            } else {
                return response()->json('Failed to remove product from cart');
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


    public function updateCartItem(Request $request)
    {

        Log::info('Request Data:', $request->all());

        // return response()->json($request->all());
        try {
            $data = $this->cartService->updateCartItem($request->all());
            return ApiResponse::success(
                ['success' => true, 'data' => $data],
                'Product updated in cart successfully'
            );
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function clearCart(Request $request)
    {
        try {
            $userId = $request->input('user_id');

            if (!$userId) {
                return ApiResponse::error(['success' => false], 'User ID is required', 400);
            }

            $deletedRows = $this->cartService->clearCart($userId);

            if ($deletedRows) {
                return ApiResponse::success(['success' => true], 'Cart cleared successfully');
            }
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error clearing cart:', ['error' => $e->getMessage()]);
            return ApiResponse::error(['success' => false], 'An unexpected error occurred. Please try again later.', 500);
        }
    }

}
