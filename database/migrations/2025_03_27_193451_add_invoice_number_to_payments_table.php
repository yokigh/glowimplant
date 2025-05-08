<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->string('invoice_number', 6)->unique()->after('id');
    });
}

public function down()
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropColumn('invoice_number');
    });
}

};
