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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title');
            $table->string('slug')->unique(); // ->unique() ensures no two posts can have the same slug value
            $table->longText('content'); // longText allows storing large amounts of text
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // ->constrained(): Automatically references the id column of a table named categories. || ->onDelete('cascade') If the related category is deleted, the associated posts will be automatically deleted too.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
