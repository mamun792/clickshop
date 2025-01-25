<?php

namespace App\Http\Requests\Admin\Smtp;

use Illuminate\Foundation\Http\FormRequest;

class SmtpSettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email_from' => 'required|email',
            'email_from_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|in:ssl,tls',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'email_from.required' => 'Email From is required',
            'email_from.email' => 'Email From must be a valid email address',
            'email_from_name.required' => 'Email From Name is required',
            'email_from_name.string' => 'Email From Name must be a string',
            'email_from_name.max' => 'Email From Name may not be greater than 255 characters',
            'contact_email.required' => 'Contact Email is required',
            'contact_email.email' => 'Contact Email must be a valid email address',
            'smtp_host.string' => 'SMTP Host must be a string',
            'smtp_host.max' => 'SMTP Host may not be greater than 255 characters',
            'smtp_encryption.in' => 'SMTP Encryption must be ssl or tls',
            'smtp_username.string' => 'SMTP Username must be a string',
            'smtp_username.max' => 'SMTP Username may not be greater than 255 characters',
            'smtp_password.string' => 'SMTP Password must be a string',
            'smtp_password.max' => 'SMTP Password may not be greater than 255 characters',
        ];
    }
}