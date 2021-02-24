<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransKehadiranAddFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trans_kehadiran', function (Blueprint $table) {
            $table->string('fileurl_in')->nullable();
            $table->string('fileurl_out')->nullable();
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
            $table->dropColumn('fileurl_in');
            $table->dropColumn('fileurl_out');
        });
    }
}
