<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCartIdAndUserIdToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // إضافة عمود cart_id
            $table->text('cart_ids')->nullable(); // cart_ids كمصفوفة من الـ IDs

            // إضافة عمود user_id
            $table->unsignedBigInteger('user_id')->nullable(); // id الخاص بالمستخدم

            // يمكنك إضافة foreign key إذا كان مطلوبًا لربط الـ user_id مع جدول الـ users
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['cart_ids', 'user_id']); // حذف الأعمدة في حال التراجع عن التعديلات
        });
    }
}
