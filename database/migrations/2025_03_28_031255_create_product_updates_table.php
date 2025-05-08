<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUpdatesTable extends Migration
{
    public function up()
    {
        Schema::create('product_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ربط المستخدم
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // ربط المنتج
            $table->foreignId('country_id')->constrained()->onDelete('cascade'); // ربط الدولة
            $table->decimal('old_price', 10, 2); // السعر القديم
            $table->decimal('new_price', 10, 2); // السعر الجديد
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_updates');
    }
}
