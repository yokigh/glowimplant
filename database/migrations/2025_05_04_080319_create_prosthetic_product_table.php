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
        Schema::create('prosthetic_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name_en');
            $table->string('name_de');
            $table->string('name_fr');
            $table->string('name_es');
            $table->string('name_ar');
            $table->text('description_en')->nullable();
            $table->text('description_de')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_es')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('ref');
            $table->string('diameter');
            $table->integer('height');
            $table->string('ml');
            $table->double('angle');
            $table->string('screw_ref');
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->unsignedBigInteger('prosthetic_category_id');
            $table->foreign('prosthetic_category_id')->references('id')->on('prosthetic_categories')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosthetic_product');
    }
};
