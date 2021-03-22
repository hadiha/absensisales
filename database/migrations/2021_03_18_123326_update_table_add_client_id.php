<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableAddClientId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_users', function (Blueprint $table) {
            $table->integer('client_id')->unsigned()->nullable()->after('id');

            $table->foreign('client_id')->references('id')->on('ref_client');
        });

        Schema::table('ref_area', function (Blueprint $table) {
            $table->integer('client_id')->unsigned()->nullable()->after('id');

            $table->foreign('client_id')->references('id')->on('ref_client');
        });

        Schema::table('ref_barang', function (Blueprint $table) {
            $table->integer('client_id')->unsigned()->nullable()->after('id');

            $table->foreign('client_id')->references('id')->on('ref_client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_users', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });

        Schema::table('ref_area', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });

        Schema::table('ref_barang', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
}
