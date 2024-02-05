<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function register(Request $request)
{
    $organisasi = Organisasi::all();

    $selectedOrganisasiId = $request->input('selectedOrganisasiId');
    $selectedDivisiId = $request->input('selectedDivisiId');

    $divisi = Divisi::where('organisasi_id', $selectedOrganisasiId)->get();
    $jabatan = Jabatan::where('divisi_id', $selectedDivisiId)->get();

    return view('auth.register', [
        'organisasi' => $organisasi,
        'divisi' => $divisi,
        'jabatan' => $jabatan,
    ]);
}



public function registerPost(Request $request)
{
    $this->validate($request, [
        'nomor_induk' => [
            'required',
            'numeric',
            'digits:10',
            Rule::unique('users', 'nomor_induk'),
        ],
        'nama_lengkap' => [
            'required',
            'regex:/^[A-Za-z ]+$/',
        ],
        'organisasi_id' => 'required',
        'divisi_id' => 'required',
        'jabatan_id' => 'required',
        'password' => 'required',
        'program_studi' => 'required',
        'angkatan' => 'required'
    ], [
        'nomor_induk.required' => 'Nomor Induk harus diisi.',
        'nomor_induk.numeric' => 'Nomor Induk harus berupa angka.',
        'nomor_induk.digits' => 'Nomor Induk harus terdiri dari 10 digit.',
        'nomor_induk.unique' => 'Nomor Induk sudah digunakan.',
        'nama_lengkap.required' => 'Nama Lengkap harus diisi.',
        'program_studi.required' => 'Program Studi harus diisi.',
        'nama_lengkap.regex' => 'Nama Lengkap hanya boleh mengandung huruf dan spasi.',
        'organisasi_id.required' => 'Organisasi harus dipilih.',
        'divisi_id.required' => 'Divisi harus dipilih.',
        'jabatan_id.required' => 'Jabatan harus dipilih.',
        'password.required' => 'Password harus diisi.',
        'angkatan.required' => 'angkatan harus diisi.',
    ]);

    $user = new User();
    
    $user->nomor_induk = $request->nomor_induk;
    $user->nama_lengkap = $request->nama_lengkap;
    $user->program_studi = $request->program_studi;
    $user->angkatan = $request->angkatan;
    $user->organisasi_id = $request->organisasi_id;
    $user->divisi_id = $request->divisi_id;
    $user->jabatan_id = $request->jabatan_id;
    $user->password = Hash::make($request->password);
    $user->role = 1;
    $user->status = 0;

    $user->save();

    return redirect('/login')->with('success', 'Registrasi Berhasil');
}


    public function login() {
        return view('auth/login');
    }

    public function loginPost(Request $request)
{
    $input = $request->all();

    $this->validate($request, [
        'nomor_induk' => 'required|numeric|digits:10',
        'password' => 'required',
    ], [
        'nomor_induk.required' => 'Nomor Induk harus diisi.',
        'nomor_induk.numeric' => 'Nomor Induk harus berupa angka.',
        'nomor_induk.digits' => 'Nomor Induk harus terdiri dari 10 digit.',
        'password.required' => 'Password harus diisi.',
    ]);    

    $user = User::where('nomor_induk', $input['nomor_induk'])
                ->where('status', '1')
                ->first();

    if ($user && Hash::check($input['password'], $user->password)) {
        auth()->login($user);

        if (auth()->user()->role == 'Admin') {
            return redirect()->route('admin.home');
        } else if (auth()->user()->role == 'Pengurus') {
            return redirect()->route('pengurus.home');
        }
    } else {
        return redirect()->route('login')
            ->with('error', 'Nomor Induk dan Password Salah atau Akun Tidak Aktif.');
    }
}
    
    public function logout()
    {
        Auth::logout();
 
        return redirect('/login');
    }

    public function getDivisi($organisasiId)
    {
        // Ambil data divisi berdasarkan id organisasi yang dipilih
        $divisi = Divisi::where('organisasi_id', $organisasiId)->get();

        // Bangun opsi HTML untuk divisi
        $options = '<option value="">Pilih Divisi</option>';
        foreach ($divisi as $item) {
            $options .= '<option value="' . $item->id . '">' . $item->nama_divisi . '</option>';
        }

        // Kembalikan opsi HTML divisi sebagai respons
        return $options;
    }

    public function getJabatan($divisiId)
    {
        // Ambil data jabatan berdasarkan id divisi yang dipilih
        $jabatan = Jabatan::where('divisi_id', $divisiId)->get();

        // Bangun opsi HTML untuk jabatan
        $options = '<option value="">Pilih Jabatan</option>';
        foreach ($jabatan as $item) {
            $options .= '<option value="' . $item->id . '">' . $item->nama_jabatan . '</option>';
        }

        // Kembalikan opsi HTML jabatan sebagai respons
        return $options;
    }

}