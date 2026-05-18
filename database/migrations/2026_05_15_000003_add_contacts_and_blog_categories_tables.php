<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('subject');
                $table->text('message');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('blog_categories')) {
            Schema::create('blog_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        // Adapter blogs existants (si la table blogs existe)
        if (Schema::hasTable('blogs')) {
            Schema::table('blogs', function (Blueprint $table) {
                if (!Schema::hasColumn('blogs', 'blog_category_id')) {
                    $table->foreignId('blog_category_id')->nullable()->after('id');
                }

                // supprimer l'ancienne colonne 'category' si elle existe et qu'on veut coller au schéma
                if (Schema::hasColumn('blogs', 'category')) {
                    $table->dropColumn('category');
                }

                if (!Schema::hasColumn('blogs', 'content') && Schema::hasColumn('blogs', 'body')) {
                    // on garde body si content absent ; on ne peut pas convertir en ALTER simple sans data
                    // donc on crée content et on laisse la migration suivante gérer le mapping si besoin
                }

                if (!Schema::hasColumn('blogs', 'content') && Schema::hasColumn('blogs', 'body')) {
                    $table->longText('content')->nullable()->after('image');
                }

                if (Schema::hasColumn('blogs', 'published') === false) {
                    // si table n'a pas published mais a is_published + published_at, on laisse (plus simple)
                    if (!Schema::hasColumn('blogs', 'published') && Schema::hasColumn('blogs', 'is_published')) {
                        $table->boolean('published')->default(false)->after('content');
                    }
                }

                if (Schema::hasColumn('blogs', 'published_at') && Schema::hasColumn('blogs', 'published')) {
                    // on ne supprime pas published_at ici
                }

                // Ajuster colonnes nommées
                if (Schema::hasColumn('blogs', 'excerpt') && !Schema::hasColumn('blogs', 'content')) {
                    // noop
                }

                if (Schema::hasColumn('blogs', 'title') === false) {
                    $table->string('title')->after('blog_category_id');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('blogs')) {
            Schema::table('blogs', function (Blueprint $table) {
                if (Schema::hasColumn('blogs', 'blog_category_id')) {
                    $table->dropForeign(['blog_category_id']);
                    $table->dropColumn('blog_category_id');
                }
                if (Schema::hasColumn('blogs', 'published')) {
                    $table->dropColumn('published');
                }
                if (Schema::hasColumn('blogs', 'content')) {
                    $table->dropColumn('content');
                }
                // on ne rétablit pas 'category' automatiquement
            });
        }

        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('contacts');
    }
};

