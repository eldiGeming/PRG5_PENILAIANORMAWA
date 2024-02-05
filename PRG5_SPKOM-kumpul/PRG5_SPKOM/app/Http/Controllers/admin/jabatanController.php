<?php

namespace App\Http\Controllers\admin;

use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class jabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Jabatan::with(['divisi' => function ($query) {
                    $query->where('status', 1)->with('organisasi')->where('status', 1);
                }])
                ->select('*'))
                ->addColumn('nama_divisi', function ($jabatan) {
                    return $jabatan->divisi->nama_divisi ?? '';
                })
                ->addColumn('nama_organisasi', function ($jabatan) {
                    return $jabatan->divisi->organisasi->nama_organisasi ?? '';
                })
                ->addColumn('action', 'Admin/kelolaJabatan/jabatan-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $organisasi = Organisasi::where('status',1)->get();
        $divisi = Divisi::where('status', 1)->get();
        return view('Admin/kelolaJabatan/jabatan', compact('divisi','organisasi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
             'nama_jabatan' => 'required|unique:jabatans,nama_jabatan,' . $request->id . '|regex:/^[A-Za-z ]+$/',
             'divisi_id' => 'required',
         ], [
             'nama_jabatan.required' => 'Nama Jabatan harus diisi.',
             'nama_jabatan.unique' => 'Nama Jabatan sudah ada.',
             'nama_jabatan.regex' => 'Nama Jabatan hanya boleh huruf dan spasi.',
             'divisi_id.required' => 'Divisi harus dipilih.',
         ]);
     
         $jabatanId = $request->id;
         $jabatan = Jabatan::updateOrCreate(
             [
                 'id' => $jabatanId
             ],
             [
                 'nama_jabatan' => $request->nama_jabatan,
                 'divisi_id' => $request->divisi_id,
                 'status' => 1
             ]);
     
         return response()->json(['status' => 'success', 'message' => 'Data jabatan berhasil disimpan', 'data' => $jabatan]);
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
        $where = array('id' => $request->id);
        $jabatan  = Jabatan::where($where)->first();
       
        return Response()->json($jabatan);
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
        $jabatan = Jabatan::where('id', $request->id)->update(['status' => 0]);
    
        return response()->json($jabatan);
    }
}
