<?php

namespace App\Http\Requests\Admin\Manage_site;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateSiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'app_name' => 'nullable|string|max:255',
            'home_page_title' => 'nullable|string|max:255',
            'product_page_title' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'store_gateway_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240', 
            'store_phone_number' => 'nullable|string',
            'store_email' => 'nullable|email',
            'facebook_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'x_url' => 'nullable|url',
            'enable_facebook_login' => 'nullable',
            'enable_google_login' => 'nullable',
            'shipping_charge_inside_dhaka' => 'nullable|numeric',
            'shipping_charge_outside_dhaka' => 'nullable|numeric',
        ];
        

    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            'app_name.required' => 'App Name is required',
            'home_page_title.required' => 'Home Page Title is required',
            'product_page_title.required' => 'Product Page Title is required',
            'phone_number.required' => 'Phone Number is required',
            'whatsapp_number.required' => 'Whatsapp Number is required',
        ];
    }

}