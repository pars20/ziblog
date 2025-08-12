<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'     =>'required|min:5|max:255',
            'content'   =>'required|min:5|max:2000',
            'image'     => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Max 2MB
        ];
    }


    public function attributes()
    {
        return [
            'title'     => 'Post Title',
            'content'   => 'Post Content',
            'image'     => 'Post Cover',
        ];  
    }
}

