<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->boolean('status_pay')->default(false); // حالة الدفع
            $table->boolean('status_order')->default(false); // حالة الطلب
            $table->text('notes')->nullable(); // ملاحظات
        });
    }

    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn(['status_pay', 'status_order', 'notes']);
        });
    }
};

