<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateFeeRequest extends FormRequest
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
            'name' => 'required|unique:fees,name',
            'percent' => 'required|numeric|min:0.01|between:0.00,99.99',
            'payer' => ['required', Rule::in(['seller', 'buyer', 'cc', 'int_wire'])],
            'type' => ['required', Rule::in(['default', 'custom'])],
        ];
    }

    public function messages()
    {
        return [
            'payer.*' => 'Please select the account type who will pay the fee.',
        ];
    }
}
