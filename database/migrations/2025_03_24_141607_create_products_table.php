<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->decimal('diameter', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->decimal('np', 10, 2)->nullable();
            $table->decimal('nr', 10, 2)->nullable();
            $table->foreignId('subcategory_id')->constrained('subcategories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('locale');
            $table->text('description')->nullable();
            $table->unique(['product_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_translations');
        Schema::dropIfExists('product_prices');
        Schema::dropIfExists('products');
    }
};

