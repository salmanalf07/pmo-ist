<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccesPartnerToPartnerProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_projects', function (Blueprint $table) {
            $table->string('accesPartner')->after('rolePartner')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partner_projects', function (Blueprint $table) {
            $table->dropColumn('accesPartner');
        });
    }
}
