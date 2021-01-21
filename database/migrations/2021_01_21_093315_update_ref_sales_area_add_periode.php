<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRefSalesAreaAddPeriode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ref_sales_area', function (Blueprint $table) {
            $table->date('start_date')->after('area_id')->nullable();
            $table->date('end_date')->after('start_date')->nullable();
            $table->integer('koordinator_id')->after('end_date')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ref_sales_area', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('koordinator_id');
        });
    }
}
