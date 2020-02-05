<?php

namespace App\Http\Requests;

use App\Rules\JobStep;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobPostRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id',
            'locations' => 'required',
            // 'location_id' => 'sometimes|integer|exists:locations,id',
            'event_id' => 'required|integer|exists:events,id',
            'event_date' => 'sometimes|nullable',
            'budget' => 'sometimes|nullable|regex:/^[0-9]{1,10}(,[0-9]{3})*(\.[0-9]+)*$/',
            'photos.*' => 'sometimes|nullable|mimes:jpg,jpeg,png|max:10000',
            'status' => ['required', Rule::in(['0', '1', '3', '5'])],
        ];
    }

    public function messages()
    {
        return [
            'category_id.*' => 'Please select what you need.',
            'locations.*' => 'Please select a valid location.',
            'event_id.*' => 'Please select a valid event type.',
            // 'location_id.*' => 'Invalid location.',
            'budget.regex' => 'Invalid value in budget field.',
            'status.*' => 'Invalid job submission.'
        ];
    }
}
