<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAsanaSubTask2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asana_sub_task2s', function (Blueprint $table) {
            // Menambahkan foreign key constraint
            $table->foreign('parent_uuid')
                ->references('id')
                ->on('asana_sub_task2s')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('asana_sub_task2s', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign(['parent_uuid']);
        });
    }
}
