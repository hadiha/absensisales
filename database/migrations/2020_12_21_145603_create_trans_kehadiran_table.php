<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransKehadiranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_kehadiran', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pegawai_id')->unsigned();
            $table->dateTime('date_in')->nullable();
            $table->dateTime('date_out')->nullable();
            $table->string('status')->nullable()->comment('hadir, izin, sakit, tk, cuti');

            $table->string('koordinat')->nullable();
            $table->string('keterangan')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('pegawai_id')->references('id')->on('sys_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_moniroting_kehadiran');
    }
}
