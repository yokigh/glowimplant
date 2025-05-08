<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('building_number')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('payment_status')->default('pending');
            $table->string('stripe_payment_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};

