<?php

namespace App\Http\Requests\Admin\CouriarApiSetting;

use Illuminate\Foundation\Http\FormRequest;

class CourierApiSettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //'is_active' => 'nullable|string|in:steadfast,pathao,redx',

            'api_key' => 'nullable|string|max:255',
            'secret_key' => 'nullable|string|max:255',

            'pathao_client_id' => 'nullable|string|max:255',
            'pathao_client_secret' => 'nullable|string|max:255',
            'pathao_secret_token' => 'nullable|string|max:255',
            'pathao_store_id' => 'nullable|string|max:255',
            'pathao_store_name' => 'nullable|string|max:255',

            'redx_sandbox' => 'nullable|string|max:255',
            'redx_access_token' => 'nullable|string|max:255',

            'steadfast' => 'nullable|string|in:yes,no',
            'redx' => 'nullable|string|in:yes,no',
            'pathao' => 'nullable|string|in:yes,no',


        ];
    }

    public function messages()
    {
        return [
            'api_key.string' => 'The API Key must be a valid string.',
            'secret_key.string' => 'The Secret Key must be a valid string.',
            'api_key.max' => 'The API Key may not be greater than 255 characters.',
            'secret_key.max' => 'The Secret Key may not be greater than 255 characters.',
        ];
    }

    /*
    public function prepareForValidation()
    {

        $this->merge([
            'is_active' => in_array($this->is_active, ['steadfast', 'pathao', 'redx']) ? $this->is_active : null,
        ]);
    }

    */
}
