<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('employee_id');
            $table->string('name');
            $table->string('ktp')->nullable();
            $table->string('npwp')->nullable();
            $table->string('norek')->nullable();
            $table->string('nohp')->nullable();
            $table->string('level');
            $table->string('divisi');
            $table->string('company');
            $table->string('penempatan')->nullable();
            $table->string('direct_manager');
            $table->string('role');
            $table->string('spesialisasi')->nullable();
            $table->date('pkwt_start');
            $table->date('pkwt_end');
            $table->string('email_ist');
            $table->string('email');
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
        Schema::dropIfExists('employees');
    }
}
