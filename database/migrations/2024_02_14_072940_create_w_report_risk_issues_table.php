<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWReportRiskIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_report_risk_issues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('wReportId');
            $table->string('riskIssueId');
            $table->string('type');
            $table->string('responPlan')->nullable();
            $table->string('owner')->nullable();
            $table->string('severity')->nullable();
            $table->string('status')->nullable();
            $table->date('dueDate')->nullable();
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
        Schema::dropIfExists('w_report_risk_issues');
    }
}
