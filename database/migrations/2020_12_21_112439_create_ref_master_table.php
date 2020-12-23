<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_barang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode')->nullable();
            $table->string('name')->nullable();
            $table->integer('jumlah')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('ref_area', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode')->nullable();
            $table->string('name')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_barang');
        Schema::dropIfExists('ref_area');
    }
}
