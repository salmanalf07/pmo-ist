<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionDetailInAsanaSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asana_sections', function (Blueprint $table) {
            $table->date('start_on')->nullable()->after('sectionName');
            $table->date('due_on')->nullable()->after('start_on');
            $table->string('progress')->nullable()->after('due_on');
            $table->string('status')->nullable()->after('progress');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asana_sections', function (Blueprint $table) {
            $table->dropColumn(['start_on', 'due_on', 'progress', 'status']);
        });
    }
}
