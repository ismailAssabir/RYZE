<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(3, true);
        return [
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'sku' => fake()->unique()->bothify('RYZ-####'),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 99, 1999),
            'stock' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
