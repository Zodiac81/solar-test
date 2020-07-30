<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
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
            'body' => 'required|min:5|max:255',
            'parent_id' => 'nullable|integer|min:0|exists:comments,id'
        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'A body is required',
        ];
    }
}
