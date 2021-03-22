<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransKehadiranAddFileSakit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trans_kehadiran', function (Blueprint $table) {
            $table->string('fileurl_sakit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trans_kehadiran', function (Blueprint $table) {
            $table->dropColumn('fileurl_sakit');
        });
    }
}
