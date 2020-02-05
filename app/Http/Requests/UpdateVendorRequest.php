<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'business_name' => 'sometimes|nullable|string|max:200',
            'trading_name' => 'sometimes|nullable|string|max:200',
            'desc' => 'sometimes|nullable',
            'abn' => 'sometimes|nullable|max:200',
            'contact_name' => 'sometimes|nullable|string|max:200',
            'contact_email' => 'sometimes|nullable|email|max:200',
            'website' => 'sometimes|nullable|string|max:200',
            'contact_phone_number' => 'sometimes|nullable|string|max:200',
            'location_id' => 'sometimes|nullable|integer|exists:locations,id',
            'profile_avatar' => 'sometimes|nullable|mimes:jpg,jpeg,png|max:10000',
            'profile_cover' => 'sometimes|nullable|mimes:jpg,jpeg,png|max:10000',
        ];
    }
}
