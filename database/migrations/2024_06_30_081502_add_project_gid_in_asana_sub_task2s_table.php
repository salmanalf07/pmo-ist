<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectGidInAsanaSubTask2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asana_sub_task2s', function (Blueprint $table) {
            $table->string('project_gid')->nullable()->after('parent_uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asana_sub_task2s', function (Blueprint $table) {
            $table->dropColumn('project_gid');
        });
    }
}
