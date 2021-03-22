<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransDocumentasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_documentasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('area_id')->unsigned();
            $table->dateTime('date');
            $table->string('keterangan');

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('ref_client');
            $table->foreign('area_id')->references('id')->on('ref_area');
        });

        Schema::create('trans_file_documentasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id')->unsigned();
            $table->string('filename');
            $table->string('fileurl');

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('doc_id')->references('id')->on('trans_documentasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_documentasi');    
        Schema::dropIfExists('trans_file_documentasi');    
    }
}
