<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsanaDetailTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asana_detail_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('gid');
            $table->integer('ref');
            $table->string('task_id');
            $table->string('assignee')->nullable();
            $table->date('start_on')->nullable();
            $table->date('due_on')->nullable();
            $table->string('permalink_url');
            $table->string('progress')->nullable();
            $table->string('status');
            $table->softDeletes();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asana_detail_tasks');
    }
}
