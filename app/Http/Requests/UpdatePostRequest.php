<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $post = $this->route('post');

        return $post && $this->user()?->id === $post->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title'       => 'sometimes|string|max:255',
            'body'        => 'sometimes|string|min:50',
            'category_id' => 'sometimes|exists:categories,id',
            'status'      => 'sometimes|in:draft,published',
        ];
    }
}