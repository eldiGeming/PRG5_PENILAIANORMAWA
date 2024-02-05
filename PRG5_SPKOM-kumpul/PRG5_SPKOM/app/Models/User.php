<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'users';
    protected $primaryKey = 'nomor_induk';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nomor_induk',
        'nama_lengkap',
        'organisasi_id',
        'divisi_id',
        'angkatan',
        'role',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'nomor_induk' => 'string',
    ];

    protected function role(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ["Admin", "Pengurus"][$value],
        );
    }

    // Contoh untuk model User
    public function jabatans()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }


    public function divisis(){
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function organisasis(){
        return $this->belongsTo(Organisasi::class, 'organisasi_id');
    }

    public function trsPerformances()
    {
        return $this->hasMany(trs_performance::class, 'fk_nomor_induk_dinilai', 'nomor_induk');
    }

    public function trsNonperformance()
    {
        return $this->hasMany(trs_nonPerformance::class, 'nomor_induk_dinilai', 'nomor_induk');
    }

    public function getAuthIdentifierName()
    {
        return 'nomor_induk';
    }

    public function getProgramStudiName()
    {
        $programStudiMapping = [
            '1' => 'Manajemen Informatika',
            '2' => 'TKBG',
            '3' => 'Mekatronika',
            '4' => 'MO',
            '5' => 'TPM',
            '6' => 'P4',
            '7' => 'TRL'
        ];

        return $programStudiMapping[$this->program_studi] ?? '';
    }

    

}
