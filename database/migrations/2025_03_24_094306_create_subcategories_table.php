<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            
            // الاسم لكل لغة
            $table->string('name_en');
            $table->string('name_de');
            $table->string('name_fr');
            $table->string('name_es');
            $table->string('name_ar');
            
            // الوصف لكل لغة
            $table->text('description_en')->nullable();
            $table->text('description_de')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_es')->nullable();
            $table->text('description_ar')->nullable();
            
            // صورة واحدة
            $table->string('image')->nullable();
            
            // مجموعة صور متعددة
            $table->json('images')->nullable();
            
            // كتالوج
            $table->string('catalog')->nullable();
            
            // الفوائد لكل لغة
            $table->text('benefits_en')->nullable();
            $table->text('benefits_de')->nullable();
            $table->text('benefits_fr')->nullable();
            $table->text('benefits_es')->nullable();
            $table->text('benefits_ar')->nullable();
            
            // معلومات تقنية لكل لغة
            $table->text('technical_info_en')->nullable();
            $table->text('technical_info_de')->nullable();
            $table->text('technical_info_fr')->nullable();
            $table->text('technical_info_es')->nullable();
            $table->text('technical_info_ar')->nullable();
            
            // الحالات السريرية لكل لغة
            $table->text('clinical_cases_en')->nullable();
            $table->text('clinical_cases_de')->nullable();
            $table->text('clinical_cases_fr')->nullable();
            $table->text('clinical_cases_es')->nullable();
            $table->text('clinical_cases_ar')->nullable();
            
            // المقالات المنشورة لكل لغة
            $table->text('publish_articles_en')->nullable();
            $table->text('publish_articles_de')->nullable();
            $table->text('publish_articles_fr')->nullable();
            $table->text('publish_articles_es')->nullable();
            $table->text('publish_articles_ar')->nullable();
            
            // العلاقة مع الـCategory (اختياري)
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            
            // الوقت
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
