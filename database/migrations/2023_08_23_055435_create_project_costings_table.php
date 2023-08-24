<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCostingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_costings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('projectId');
            $table->string('description')->nullable();
            $table->date('orderDate')->nullable();
            $table->string('poNumber')->nullable();
            $table->string('amount')->nullable();
            $table->string('pic')->nullable();
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
        Schema::dropIfExists('project_costings');
    }
}
