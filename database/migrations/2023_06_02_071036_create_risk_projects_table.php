<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('projectId');
            $table->string('riskDesc')->nullable();
            $table->string('trigerEvent')->nullable();
            $table->string('riskResponse')->nullable();
            $table->string('contiPlan')->nullable();
            $table->string('owner')->nullable();
            $table->string('statRisk')->nullable();
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
        Schema::dropIfExists('risk_projects');
    }
}
