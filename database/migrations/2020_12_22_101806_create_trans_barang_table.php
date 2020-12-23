<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_barang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('barang_id')->nullable();
            $table->date('tanggal')->nullable();
            $table->integer('stock');
            $table->integer('sale_in');
            $table->integer('sale_out');

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
        Schema::dropIfExists('trans_barang');
    }
}
