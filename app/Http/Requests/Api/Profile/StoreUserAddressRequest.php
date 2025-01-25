<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserAddressRequest extends FormRequest
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
           
            'name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:15', 'regex:/^[0-9\-\+\s\(\)]+$/'], // Allows phone formats like +1234567890 or (123) 456-7890
            'type' => ['nullable', 'in:office,home,other'], // Restrict to specific values
            'is_default' => ['boolean'], // Must be true or false
        ];
    }

    public function messages(): array
    {
        return [
           
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'address.string' => 'Address must be a valid string.',
            'address.max' => 'Address cannot exceed 500 characters.',
            'city.string' => 'City must be a valid string.',
            'city.max' => 'City cannot exceed 100 characters.',
            'phone.string' => 'Phone number must be a valid string.',
            'phone.max' => 'Phone number cannot exceed 15 characters.',
            'phone.regex' => 'Phone number format is invalid.',
            'type.required' => 'Address type is required.',
            'type.in' => 'Address type must be one of: office, home, or other.',
            'is_default.boolean' => 'Default status must be true or false.',
        ];
    }
}
