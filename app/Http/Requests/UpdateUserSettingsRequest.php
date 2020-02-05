<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserSettingsRequest extends FormRequest
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
            'legal_name' => 'required_if:form_src,payment',
            'bank' => 'required_if:form_src,payment',
            'accnt_name' => 'required_if:form_src,payment',
            'accnt_num' => 'required_if:form_src,payment',
            'bsb' => 'required_if:form_src,payment',
            'accnt_type' => 'required_if:form_src,payment',
            'street' => 'required_if:form_src,payment',
            'street' => 'required_if:form_src,payment',
            'city' => 'required_if:form_src,payment',
            'state' => 'required_if:form_src,payment',
            'country' => 'required_if:form_src,payment',
            'postcode' => 'required_if:form_src,payment',
            'website' => 'required_if:form_src,account',
            'tac_file' => 'required_if:form_src,tc',
            'fname' => 'required_if:form_src,users',
            'lname' => 'required_if:form_src,users',
            'dob_d' => 'required_if:form_src,users|numeric|min:1|max:31',
            'dob_m' => 'required_if:form_src,users|numeric|min:1|max:12',
            'dob_y' => 'required_if:form_src,users|digits:4',
            'email' => 'required_if:form_src,users',
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
            'bank.*' => 'The Bank Name field is required.',
            'accnt_num.*' => 'The Bank Account Number field is required.',
            'bsb.*' => 'The BSB field is required.',
            'accnt_name.*' => 'The Bank Account Holder Name field is required.',
            'legal_name.*' => 'The Legal Business Name field is required.',
            'accnt_type.*' => 'The Account Type field is required.',
            'street.*' => 'The Street field is required.',
            'city.*' => 'The City field is required.',
            'state.*' => 'The State field is required.',
            'country.*' => 'The Country field is required.',
            'postcode.*' => 'The Postcode field is required.',
            'phone_number.required_if' => 'The Phone Number field is required.',
            'tac_file.required_if' => 'The TC File field is required.',
            'fname.required_if' => 'The Firstname field is required.',
            'lname.required_if' => 'The Lastname field is required.',
            'dob_d.*' => 'Please enter correct birth day.',
            'dob_m.*' => 'Please enter correct birth month.',
            'dob_y.*' => 'Please enter correct birth year.',
            'email.required_if' => 'The Email field is required.',
        ];
    }
}
