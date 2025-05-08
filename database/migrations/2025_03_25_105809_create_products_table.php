<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('ref')->unique();
        $table->decimal('diameter', 8, 2);
        $table->decimal('height', 8, 2);
        $table->string('image')->nullable();
        $table->decimal('np', 10, 2)->nullable();
        $table->decimal('nr', 10, 2)->nullable();
        $table->unsignedBigInteger('subcategory_id');
        
        // الوصف بلغات متعددة
        $table->text('description_en')->nullable();
        $table->text('description_de')->nullable();
        $table->text('description_fr')->nullable();
        $table->text('description_es')->nullable();
        $table->text('description_ar')->nullable();

        $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
