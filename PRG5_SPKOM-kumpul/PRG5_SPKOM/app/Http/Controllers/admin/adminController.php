<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\trs_performance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $users = User::select('*')->where('role', 0);
            return datatables()->of($users)
            ->addColumn('action', 'Admin/kelolaAdmin/admin-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('Admin/kelolaAdmin/admin');
    }

    public function profile()
    {
        return view('profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin = User::all();
        return view('Admin/kelolaAdmin/admin', compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Menambahkan aturan validasi
        $this->validate($request, [
            'nomor_induk' => 'required|numeric|digits:10|unique:users,nomor_induk',
            'nama_lengkap' => 'required|regex:/^[A-Za-z\s]+$/',
            'password' => 'required|min:8',
        ], [
            'nomor_induk.numeric' => 'Nomor induk harus angka',
            'nomor_induk.digits' => 'Nomor induk harus 10 digit',
            'nomor_induk.required' => 'Nomor Induk harus diisi.',
            'nomor_induk.unique' => 'Nomor Induk sudah digunakan.',
            'nama_lengkap.required' => 'Nama Lengkap harus diisi.',
            'nama_lengkap.regex' => 'Nama Lengkap hanya boleh huruf dan spasi.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
        ]);

        $admin = User::updateOrCreate(
            [
                'nomor_induk' => $request->nomor_induk,
            ],
            [
                'nama_lengkap' => $request->nama_lengkap,
                'password' => Hash::make($request->password),
                'status' => 1,
                'role' => 0
            ]
        );

        return response()->json([$admin]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $nomor_induk = $request->nomor_induk;
        $admin = User::find($nomor_induk);

        return response()->json($admin);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $admin = User::where('nomor_induk', $request->nomor_induk)->update(['status' => 0]);
    
        return response()->json($admin);
    }

        public function verifPengurus()
        {
            if(request()->ajax()) {
                $users = User::with(['organisasi:id,nama_organisasi', 'divisi:id,nama_divisi', 'jabatan:id,nama_jabatan'])
                    ->where('status', 0)
                    ->where('role', 1)
                    ->get();

                return datatables()->of($users)
                    ->addColumn('nama_organisasi', function($row) {
                        return $row->organisasi ? $row->organisasi->nama_organisasi : '-';
                    })
                    ->addColumn('nama_divisi', function($row) {
                        return $row->divisi ? $row->divisi->nama_divisi : '-';
                    })
                    ->addColumn('nama_jabatan', function($row) {
                        return $row->jabatan ? $row->jabatan->nama_jabatan : '-';
                    })
                    ->addColumn('status', function($row) {
                        return ($row->status === 1) ? 'Aktif' : 'Tidak Aktif';
                    })
                    ->addColumn('action', 'Admin.verifPengurus-action')
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }

            $pengurus = User::with(['organisasis:id,nama_organisasi', 'divisis:id,nama_divisi', 'jabatans:id,nama_jabatan'])
                ->where('status', 0)
                ->where('role', 1)
                ->get();

            return view('Admin.verifPengurus.verifPengurus', compact('pengurus'));
        }

        public function dataPengurus()
        {
            $pengurus = User::where('role', '1')
                            ->where('status', '1')
                            ->get();

            return view('Admin/detailPengurus/detail-pengurus', compact('pengurus'));
        }


        public function acc($nomor_induk)
        {
            $pengurus = User::where('nomor_induk', $nomor_induk)->firstOrFail();
            if ($pengurus->status == 0) {
                $pengurus->status = 1;
                $pengurus->save();
            
                //dapat menambahkan pesan sukses atau flash message di sini
                return redirect()->back()->with('success', 'Pengurus berhasil diverifikasi.');
            }
            
            // Jika status sudah 1, mungkin hendak menampilkan pesan bahwa sudah diverifikasi
            return redirect()->back()->with('info', 'Pengurus sudah diverifikasi sebelumnya.');
        }
            

        public function performancePengurus($nomor_induk) {
            // Retrieve the user with the given nomor_induk
            $pengurus = User::where('nomor_induk', $nomor_induk)
                            ->where('role', '1')
                            ->where('status', '1')
                            ->first();
        
            if ($pengurus) {
                $trsPerformanceData = $pengurus->trsPerformances;
                return view('Admin/detailPengurus/performancePengurus', compact('pengurus', 'trsPerformanceData'));
            } else {
                
                return abort(404, 'User not found for nomor_induk: ' . $nomor_induk);
            }
        }

        public function nonperformancePengurus($nomor_induk) {
            $pengurus = User::where('nomor_induk', $nomor_induk)
                            ->where('role', '1')
                            ->where('status', '1')
                            ->first();
            if ($pengurus) {
                $trsPerformanceData = $pengurus->trsNonperformance;
                return view('Admin/detailPengurus/nonperformancePengurus', compact('pengurus', 'trsPerformanceData'));
            } else {
                return abort(404, 'User not found for nomor_induk: ' . $nomor_induk);
            }
        }
    }