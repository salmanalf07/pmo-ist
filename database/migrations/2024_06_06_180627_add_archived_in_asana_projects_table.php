<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArchivedInAsanaProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asana_projects', function (Blueprint $table) {
            $table->string('archived')->nullable()->after('gid');
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
            $table->dropColumn('archived');
        });
    }
}
