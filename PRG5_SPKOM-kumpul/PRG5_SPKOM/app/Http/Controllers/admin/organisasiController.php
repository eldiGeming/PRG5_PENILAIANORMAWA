<?php

namespace App\Http\Controllers\admin;

use App\Models\organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class organisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $organisasi = Organisasi::select('*');
            
            return datatables()->of($organisasi)
                ->addColumn('action', 'Admin/kelolaOrganisasi/organisasi-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('Admin/kelolaOrganisasi/organisasi');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organisasis = organisasi::all();
        return view('Admin/kelolaOrganisasi/organisasi', compact('organisasis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organisasiId = $request->id;

        $this->validate($request, [
            'nama_organisasi' => 'required|regex:/^[A-Za-z ]+$/|unique:organisasis,nama_organisasi,' . $organisasiId,
        ], [
            'nama_organisasi.required' => 'Nama Organisasi harus diisi.',
            'nama_organisasi.regex' => 'Nama Organisasi hanya boleh berisi huruf dan spasi.',
            'nama_organisasi.unique' => 'Nama Organisasi sudah ada.',
        ]);

        $organisasi = organisasi::updateOrcreate(
            [
                'id' => $organisasiId
            ],
            [
                'nama_organisasi' => $request->nama_organisasi,
                'status' => 1
            ]);

        return response()->json($organisasi);
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
        $organisasi  = organisasi::where($where)->first();
       
        return Response()->json($organisasi);
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
        $divisi = organisasi::where('id', $request->id)->update(['status' => 0]);
    
        return response()->json($divisi);
    }
}
