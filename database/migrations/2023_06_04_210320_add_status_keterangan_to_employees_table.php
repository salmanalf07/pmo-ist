<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusKeteranganToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('level')->nullable()->change();
            $table->string('divisi')->nullable()->change();
            $table->string('company')->nullable()->change();
            $table->string('direct_manager')->nullable()->change();
            $table->string('role')->nullable()->change();
            $table->date('pkwt_start')->nullable()->change();
            $table->date('pkwt_end')->nullable()->change();
            $table->string('email_ist')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('status')->after('email')->nullable();
            $table->string('keterangan')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('level')->unsigned()->change();
            $table->string('divisi')->unsigned()->change();
            $table->string('company')->unsigned()->change();
            $table->string('direct_manager')->unsigned()->change();
            $table->string('role')->unsigned()->change();
            $table->date('pkwt_start')->unsigned()->change();
            $table->date('pkwt_end')->unsigned()->change();
            $table->string('email_ist')->unsigned()->change();
            $table->string('email')->unsigned()->change();
            $table->dropColumn('status');
            $table->dropColumn('keterangan');
        });
    }
}
