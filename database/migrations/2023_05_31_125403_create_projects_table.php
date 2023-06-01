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
            $table->string('noContract')->nullable();
            $table->date('contractDate')->nullable();
            $table->string('po')->nullable();
            $table->string('noPo')->nullable();
            $table->date('datePo')->nullable();
            $table->string('projectValue')->nullable();
            $table->string('projectType')->nullable();
            $table->string('partnerId')->nullable();
            $table->string('sales')->nullable();
            $table->string('pmName')->nullable();
            $table->string('coPm')->nullable();
            $table->string('sponsor')->nullable();
            $table->date('contractStart')->nullable();
            $table->date('contractEnd')->nullable();
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
