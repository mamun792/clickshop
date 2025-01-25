<?php

namespace App\Http\Requests\Admin\Campain;

use Illuminate\Foundation\Http\FormRequest;

class CampainRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after:start_date',
            'discount' => 'required|string|max:255',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'start_date.required' => 'Start date is required',
            'expiry_date.required' => 'Expiry date is required',
            'expiry_date.after' => 'Expiry date must be after start date',
            'discount.required' => 'Discount is required',
            
        ];
    }
}

