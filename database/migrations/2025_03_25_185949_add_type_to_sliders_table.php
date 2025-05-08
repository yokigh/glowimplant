<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->enum('type', ['mobile', 'desktop'])->default('desktop')->after('image');
        });
    }

    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
