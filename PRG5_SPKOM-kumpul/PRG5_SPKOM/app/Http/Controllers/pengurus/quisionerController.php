<?php

namespace App\Http\Controllers\pengurus;

use App\Models\User;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use App\Models\trs_performance;
use App\Models\trs_nonPerformance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class quisionerController extends Controller
{
    public function indexPerformance()
    {
        // Mendapatkan pengguna yang sedang login
        $pengurus = Auth::user();
    
        // Mendapatkan seluruh data pengguna dengan organisasi dan divisi yang sama
        $usersWithSameOrganisasiDivisi = User::where('organisasi_id', $pengurus->organisasi_id)
            ->where('divisi_id', $pengurus->divisi_id)
            ->get();
    
        $tableTransaksi = trs_performance::all();
        return view('pengurus/quiz_performance', compact('usersWithSameOrganisasiDivisi', 'tableTransaksi'));
    }
    

    public function indexNonPerformance()
    {
        $pengurus = Auth::user();
        $pertanyaan = Pertanyaan::all();

        // Tambahkan logika untuk menentukan apakah user memiliki data nonperformance
        $userHasNonPerformanceData = trs_nonPerformance::where('nomor_induk_dinilai', $pengurus->nomor_induk)->exists();

        return view('pengurus/quiz_nonPerformance', compact('pengurus', 'pertanyaan', 'userHasNonPerformanceData'));
    }


    public function pertanyaanQuisioner($nomor_induk) {
        // Retrieve user details based on nomor_induk
        
        $user = User::where('nomor_induk', $nomor_induk)->first();
        
        return view('pengurus/nilai-performance', compact('user'));
    }


    public function prosesPenilaian(Request $request)
    {
        $request->validate([
            'nomor_induk' => 'required', // Sesuaikan dengan nama input yang sesuai
            'penilaian.integritas' => 'required',
            'penilaian.handal' => 'required',
            'penilaian.tangguh' => 'required',
            'penilaian.kolaborasi' => 'required',
            'penilaian.inovasi' => 'required',
        ], [
            'required' => 'Kolom :attribute harus diisi.',
        ]);
        // Check if 'nomor_induk_dinilai' already exists in the 'trs_performance' table
        $existingEvaluation = trs_performance::where('fk_nomor_induk_dinilai', $request->nomor_induk)->first();

        if ($existingEvaluation) {
            // If exists, update the evaluation scores by adding the new scores
            $existingEvaluation->update([
                'total_integritas' => $existingEvaluation->total_integritas + $request->penilaian['integritas'],
                'total_handal' => $existingEvaluation->total_handal + $request->penilaian['handal'],
                'total_tangguh' => $existingEvaluation->total_tangguh + $request->penilaian['tangguh'],
                'total_kolaborasi' => $existingEvaluation->total_kolaborasi + $request->penilaian['kolaborasi'],
                'total_inovasi' => $existingEvaluation->total_inovasi + $request->penilaian['inovasi'],
                'fk_nomor_induk_penilai' => $existingEvaluation->fk_nomor_induk_penilai
                    ? $existingEvaluation->fk_nomor_induk_penilai . ',' . auth()->user()->nomor_induk
                    : auth()->user()->nomor_induk,
            ]);
        } else {
            // If not exists, create a new record in the 'trs_performance' table
            trs_performance::create([
                'fk_nomor_induk_dinilai' => $request->nomor_induk,
                'tanggal' => now(),
                'total_integritas' => $request->penilaian['integritas'],
                'total_handal' => $request->penilaian['handal'],
                'total_tangguh' => $request->penilaian['tangguh'],
                'total_kolaborasi' => $request->penilaian['kolaborasi'],
                'total_inovasi' => $request->penilaian['inovasi'],
                'fk_nomor_induk_penilai' => auth()->user()->nomor_induk,
            ]);
        }
        
        // Redirect to the indexPerformance route
        return redirect()->route('quizPerformance');
    }


    public function prosesPenilaianNonperformance(Request $request) {
        // Validasi input
        $request->validate([
            'total_kepribadian' => 'required|not_in:0',
            'total_kepemimpinan' => 'required|not_in:0',
            'total_kecerdasan_emosi' => 'required|not_in:0',
            'total_kebahagiaan_kecemasan' => 'required|not_in:0',
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'not_in' => 'Kolom :attribute tidak boleh memiliki nilai 0.',
        ]);

        // Mendapatkan informasi pengguna yang sedang login
        $penilai = Auth::user();

        // Cek apakah nomor_induk_dinilai sudah ada di tabel trs_non_performance
        $existingRecord = DB::table('trs_non_performance')
            ->where('nomor_induk_dinilai', $penilai->nomor_induk)
            ->first();

        if ($existingRecord) {
            // Jika sudah ada, tampilkan pesan dan redirect
            return redirect()->back()->with('error', 'Anda sudah melakukan Kuisioner Non-performance');
        }

        // Jika belum ada, simpan data baru
        $data = [
            'nomor_induk_dinilai' => $penilai->nomor_induk,
            'total_kepribadian' => $request->input('total_kepribadian'),
            'total_kepemimpinan' => $request->input('total_kepemimpinan'),
            'total_kecerdasan_emosi' => $request->input('total_kecerdasan_emosi'),
            'total_kebahagiaan_kecemasan' => $request->input('total_kebahagiaan_kecemasan'),
        ];

        // Membuat record baru di tabel trs_nonPerformance
        trs_nonPerformance::create($data);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil melakukan Kuisioner Non-Performance!');
    }

}
