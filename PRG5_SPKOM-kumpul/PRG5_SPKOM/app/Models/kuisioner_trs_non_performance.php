<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kuisioner_trs_non_performance extends Model
{
    use HasFactory;
    protected $table = 'kuisioner_trs_non_performance';

    protected $fillable = [
        'id_non_performance',
        'id_trs_non_performance',
        'kepribadian',
        'kepemimpinan',
        'kecerdasan_emosi',
        'kebahagiaan',
        'kecemasan',
    ];

    public function kuisionerNon()
    {
        return $this->belongsTo(kuisioner_trs_non_performance::class, 'id_non_performance');
    }

    public function trsNonPerformance()
    {
        return $this->belongsTo(trs_nonPerformance::class, 'id_trs_non_performance');
    }
}
