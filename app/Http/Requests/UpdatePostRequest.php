<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return auth()->check();
        // $post = $this->route( 'post' );
        // return $this->user()->id === $post->user_id;
        return $this->user()->can( 'update', $this->route('post') );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=>'required|min:5|max:255',
            'content'=>'required|min:5|max:2000',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Post Title',
            'content' => 'Post Content',
        ];  
    }
    
}
