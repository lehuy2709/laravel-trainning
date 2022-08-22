<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Stmt\Switch_;

class FacultyRequest extends FormRequest
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
            'name' => 'required|unique:faculties|min:10|max:30',
        ];

        if ($this->route('faculty')) {
            $data['name'] = 'required|min:10|max:30|unique:faculties,id,' . $this->route('faculty');
        }
        
        return $data;
    }
}
