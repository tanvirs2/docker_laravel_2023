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
        Schema::create('personalize_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('sources')->nullable(); // JSON data
            $table->text('authors')->nullable(); // JSON data
            $table->text('categories')->nullable(); // JSON data
            $table->enum('status', ['on', 'off'])->default('on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalize_profiles');
    }
};
