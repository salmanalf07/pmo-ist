<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('noProject');
            $table->string('customerType');
            $table->string('cust_id');
            $table->string('projectName');
            $table->string('noContract');
            $table->date('contractDate');
            $table->string('po')->nullable();
            $table->string('noPo')->nullable();
            $table->date('datePo')->nullable();
            $table->string('projectValue');
            $table->string('projectType');
            $table->string('partnerId');
            $table->string('sales');
            $table->string('pmName');
            $table->string('coPm');
            $table->string('sponsor');
            $table->date('contractStart');
            $table->date('contractEnd');
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
        Schema::dropIfExists('projects');
    }
}
