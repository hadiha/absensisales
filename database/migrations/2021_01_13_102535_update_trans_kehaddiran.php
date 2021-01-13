<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransKehaddiran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trans_kehadiran', function (Blueprint $table) {
            $table->dropColumn('koordinat');
            $table->string('latitude')->after('status')->nullable();
            $table->string('longitude')->after('latitude')->nullable();
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
            $table->dropColumn('koordinat');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}
