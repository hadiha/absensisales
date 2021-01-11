<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSysUsersAddGender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_users', function (Blueprint $table) {
            $table->string('gender')->after('email')->nullable();
            $table->date('birth_date')->after('gender')->nullable();
            $table->string('birth_place')->after('birth_date')->nullable();
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
            $table->dropColumn('gender');
            $table->dropColumn('birth_date');
            $table->dropColumn('birth_place');
        });
    }
}
