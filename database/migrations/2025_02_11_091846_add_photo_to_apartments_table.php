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
        Schema::table('apartments', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('rented');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
};
