<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return ['rating' => 'required|integer|min:1|max:5', 'title' => 'nullable|string|max:120', 'comment' => 'required|string|min:10|max:2000'];
    }
}
