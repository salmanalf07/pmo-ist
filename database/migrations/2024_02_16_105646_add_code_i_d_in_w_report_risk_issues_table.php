<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeIDInWReportRiskIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('w_report_risk_issues', function (Blueprint $table) {
            $table->string('codeId')->nullable()->after('riskIssueId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('w_report_risk_issues', function (Blueprint $table) {
            $table->dropColumn('codeId');
        });
    }
}
