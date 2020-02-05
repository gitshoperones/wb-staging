<?php

namespace App\Http\Requests;

use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVendorPaymentSettingsRequest extends FormRequest
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
        $rules = app('impersonate')->isImpersonating() ? 
            [
                // 'bank' => 'required',
                // 'accnt_name' => 'required',
                // 'accnt_num' => 'required|numeric',
                // 'bsb' => 'required|numeric|digits:6',
                // 'birth_day' => 'required',
                // 'birth_month' => 'required',
                // 'birth_year' => 'required',
                // 'accnt_type' => ['required', Rule::in(['checking', 'savings'])],
                // 'holder_type' => ['required', Rule::in(['personal', 'business'])],
                // 'gst_registered' => ['required', Rule::in([0, 1])],
                'street' => 'required',
                'city' => 'required',
                'state' => 'required',
                'postcode' => 'required',
            ]
        : [
            // 'bank' => 'required',
            // 'accnt_name' => 'required',
            // 'accnt_num' => 'required|numeric',
            // 'bsb' => 'required|numeric|digits:6',
            'birth_day' => 'required',
            'birth_month' => 'required',
            'birth_year' => 'required',
            'accnt_type' => ['required', Rule::in(['checking', 'savings'])],
            'holder_type' => ['required', Rule::in(['personal', 'business'])],
            'gst_registered' => ['required', Rule::in([0, 1])],
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'dob.*' => 'Please enter valid date of birth.'
        ];
    }
}
