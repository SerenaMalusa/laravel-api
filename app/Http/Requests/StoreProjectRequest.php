<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:20',
            'type_id' => ['nullable', 'exists:types,id'],
            'technologies' => 'exists:technologies,id',
            'description' => 'nullable|string',
            'repository' => 'required|max:20',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'github_link' => 'required',
            'creation_date' => 'required|date',
            'last_commit' => 'required|date'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            // 'title.required' => 'The title is required'
            'required' => 'The :attribute is required.',
            'string' => 'The :attribute must be a string',
            'max' => 'The :attribute must be no longer than :max characters',
            'date' => 'The :attribute must be in date format',
            'exists' => 'The chosen :attribute must be one of the list above',
            'image' => 'The file must be an image',
            'mimes' => 'The file must be one of the following types: :mimes'
        ];
    }
}
