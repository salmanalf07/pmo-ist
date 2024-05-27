<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsanaProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asana_projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('gid');
            $table->string('projectId')->nullable();
            $table->string('projectName');
            $table->date('startDate')->nullable();
            $table->date('dueDate')->nullable();
            $table->date('actStartDate')->nullable();
            $table->date('actDueDate')->nullable();
            $table->string('progress')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('asana_projects');
    }
}
