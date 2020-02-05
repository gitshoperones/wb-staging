<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorReviewRequest extends FormRequest
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
            'couple1_email' => 'sometimes|email|unique:vendor_reviews,email',
            'couple2_email' => 'sometimes|email|unique:vendor_reviews,email',
        ];
    }

    public function message()
    {
        return [
            'couple1_email.unique' => 'You already have a review from couple 1.'
        ];
    }
}
