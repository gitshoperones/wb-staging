<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoupleAccountSettingsRequest extends FormRequest
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
            'your_email' => 'required|email|unique:users,email,'. $this->get('my_id'),
            'your_firstname' => 'required',
            'your_lastname' => 'required',
            'partner_firstname' => 'required',
            'partner_lastname' => 'required',
            'phone_number' => 'required',
            'password' => 'sometimes|nullable|confirmed|string|min:6|max:100',
        ];
    }
}
