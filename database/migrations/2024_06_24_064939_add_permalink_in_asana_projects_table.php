<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermalinkInAsanaProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asana_projects', function (Blueprint $table) {
            $table->string('permalink_url')->nullable()->after('progress');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asana_projects', function (Blueprint $table) {
            $table->dropColumn('permalink_url');
        });
    }
}
