<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProgressInAsanaSubTask2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asana_sub_task2s', function (Blueprint $table) {
            $table->string('progress')->nullable()->after('permalink_url');
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
            $table->dropColumn('progress');
        });
    }
}
