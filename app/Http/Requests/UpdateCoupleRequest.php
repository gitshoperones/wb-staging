<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoupleRequest extends FormRequest
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
            'title' => 'sometimes|nullable|string|max:200',
            'wedding_venue_id' => 'sometimes|nullable|integer|exists:locations,id',
            'ceremony_venue_id' => '|sometimes|nullable|integer|exists:locations,id',
            'reception_venue_id' => 'sometimes|nullable|integer|exists:locations,id',
            'userA_id' => 'sometimes|nullable|integer|exists:users,id',
            'userB_id' => 'sometimes|nullable|integer|exists:users,id',
            'total_guest_invited' => 'sometimes|nullable|integer',
            'total_guest_confirmed' => 'sometimes|nullable|integer',
            'wedding_date' => 'sometimes|nullable|date',
            'desc' => 'sometimes|nullable',
            'profile_avatar' => 'sometimes|nullable|mimes:jpg,jpeg,png|max:10000',
            'profile_cover' => 'sometimes|nullable|mimes:jpg,jpeg,png|max:10000',
        ];
    }
}
