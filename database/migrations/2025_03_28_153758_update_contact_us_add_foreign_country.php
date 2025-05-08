<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('contact_us', function (Blueprint $table) {
            // حذف العمود القديم إذا كان موجودًا
            $table->dropColumn('country');

            // إضافة عمود country_id وربطه بجدول countries
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    public function down() {
        Schema::table('contact_us', function (Blueprint $table) {
            // التراجع عن التعديلات
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');

            // إعادة العمود القديم بدون الربط
            $table->string('country')->nullable();
        });
    }
};
