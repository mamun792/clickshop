<?php

namespace App\Http\Requests\Admin\MarketingTool;

use Illuminate\Foundation\Http\FormRequest;

class MarketingToolStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'identifier' => 'required',
            'script' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'identifier.required' => 'Identifier is required',
        ];
    }
}