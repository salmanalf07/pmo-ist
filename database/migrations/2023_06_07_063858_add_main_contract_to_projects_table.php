<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMainContractToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('dateStPo')->after('datePo')->nullable();
            $table->string('dateEdPo')->after('dateStPo')->nullable();
            $table->string('poValue')->after('dateEdPo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('dateStPo');
            $table->dropColumn('dateEdPo');
            $table->dropColumn('poValue');
        });
    }
}
