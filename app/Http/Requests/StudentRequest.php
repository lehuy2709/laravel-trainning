<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name' => 'required|min:10|max:30',
            'email' => 'required|email|unique:students|max:40',
            'phone' => 'required|numeric|min:10',
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|min:10|max:200',
            'birthday' => 'required|before:today'

        ];
    }
}
