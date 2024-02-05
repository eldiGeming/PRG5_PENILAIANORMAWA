<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;

class dashboardController extends Controller
{
    public function countOrganisasi(){
        $jumlahOrganisasi = Organisasi::count();
    
        return $jumlahOrganisasi;
    }

    public function countDivisi(){
        $jumlahDivisi = Divisi::count();
    
        return $jumlahDivisi;
    }

    public function countJabatan(){
        $jnumlahJabatan = Jabatan::count();
    
        return $jnumlahJabatan;
    }

    public function adminDashboard() {
        $jumlahOrganisasi = $this->countOrganisasi();
        $jumlahDivisi = $this->countDivisi();
        $jumlahJabatan = $this->countJabatan();
        return view('Admin.dashboard' , compact('jumlahOrganisasi', 'jumlahDivisi', 'jumlahJabatan'));
    }


}