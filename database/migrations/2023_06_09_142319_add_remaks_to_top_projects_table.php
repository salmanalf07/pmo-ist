<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemaksToTopProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('top_projects', function (Blueprint $table) {
            $table->string('bastMain')->after('bastDate')->nullable();
            $table->string('invMain')->after('invDate')->nullable();
            $table->string('payMain')->after('payDate')->nullable();
            $table->string('remaks')->after('payDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('top_projects', function (Blueprint $table) {
            $table->dropColumn('bastMain');
            $table->dropColumn('invMain');
            $table->dropColumn('payMain');
            $table->dropColumn('remaks');
        });
    }
}
