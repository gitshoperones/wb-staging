<?php

namespace App\Http\Requests;

use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCoupleOnboardingRequest extends FormRequest
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
            'userA_lname' => 'required|string|max:255',
            'userA_fname' => 'required|string|max:255',
            'userB_fname' => 'required|string|max:255',
            'userB_lname' => 'required|string|max:255',
            // 'dob' => ['required', 'date', function ($attribute, $value, $fail) {
            //     $limitDate = now()->subYears(18)->format('Y-m-d');
            //     $bday = Carbon::parse($value)->format('Y-m-d');

            //     if ($bday > $limitDate) {
            //         $fail('You must be at least 18 years old.');
            //     }
            // }],
        ];
    }
}
