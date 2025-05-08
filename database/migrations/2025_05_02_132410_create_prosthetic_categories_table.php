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
        Schema::create('prosthetic_categories', function (Blueprint $table) {
            $table->id();
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
            $table->string('image')->nullable();
            $table->timestamps();
        });

        
    }

    public function down()
    {
        
        Schema::dropIfExists('prosthetic_categories');
    }

};
