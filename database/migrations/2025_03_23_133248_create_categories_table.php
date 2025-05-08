<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_de')->nullable();
            $table->string('name_fr')->nullable();
            $table->string('name_es')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_de')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_es')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // تخزين صور متعددة كـ JSON
            $table->string('catalog')->nullable(); // ملف PDF للكتالوج
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
