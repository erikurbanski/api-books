<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'min:3',
                'max:40',
            ],
            'publisher' => [
                'required',
                'min:3',
                'max:40',
            ],
            'edition' => [
                'integer',
                'required',
            ],
            'year' => [
                'required',
                'min:4',
                'max:4',
            ],
            'value' => [
                'numeric',
                'required',
            ],
            'authors' => [
                'required',
                'array',
                'exists:author,id'
            ],
            'subjects' => [
                'required',
                'array',
                'exists:subject,id'
            ],
        ];
    }
}
