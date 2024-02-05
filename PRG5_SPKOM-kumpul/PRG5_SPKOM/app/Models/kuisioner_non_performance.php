<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class create_quisioner_non_performance extends Model
{
    use HasFactory;
    protected $table = 'kuisioner_non_performance';

    protected $fillable = [
        'kategori',
        'pertanyaan',
        'detail_pertanyaan',
    ];
}
