<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\PromotionBanner;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RyzeSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure admin account exists with known credentials
        $admin = User::updateOrCreate(['email' => 'admin@ryze.test'], [
            'name' => 'RYZE Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        Admin::updateOrCreate(
            ['user_id' => $admin->id],
            ['position' => 'Store Manager', 'permissions' => ['*']]
        );


        $names = ['Football', 'Basketball', 'Running', 'Gym', 'Musculation', 'Nutrition', 'Chaussures', 'Accessoires'];

        // Your DB schema for `categories` may or may not contain `is_active`.
        // Create categories with the mandatory fields only.
        $categories = collect($names)->map(fn ($name) => Category::updateOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name]
        ));

        $brands = collect(['RYZE', 'Nike', 'Adidas', 'Gymshark'])->map(fn ($name) => Brand::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'is_active' => true]));

        foreach (range(1, 24) as $i) {
            $name = ['Pro Training Tee', 'Velocity Runner', 'Power Grip Gloves', 'Hydro Fuel Pack', 'Match Elite Ball'][$i % 5] . ' ' . $i;
            // Your DB schema for `products` may or may not include legacy columns
            // like is_featured / is_trending / is_popular. Seed only the columns that
            // exist to avoid hard failures.
            $product = Product::updateOrCreate(
                ['sku' => 'RYZ-' . str_pad((string) $i, 4, '0', STR_PAD_LEFT)],
                [
                    'category_id' => $categories->random()->id,
                    'brand_id' => $brands->random()->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => 'Produit sportif premium RYZE concu pour performance, confort et durabilite.',
                    'short_description' => 'Performance gear premium.',
                    'price' => fake()->numberBetween(199, 1499),
                    'sale_price' => $i % 4 === 0 ? fake()->numberBetween(149, 999) : null,
                    'stock' => fake()->numberBetween(3, 80),
                    // `sizes`/`colors` exist only in older schema.
                    'sizes' => ['S', 'M', 'L', 'XL'],
                    'colors' => ['Black', 'White', 'Red'],
                    'is_active' => true,
                    'featured' => $i <= 8,
                    'trending' => $i % 2 === 0,
                    // `popular` may not exist depending on schema version
                
                ]
            );

            ProductImage::updateOrCreate(['product_id' => $product->id, 'is_primary' => true], ['path' => 'images/ryze-logo.jpeg', 'alt' => $product->name]);
        }

        Coupon::updateOrCreate(['code' => 'RYZE10'], ['type' => 'percent', 'value' => 10, 'minimum_amount' => 300, 'usage_limit' => 100, 'is_active' => true]);
        PromotionBanner::updateOrCreate(['title' => 'Flash Sale RYZE'], ['subtitle' => 'Jusqu a -30% sur running et gym', 'button_label' => 'Shop now', 'button_url' => '/shop', 'is_active' => true]);
    }
}
