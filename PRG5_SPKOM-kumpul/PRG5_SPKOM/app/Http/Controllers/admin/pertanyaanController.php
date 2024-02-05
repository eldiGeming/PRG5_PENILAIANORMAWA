<?php

namespace App\Http\Controllers\admin;

use App\Models\pertanyaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class pertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $pertanyaan = pertanyaan::select('*');
            
            return datatables()->of($pertanyaan)
                ->addColumn('action', 'Admin/kelolaPertanyaan/pertanyaan-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('Admin/kelolaPertanyaan/pertanyaan');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pertanyaans = pertanyaan::all();
        return view('Admin/kelolaPertanyaan/pertanyaan', compact('pertanyaans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pertanyaanId = $request->id;
        $pertanyaan = pertanyaan::updateOrcreate(
            [
                'id' => $pertanyaanId
            ],
            [
                'aspek_penilaian' => $request->aspek_penilaian,
                'pertanyaan' => $request->pertanyaan,
                'detail_pertanyaan' => $request->detail_pertanyaan,
                'status' => 1
            ]);

        return Response()->json($pertanyaan);
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
        $pertanyaan  = pertanyaan::where($where)->first();
       
        return Response()->json($pertanyaan);
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
        $pertanyaan = pertanyaan::where('id', $request->id)->update(['status' => 0]);
    
        return response()->json($pertanyaan);
    }
}
