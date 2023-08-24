<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMandaysAndValueToBonusProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bonus_projects', function (Blueprint $table) {
            $table->string('mandays')->after('pic')->nullable();
            $table->string('valueBonus')->after('mandays')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bonus_projects', function (Blueprint $table) {
            $table->dropColumn('mandays');
            $table->dropColumn('valueBonus');
        });
    }
}
