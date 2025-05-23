<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->date('datebirthday')->nullable();
            $table->string('job')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('zipcode')->nullable();
            $table->enum('role', ['user', 'admin', 'agency'])->default('user');
            $table->timestamps();
        });
    
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
