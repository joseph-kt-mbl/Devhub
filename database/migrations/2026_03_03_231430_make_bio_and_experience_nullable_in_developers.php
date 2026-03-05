<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('developers', function (Blueprint $table) {
            $table->text('bio')->nullable()->change();
            $table->integer('experience_years')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('developers', function (Blueprint $table) {
            $table->text('bio')->nullable(false)->change();
            $table->integer('experience_years')->nullable(false)->change();
        });
    }
};