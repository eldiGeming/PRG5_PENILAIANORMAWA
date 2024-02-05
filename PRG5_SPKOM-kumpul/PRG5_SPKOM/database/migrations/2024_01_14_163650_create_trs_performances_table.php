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
    Schema::create('trs_performances', function (Blueprint $table) {
        $table->id('id_trs_performance');
        $table->string('fk_nomor_induk_dinilai');
        $table->foreign('fk_nomor_induk_dinilai')->references('nomor_induk')->on('users');
        $table->date('tanggal');
        $table->integer('total_integritas');
        $table->integer('total_handal');
        $table->integer('total_tangguh');
        $table->integer('total_kolaborasi');
        $table->integer('total_inovasi');
        $table->string('fk_nomor_induk_penilai');
        $table->foreign('fk_nomor_induk_penilai')->references('nomor_induk')->on('users');
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
        Schema::dropIfExists('trs_performances');
    }
};
