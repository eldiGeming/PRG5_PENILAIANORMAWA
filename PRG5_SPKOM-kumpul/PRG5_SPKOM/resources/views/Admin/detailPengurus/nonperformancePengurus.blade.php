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
        <h3>Data Pengurus Non-Performance </h3>
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
            @foreach($trsPerformanceData as $key => $trsNonperformance)
            
                <!-- Integritas -->
                <tr>
                    <td rowspan="2">{{ $key + 1 }}</td>
                    <td rowspan="2">Kepribadian</td>
                    <td class="{{ $trsNonperformance->total_kepribadian == 0 ? '' : 'total-green' }}" colspan="{{ $trsNonperformance->total_kepribadian }}">{{ $trsNonperformance->total_kepribadian }}</td>
                </tr>
                <tr></tr>
        
                <!-- Handal -->
                <tr>
                    <td rowspan="2">{{ $key + 2 }}</td>
                    <td rowspan="2">Kepemimpinan</td>
                    <td class="{{ $trsNonperformance->total_kepemimpinan == 0 ? '' : 'total-green' }}" colspan="{{ $trsNonperformance->total_kepemimpinan }}">{{ $trsNonperformance->total_kepemimpinan }}</td>
                </tr>
                <tr></tr>
        
                <!-- Tangguh -->
                <tr>
                    <td rowspan="2">{{ $key + 3 }}</td>
                    <td rowspan="2">Kecerdasan Emosi</td>
                    <td class="{{ $trsNonperformance->total_kecerdasan_emosi == 0 ? '' : 'total-green' }}" colspan="{{ $trsNonperformance->total_kecerdasan_emosi }}">{{ $trsNonperformance->total_kecerdasan_emosi }}</td>
                </tr>
                <tr></tr>
        
                <!-- Kolaborasi -->
                <tr>
                    <td rowspan="2">{{ $key + 4 }}</td>
                    <td rowspan="2">Kebahagiaan & Kecemasan</td>
                    <td class="{{ $trsNonperformance->total_kebahagiaan_kecemasan == 0 ? '' : 'total-green' }}" colspan="{{ $trsNonperformance->total_kebahagiaan_kecemasan }}">{{ $trsNonperformance->total_kebahagiaan_kecemasan }}</td>
                </tr>
                <tr></tr>
            @endforeach
        @else
            <tr>
                <td colspan="12">Data Non-Performance tidak ditemukan.</td>
            </tr>
        @endif
    </tbody>
    
      </table>
      <div>
        {{-- <a href="{{ route('exportByNomorInduk', ['nomor_induk' => $trsNonperformance->nomor_induk_dinilai]) }}" class="btn btn-success">Export to Excel</a> --}}
    </div>
    </div>
  </div>
</main>

@endsection
