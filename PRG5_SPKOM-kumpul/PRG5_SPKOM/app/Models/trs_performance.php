<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trs_performance extends Model
{
    use HasFactory;

    protected $table = 'trs_performances'; // Sesuaikan dengan nama tabel yang sesuai
    protected $primaryKey = 'id_trs_performance';

    protected $fillable = [
        'fk_nomor_induk_dinilai',
        'tanggal',
        'total_integritas',
        'total_handal',
        'total_tangguh',
        'total_kolaborasi',
        'total_inovasi',
        'fk_nomor_induk_penilai',
        'total_nilai',
    ];

    // Jika Anda perlu menambahkan relasi dengan tabel lain, lakukan di sini
    // Contoh relasi ke tabel 'users' untuk mendapatkan data penilai dan dinilai
    public function penilai()
    {
        return $this->belongsTo(User::class, 'fk_nomor_induk_penilai', 'nomor_induk')->select(['nomor_induk', 'nama_lengkap']);
    }

    public function dinilai()
    {
        return $this->belongsTo(User::class, 'fk_nomor_induk_dinilai', 'nomor_induk')->select(['nomor_induk', 'nama_lengkap']);
    }

}
