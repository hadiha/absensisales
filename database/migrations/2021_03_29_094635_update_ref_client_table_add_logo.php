<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRefClientTableAddLogo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ref_client', function (Blueprint $table) {
            $table->string('filename')->after('name')->nullable();
            $table->string('fileurl')->after('filename')->nullable();
            $table->string('color')->after('fileurl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ref_client', function (Blueprint $table) {
            $table->dropColumn('filename');
            $table->dropColumn('fileurl');
            $table->dropColumn('color');
        });
    }
}
