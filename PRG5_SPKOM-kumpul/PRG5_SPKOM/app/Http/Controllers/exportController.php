<?php

namespace App\Http\Controllers;

use App\Exports\trsExport;
use App\Models\trs_performance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class exportController extends Controller
{
    public function exportByNomorInduk($nomor_induk) {
        // Mendapatkan objek trs_performance berdasarkan nomor induk
        $trsPerformance = trs_performance::where('fk_nomor_induk_dinilai', $nomor_induk)->first();
    
        if ($trsPerformance) {
            // Mendapatkan nama lengkap dari model trs_performance
            $namaLengkap = $trsPerformance->dinilai->nama_lengkap;
    
            // Menggabungkan kata "performance" dengan nama lengkap untuk menjadi nama file
            $namaFile = 'performance_' . $namaLengkap . '.xlsx';
    
            return Excel::download(new trsExport('fk_nomor_induk_dinilai', $nomor_induk), $namaFile);
        } else {
            // Handle jika data trs_performance tidak ditemukan
            return abort(404, 'Data trs_performance tidak ditemukan.');
        }
    }    
    
    
    public function exportByOrganisasi($organisasi) {
        return Excel::download(new trsExport('nama_organisasi', $organisasi), 'performance.xlsx');
    }
    
    public function exportByDivisi($divisi) {
        return Excel::download(new trsExport('nama_divisi', $divisi), 'performance.xlsx');
    }
    
}
