<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

            return [
                'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|dimensions:width=1900,height=560',
            ];


    }

    public function messages()
    {
        return [
            'image_path.required' => 'Image is required',
            'image_path.image' => 'Image must be an image file',
            'image_path.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg, webp',
            'image_path.dimensions' => 'Image must be 1900x560 pixels',
        ];
    }
}
