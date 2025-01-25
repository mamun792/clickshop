<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // $couponId = $this->route('coupon') ? $this->route('coupon')->id : null;

        return [
            // 'code' => [
            //     'required',
            //     'string',
            //     Rule::unique('coupons')->ignore($couponId), 
            // ],
            'discount_type' => 'required|string|in:fixed,percentage',
            'discount_amount' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:valid_from',
            'usage_limit' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Coupon code is required',
            'code.string' => 'Coupon code must be a string',
            'code.unique' => 'Coupon code already exists',
            'discount_type.required' => 'Discount type is required',
            'discount_type.in' => 'Discount type must be either fixed or percentage',
            'discount_amount.required' => 'Discount amount is required',
            'discount_amount.numeric' => 'Discount amount must be a number',
            'discount_amount.min' => 'Discount amount must be greater than or equal to 0',
            'valid_from.required' => 'Valid from date is required',
            'valid_from.date' => 'Valid from date must be a date',
            'expiry_date.required' => 'Expiry date is required',
            'expiry_date.date' => 'Expiry date must be a date',
            'expiry_date.after_or_equal' => 'Expiry date must be after or equal to valid from date',
            'usage_limit.required' => 'Usage limit is required',
            'usage_limit.integer' => 'Usage limit must be an integer',
            'usage_limit.min' => 'Usage limit must be greater than or equal to 1',
        ];
    }
}