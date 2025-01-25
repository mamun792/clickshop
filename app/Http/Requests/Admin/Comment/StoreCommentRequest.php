<?php

namespace App\Http\Requests\Admin\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'name' => 'required|string|max:255',
         
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not be greater than 255 characters',
            'status.required' => 'Status is required',
            'status.in' => 'Status must be either active or inactive',
        ];
    }

  // merge request status defualt to active
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['status'] = 'active';
        return $data;
    }
}