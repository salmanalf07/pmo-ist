<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues_projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('projectId');
            $table->string('issuesDesc')->nullable();
            $table->string('projectImpact')->nullable();
            $table->string('actionPlan')->nullable();
            $table->string('owner')->nullable();
            $table->date('resolvedDate')->nullable();
            $table->string('statIssues')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('issues_projects');
    }
}
