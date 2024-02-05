<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonPeformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'integritas',
        'handal',
        'tangguh',
        'kolaborasi',
        'inovasi',
        'apresiasi',
        'evaluasi',
        'penilai_id',
        'pengurus_id',  
        'Status',   
    ];

    public function pengurus(){
        return $this->belongsTo(Pengurus::class,'pengurus_id');
    }
}
