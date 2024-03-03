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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->foreignId('author_id')->constrained();
            $table->foreignId('genre_id')->constrained();
            $table->unsignedInteger('price');
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('is_public')->default(true);
            //image
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
