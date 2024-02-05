@extends('layout/navbar_admin')

@section('content')
<head>
  <!-- Tambahkan script dan stylesheet DataTables -->
  
  <style>
    #trs-performance-table th.col {
        text-align: center;
        vertical-align: middle;
    }

    th.col {
        text-align: center;
        vertical-align: middle;
    }

    td.total-green {
        background-color: rgb(118, 253, 129);
    }

    /* Menyesuaikan lebar kolom */
    th.col, td {
        min-width: 30px; /* Sesuaikan dengan lebar yang diinginkan */
    }
</style>
</head>

<main class="main-wrapper">
  <div class="container">
    <div class="card mt-5">
      <div class="card-header">
        <h3>Data Pengurus Performances </h3>
      </div>
      <table>
        <td>
          <p>Nomor induk: {{ $pengurus->nomor_induk }}</p>
          <p>Nama Lengkap: {{ $pengurus->nama_lengkap }}</p>
          <p>Program Studi: {{ $pengurus->getProgramStudiName() }}</p>
        </td>
        <td>
          <p>Organisasi: {{ $pengurus->organisasis->nama_organisasi }}</p>
          <p>Divisi: {{ $pengurus->divisis->nama_divisi }}</p>
          <p>Jabatan: {{ $pengurus->jabatans->nama_jabatan }}</p>
        </td>
      </table>

      <table id="trs-performance-table" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th class="col" rowspan="2">No</th>
              <th class="col" rowspan="2">Aspek</th>
              <th class="col" colspan="2">Sangat Rendah</th>
              <th class="col" colspan="2">Rendah</th>
              <th class="col" colspan="2">Sedang</th>
              <th class="col" colspan="2">Tinggi</th>
              <th class="col" colspan="2">Sangat Tinggi</th>
          </tr>
          <tr>
              <th class="col">1</th>
              <th class="col">2</th>
              <th class="col">3</th>
              <th class="col">4</th>
              <th class="col">5</th>
              <th class="col">6</th>
              <th class="col">7</th>
              <th class="col">8</th>
              <th class="col">9</th>
              <th class="col">10</th>
          </tr>
      </thead>
      <tbody>
        @if(isset($trsPerformanceData) && $trsPerformanceData !== null)
            @foreach($trsPerformanceData as $key => $trsPerformance)
                <!-- Integritas -->
                <tr>
                    <td rowspan="2">{{ $key + 1 }}</td>
                    <td rowspan="2">Integritas</td>
                    <td class="{{ $trsPerformance->total_integritas == 0 ? '' : 'total-green' }}" colspan="{{ $trsPerformance->total_integritas }}">{{ $trsPerformance->total_integritas }}</td>
                </tr>
                <tr></tr>
        
                <!-- Handal -->
                <tr>
                    <td rowspan="2">{{ $key + 2 }}</td>
                    <td rowspan="2">Handal</td>
                    <td class="{{ $trsPerformance->total_handal == 0 ? '' : 'total-green' }}" colspan="{{ $trsPerformance->total_handal }}">{{ $trsPerformance->total_handal }}</td>
                </tr>
                <tr></tr>
        
                <!-- Tangguh -->
                <tr>
                    <td rowspan="2">{{ $key + 3 }}</td>
                    <td rowspan="2">Tangguh</td>
                    <td class="{{ $trsPerformance->total_tangguh == 0 ? '' : 'total-green' }}" colspan="{{ $trsPerformance->total_tangguh }}">{{ $trsPerformance->total_tangguh }}</td>
                </tr>
                <tr></tr>
        
                <!-- Kolaborasi -->
                <tr>
                    <td rowspan="2">{{ $key + 4 }}</td>
                    <td rowspan="2">Kolaborasi</td>
                    <td class="{{ $trsPerformance->total_kolaborasi == 0 ? '' : 'total-green' }}" colspan="{{ $trsPerformance->total_kolaborasi }}">{{ $trsPerformance->total_kolaborasi }}</td>
                </tr>
                <tr></tr>
        
                <!-- Inovasi -->
                <tr>
                    <td rowspan="2">{{ $key + 5 }}</td>
                    <td rowspan="2">Inovasi</td>
                    <td class="{{ $trsPerformance->total_inovasi == 0 ? '' : 'total-green' }}" colspan="{{ $trsPerformance->total_inovasi }}">{{ $trsPerformance->total_inovasi }}</td>
                </tr>
                <tr></tr>
            @endforeach
        @else
            <tr>
                <td colspan="12">Data trs_performance tidak ditemukan.</td>
            </tr>
        @endif
    </tbody>
    
      </table>
      <div>
        <a href="{{ route('exportByNomorInduk', ['nomor_induk' => $trsPerformance->fk_nomor_induk_dinilai]) }}" class="btn btn-success">Export to Excel</a>
    </div>
    </div>
  </div>
</main>

@endsection
