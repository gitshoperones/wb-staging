<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'. $this->get('user_id'),
            'fname' => 'required',
            'lname' => 'required',
            'password' => 'sometimes|nullable|confirmed|string|min:6|max:100',
        ];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function messages()
    {
        return [
            'dob_d.*' => 'Please enter correct birth day.',
            'dob_m.*' => 'Please enter correct birth month.',
            'dob_y.*' => 'Please enter correct birth year.',
        ];
    }
}
