<?php

namespace App\Http\Requests\Admin\Purchase;




use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }


    public function rules()
    {
        return [
            'purchase_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'invoice_number' => 'required|string|max:255|unique:purchases,invoice_number',
            'document' => 'nullable|file',
            'comment' => 'required|boolean',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'products' => 'required|json',
        ];
    }


    public function messages()
    {
        return [
            'purchase_name.required' => 'Purchase name is required.',
            'purchase_name.string' => 'Purchase name must be a string.',
            'purchase_name.max' => 'Purchase name must not be greater than 255 characters.',
            'purchase_date.required' => 'Purchase date is required.',
            'purchase_date.date' => 'Purchase date must be a valid date.',
            'invoice_number.required' => 'Invoice number is required.',
            'invoice_number.string' => 'Invoice number must be a string.',
            'invoice_number.max' => 'Invoice number must not be greater than 255 characters.',
            'invoice_number.unique' => 'Invoice number must be unique.',
            'document.file' => 'Document must be a file.',
            'comment.required' => 'Comment is required.',
            'comment.boolean' => 'Comment must be a boolean.',
            'supplier_id.required' => 'Supplier ID is required.',
            'supplier_id.integer' => 'Supplier ID must be an integer.',
            'supplier_id.exists' => 'Supplier ID does not exist.',
            'products.required' => 'Products are required.',
            'products.json' => 'Products must be a JSON array.',
        ];
    }
}
