<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('prosthetic_products', function (Blueprint $table) {
            $table->string('ref')->nullable()->change();
            $table->string('diameter')->nullable()->change();
            $table->integer('height')->nullable()->change();
            $table->string('ml')->nullable()->change();
            $table->double('angle')->nullable()->change();
            $table->string('screw_ref')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('prosthetic_products', function (Blueprint $table) {
            $table->string('ref')->nullable(false)->change();
            $table->string('diameter')->nullable(false)->change();
            $table->integer('height')->nullable(false)->change();
            $table->string('ml')->nullable(false)->change();
            $table->double('angle')->nullable(false)->change();
            $table->string('screw_ref')->nullable(false)->change();
        });
    }
};
