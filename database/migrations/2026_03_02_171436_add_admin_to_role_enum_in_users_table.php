<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Modify enum to include 'admin'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['client', 'developer', 'admin'])
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['client', 'developer'])
                  ->change();
        });
    }
};
