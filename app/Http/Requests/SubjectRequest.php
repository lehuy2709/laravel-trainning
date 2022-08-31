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
        $data = [
            'name' => 'required|unique:subjects|min:10|max:30',
        ];

        if ($this->route('subject')) {
            $data['name'] = 'required|min:10|max:30|unique:subjects,name,' . $this->route('subject');
        }

        return $data;
    }
}
