<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NoPostKeyword;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust authorization as needed
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255', new NoPostKeyword()],
            'content' => 'required|string',
            'image' => 'nullable', 
        ];
    }
}
