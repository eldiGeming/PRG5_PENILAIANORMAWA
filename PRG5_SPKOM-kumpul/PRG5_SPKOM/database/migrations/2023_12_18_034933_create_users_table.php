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
        Schema::create('users', function (Blueprint $table) {
            $table->string('nomor_induk')->primary();
            $table->string('nama_lengkap');
            $table->foreignId('organisasi_id')->nullable()->constrained();
            $table->foreignId('divisi_id')->nullable()->constrained();
            $table->foreignId('jabatan_id')->nullable()->constrained();
            $table->integer('angkatan')->nullable();
            $table->integer('program_studi')->nullable();
            $table->boolean('role'); //type boolean Users: 0=Admin, 1=Pengurus
            $table->string('password');
            $table->boolean('status'); //type boolean Users: 0=Tidak Aktif, 1=Aktif  
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
