<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('contact_us', function (Blueprint $table) {
            // جعل روابط التواصل الاجتماعي تقبل القيم الفارغة
            $table->string('url_facebook')->nullable()->change();
            $table->string('url_whatsapp')->nullable()->change();
            $table->string('url_instagram')->nullable()->change();
            $table->string('url_tiktok')->nullable()->change();
            $table->string('url_x')->nullable()->change();
            $table->string('url_youtube')->nullable()->change();

            // إضافة أعمدة الوصف باللغات الخمس
            $table->text('description_en')->nullable();
            $table->text('description_de')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_es')->nullable();
            $table->text('description_ar')->nullable();
        });
    }

    public function down() {
        Schema::table('contact_us', function (Blueprint $table) {
            // حذف أعمدة الوصف إذا تم التراجع عن التحديث
            $table->dropColumn(['description_en', 'description_de', 'description_fr', 'description_es', 'description_ar']);
        });
    }
};
