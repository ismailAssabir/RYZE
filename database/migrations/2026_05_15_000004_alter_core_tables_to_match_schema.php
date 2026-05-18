<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // USERS
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('avatar');
            }
            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('birth_date');
            }
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken()->after('password');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'client'])->default('client')->after('password');
            } else {
                // si role est déjà string, on ne peut pas convertir sans connaître les données.
                // on laisse tel quel pour éviter casse.
            }
        });

        // CATEGORIES: align to {name, slug(unique), image(nullable), description(nullable)}
        Schema::table('categories', function (Blueprint $table) {
            // ensure required columns exist
            if (!Schema::hasColumn('categories', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
            if (!Schema::hasColumn('categories', 'image')) {
                $table->string('image')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('categories', 'description')) {
                $table->text('description')->nullable()->after('image');
            }

            // remove extra columns if they exist
            if (Schema::hasColumn('categories', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
            if (Schema::hasColumn('categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('categories', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });

        // PRODUCTS: add subcategory_id, weight, status enum, featured/trending booleans, thumbnail
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'subcategory_id')) {
                $table->foreignId('subcategory_id')->nullable()->after('category_id');
            }

            if (!Schema::hasColumn('products', 'weight')) {
                $table->decimal('weight', 10, 2)->nullable()->after('sale_price');
            }

            if (!Schema::hasColumn('products', 'status')) {
                $table->boolean('status')->default(true)->after('stock');
            }

            if (!Schema::hasColumn('products', 'featured')) {
                $table->boolean('featured')->default(false)->after('stock');
            }

            if (!Schema::hasColumn('products', 'trending')) {
                $table->boolean('trending')->default(false)->after('featured');
            }

            // If the old column names exist, drop them to match the new schema.
            if (Schema::hasColumn('products', 'is_trending') && !Schema::hasColumn('products', 'trending')) {
                $table->dropColumn('is_trending');
            }



            if (!Schema::hasColumn('products', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('description');
            }

            // map existing column names if present
            if (Schema::hasColumn('products', 'is_featured') && !Schema::hasColumn('products', 'featured')) {
                $table->dropColumn('is_featured');
            }

            // If is_trending exists but trending does not, drop it (keep index/schema aligned)
            if (Schema::hasColumn('products', 'is_trending') && !Schema::hasColumn('products', 'trending')) {
                $table->dropColumn('is_trending');
            }



            // remove json sizes/colors/attributes if they exist
            if (Schema::hasColumn('products', 'sizes')) {
                $table->dropColumn('sizes');
            }
            if (Schema::hasColumn('products', 'colors')) {
                $table->dropColumn('colors');
            }
            if (Schema::hasColumn('products', 'attributes')) {
                $table->dropColumn('attributes');
            }

            // remove popular if not in schema
            if (Schema::hasColumn('products', 'is_popular')) {
                $table->dropColumn('is_popular');
            }
        });

        // PRODUCT_IMAGES: align to image/alt and remove path/alt naming mismatch
        Schema::table('product_images', function (Blueprint $table) {
            if (Schema::hasColumn('product_images', 'path') && !Schema::hasColumn('product_images', 'image')) {
                $table->string('image')->nullable()->after('product_id');
                // data mapping not handled
                $table->dropColumn('path');
            }
            if (!Schema::hasColumn('product_images', 'image')) {
                $table->string('image')->after('product_id');
            }
            if (!Schema::hasColumn('product_images', 'created_at')) {
                $table->timestamps();
            }
        });

        // CARTS: remove unit_price if not in schema
        Schema::table('carts', function (Blueprint $table) {
            if (!Schema::hasColumn('carts', 'product_id')) {
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            }
            if (Schema::hasColumn('carts', 'unit_price')) {
                $table->dropColumn('unit_price');
            }
            if (Schema::hasColumn('carts', 'session_id')) {
                $table->dropColumn('session_id');
            }
        });

        // ORDERS: align columns
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_number')) {
                // existing column 'number'
                if (Schema::hasColumn('orders', 'number')) {
                    $table->renameColumn('number', 'order_number');
                } else {
                    $table->string('order_number')->unique()->after('id');
                }
            }

            // remove json addresses if needed
            // (on ne convertit pas automatiquement le type JSON -> TEXT car cela requiert du mapping)


            if (!Schema::hasColumn('orders', 'total_amount')) {
                if (Schema::hasColumn('orders', 'total')) {
                    $table->renameColumn('total', 'total_amount');
                } else {
                    $table->decimal('total_amount', 10, 2)->after('order_number');
                }
            }

            if (!Schema::hasColumn('orders', 'shipping_fee')) {
                if (Schema::hasColumn('orders', 'shipping')) {
                    $table->renameColumn('shipping', 'shipping_fee');
                } else {
                    $table->decimal('shipping_fee', 10, 2)->default(0)->after('total_amount');
                }
            }

            if (!Schema::hasColumn('orders', 'tax')) {
                $table->decimal('tax', 10, 2)->default(0)->after('shipping_fee');
            }

            if (!Schema::hasColumn('orders', 'payment_method') && Schema::hasColumn('orders', 'payment_method')) {
                // noop
            }

            // status enums
            if (Schema::hasColumn('orders', 'status')) {
                // ensure enum values match
                // can't alter enum safely without DB driver; leave as-is.
            }

            if (Schema::hasColumn('orders', 'payment_status') === false) {
                $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            }

            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->text('shipping_address')->after('order_number');
            }
            if (!Schema::hasColumn('orders', 'city')) {
                $table->string('city')->nullable()->after('shipping_address');
            }
            if (!Schema::hasColumn('orders', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('city');
            }
            if (!Schema::hasColumn('orders', 'country')) {
                $table->string('country')->nullable()->after('postal_code');
            }
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone')->nullable()->after('country');
            }

            // notes already exists
        });

        // ORDER_ITEMS
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'size')) {
                $table->string('size')->nullable()->after('color');
            }
            if (Schema::hasColumn('order_items', 'product_name')) {
                $table->dropColumn('product_name');
            }
            if (Schema::hasColumn('order_items', 'sku')) {
                // keep/adjust
                $table->dropColumn('sku');
            }

            // Si 'total' existe, on le renomme en 'price' (sinon on crée 'price' seulement s'il n'existe pas)
            if (Schema::hasColumn('order_items', 'total') && !Schema::hasColumn('order_items', 'price')) {
                $table->renameColumn('total', 'price');
            }

            if (!Schema::hasColumn('order_items', 'price')) {
                $table->decimal('price', 10, 2)->after('quantity');
            }

            if (!Schema::hasColumn('order_items', 'created_at')) {
                $table->timestamps();
            }

        });

        // PAYMENTS
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'transaction_id')) {
                if (Schema::hasColumn('payments', 'provider_id')) {
                    $table->renameColumn('provider_id', 'transaction_id');
                } else {
                    $table->string('transaction_id')->nullable()->after('order_id');
                }
            }
            if (!Schema::hasColumn('payments', 'payment_method')) {
                if (Schema::hasColumn('payments', 'provider')) {
                    $table->renameColumn('provider', 'payment_method');
                } else {
                    $table->string('payment_method')->after('transaction_id');
                }
            }
            if (!Schema::hasColumn('payments', 'status')) {
                $table->enum('status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            }
        });

        // REVIEWS
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'title')) {
                $table->dropColumn('title');
            }
            if (!Schema::hasColumn('reviews', 'comment')) {
                // noop
            }
            if (!Schema::hasColumn('reviews', 'rating')) {
                $table->unsignedTinyInteger('rating');
            }
            if (Schema::hasColumn('reviews', 'is_approved')) {
                $table->dropColumn('is_approved');
            }
        });

        // WISHLISTS/CARTS/CATEGORIES already handled partially

        // CONTACTS already created; notifications not present in create_ryze? it's in down drop but not created now.
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        } else {
            Schema::table('notifications', function (Blueprint $table) {
                if (!Schema::hasColumn('notifications', 'title')) {
                    $table->string('title')->nullable();
                }
                if (!Schema::hasColumn('notifications', 'message')) {
                    $table->text('message')->nullable();
                }
                if (!Schema::hasColumn('notifications', 'is_read')) {
                    $table->boolean('is_read')->default(false);
                }
            });
        }
    }

    public function down(): void
    {
        // Down volontairement minimal pour éviter pertes de données
    }
};

