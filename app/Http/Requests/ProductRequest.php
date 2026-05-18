<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $id = $this->route('product')?->id;

        return [
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:180',
            'sku' => 'required|string|max:80|unique:products,sku,' . $id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'sizes' => 'nullable|array',
            'colors' => 'nullable|array',

            // product images
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'images_alt' => 'nullable|array',
            'images_alt.*' => 'nullable|string|max:255',
        ];
    }
}

