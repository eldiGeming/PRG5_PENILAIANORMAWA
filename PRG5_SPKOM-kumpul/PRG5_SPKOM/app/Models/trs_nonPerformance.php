<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trs_nonPerformance extends Model
{
    use HasFactory;
    protected $table = 'trs_non_performance';

    protected $fillable = [
        'nomor_induk_dinilai',
        'total_kepribadian',
        'total_kepemimpinan',
        'total_kecerdasan_emosi',
        'total_kebahagiaan_kecemasan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nomor_induk_dinilai');
    }
}
