<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trs_non_performance', function (Blueprint $table) {
            $table->id('id_trs_non_performance');
            $table->string('nomor_induk_dinilai');
            $table->integer('total_kepribadian');
            $table->integer('total_kepemimpinan');
            $table->integer('total_kecerdasan_emosi');
            $table->integer('total_kebahagiaan_kecemasan');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('nomor_induk_dinilai')->references('nomor_induk')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trs_non_performances');
    }
};
