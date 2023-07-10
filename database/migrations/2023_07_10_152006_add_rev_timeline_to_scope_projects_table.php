<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRevTimelineToScopeProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scope_projects', function (Blueprint $table) {
            $table->date('actStart')->default('1990-01-01')->after('planEnd')->nullable();
            $table->date('actEnd')->default('1990-01-01')->after('actStart')->nullable();
            $table->string('remaks')->after('progProject')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scope_projects', function (Blueprint $table) {
            $table->dropColumn('actStart');
            $table->dropColumn('actEnd');
            $table->dropColumn('remaks');
        });
    }
}
