<?php

namespace App\Http\Controllers\admin;

use App\Models\Divisi;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class divisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $divisi = Divisi::with('organisasi:id,nama_organisasi')
                            ->whereHas('organisasi', function ($query) {
                                $query->where('status', 1);
                            })
                            ->select('*');
            
            return datatables()->of($divisi)
                ->addColumn('nama_organisasi', function ($row) {
                    return $row->organisasi->nama_organisasi ?? '';
                })
                ->addColumn('action', 'Admin.kelolaDivisi.divisi-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        } else {
            $organisasi = Organisasi::where('status', 1)->get();
            return view('Admin.kelolaDivisi.divisi', compact('organisasi'));
        }        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisis = Divisi::all();
        return view('Admin/kelolaDivisi/divisi', compact('divisis'));
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
            'nama_divisi' => 'required|unique:divisis,nama_divisi,' . $request->id . '|regex:/^[A-Za-z ]+$/',
            'organisasi_id' => 'required',
        ], [
            'nama_divisi.required' => 'Nama Divisi harus diisi.',
            'nama_divisi.unique' => 'Nama Divisi sudah ada.',
            'nama_divisi.regex' => 'Nama Divisi hanya boleh huruf dan spasi.',
            'organisasi_id.required' => 'Organisasi harus dipilih.',
        ]);

        $divisiiId = $request->id;
        $divisi = Divisi::updateOrCreate(
            [
                'id' => $divisiiId
            ],
            [
                'nama_divisi' => $request->nama_divisi,
                'organisasi_id' => $request->organisasi_id,
                'status' => 1
            ]);

        return response()->json($divisi);
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
        $divisi  = Divisi::where($where)->first();
       
        return Response()->json($divisi);
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
        $divisi = Divisi::where('id', $request->id)->update(['status' => 0]);
    
        return response()->json($divisi);
    }
}
