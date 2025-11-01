<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
            return [
                // job_post
                'job_post.event_name' => ['required', 'string', 'max:200'],
                'job_post.prefecture' => ['required', 'string', 'max:4'],
                'job_post.location' => ['required', 'string', 'max:200'],
                'job_post.description' => ['required', 'string'],
                'job_post.payment' => ['nullable', 'string', 'max:200'],
                'job_post.contact_method' => ['required', 'in:email,line'],
                'job_post.is_public' => ['boolean'],
                'job_post.is_closed' => ['boolean'],
                'job_post.deadline' => ['nullable', 'date'],
                'job_post.number_of_position' => ['nullable', 'integer', 'min:1'],
                // tags
                'tags' => ['required', 'array'],
                'tags.pin' => ['boolean'],
                'tags.truss' => ['boolean'],
                'tags.pre_stay' => ['boolean'],
                'tags.post_stay' => ['boolean'],
                // dates
                'dates' => ['required', 'array', 'min:1'],
                'dates.*.work_date' => ['required', 'date'],
                'dates.*.start_time' => ['nullable', 'date_format:H:i'],
                'dates.*.end_time' => ['nullable', 'date_format:H:i'],
            ];
    }
}
