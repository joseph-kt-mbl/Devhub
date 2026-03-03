<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('bio');
            $table->decimal('hourly_rate',6,2);
            $table->integer('experience_years');
            $table->enum('availability', ['available','busy', 'unavailable']);
            $table->string('location')->nullable();
            $table->boolean('remote_only')->default(true);
            $table->decimal('rating',3,2);
            $table->integer('total_reviews');  
            $table->integer('total_completed_projects');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developers');
    }
};
