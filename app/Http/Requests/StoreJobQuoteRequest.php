<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobQuoteRequest extends FormRequest
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
            'job_post_id' => 'required|integer|exists:job_posts,id',
            'duration' => 'sometimes|nullable|date_format:d/m/Y'
        ];
    }

    public function messages()
    {
        return [
            'duration.*' => 'Invalid quote expiration date.',
            'job_post_id.*' => 'Invalid job post.'
        ];
    }
}
