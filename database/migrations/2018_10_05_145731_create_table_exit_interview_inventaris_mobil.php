<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExitInterviewInventarisMobil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_interview_inventaris_mobil', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_inventaris_mobil_id')->nullable();
            $table->integer('exit_interview_id')->nullable();
            $table->smallInteger('check_by_hr')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('exit_interview_inventaris_mobil');
    }
}
