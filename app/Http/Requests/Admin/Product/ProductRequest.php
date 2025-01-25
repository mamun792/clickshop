<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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

        // Get the ID of the product being updated
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'product_name' => ['required', 'string', 'max:255'],
            // 'product_code' => ['required', 'string', 'max:255', 'unique:products,product_code'],
            'product_code' => ['nullable', 'string', 'max:255', 'unique:products,product_code,' . $productId],

            'purchase_product_code' => ['nullable', 'string', 'max:255', 'unique:products,product_code,' . $productId],

            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string'],

            'product_tag' => ['nullable', 'array'],
            'product_tag.*' => ['nullable', 'string'],

            'specification' => ['nullable', 'array'],
            'specification.*' => ['nullable', 'string'],

            // 'stock_option' => ['required', 'in:Manual,From Purchase'],
            'quantity' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],


            'previous_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($value && $value <= $this->price) {
                        $fail('The previous price must be greater than the current price.');
                    }
                },
            ],


            'attribute_prices' => ['nullable', 'array'],
            'attribute_prices.*' => ['nullable', 'numeric', 'min:0'],

            'attribute_quantities' => ['nullable', 'array'],
            'attribute_quantities.*' => ['nullable', 'integer', 'min:0'],



            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'integer', 'exists:sub_categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            //'featured_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // Make featured_image optional if updating an existing product
            'featured_image' => [$productId ? 'nullable' : 'required', 'image'],


            'gallery_images.*' => ['nullable', 'image'],
            'note'=> ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'slug' => ['nullable'],
            'feature' => ['nullable'],
            'status' => ['nullable'],
        ];
    }


}
