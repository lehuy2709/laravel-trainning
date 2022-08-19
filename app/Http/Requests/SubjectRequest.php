<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'name' => 'required|unique:subjects|min:10|max:30',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Subject name already exists',
            'name.min' => 'Subject name at least 10 characters',
            'name.max' => 'Subject name up to 30 characters'
        ];
    }
}
