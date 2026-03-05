<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('developers', function (Blueprint $table) {
            $table->decimal('rating', 3, 2)->nullable()->change();
            $table->integer('total_reviews')->nullable()->change();
            $table->integer('total_completed_projects')->nullable()->change();

            $table->enum('availability', ['available','busy','unavailable'])
                  ->default('available')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('developers', function (Blueprint $table) {
            $table->decimal('rating', 3, 2)->nullable(false)->change();
            $table->integer('total_reviews')->nullable(false)->change();
            $table->integer('total_completed_projects')->nullable(false)->change();

            $table->enum('availability', ['available','busy','unavailable'])
                  ->default(null)
                  ->change();
        });
    }
};