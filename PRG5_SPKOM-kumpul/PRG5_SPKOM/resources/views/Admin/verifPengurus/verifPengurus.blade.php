@extends('layout/navbar_admin')

@section('content')
<head>
  <!-- Tambahkan script dan stylesheet DataTables -->
  <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" >
</head>

<main class="main-wrapper">
  <div class="container">
    <div class="card mt-5">
      <div class="card-header">
        <h3>Verifikasi Pengurus</h3>
      </div>
      <table id="organisasi-table" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th class="col">No</th>
            <th class="col">NIM</th>
            <th class="col">Nama Pengurus</th>
            <th class="col">Program Studi</th>
            <th class="col">Organisasi</th>
            <th class="col">Divisi</th>
            <th class="col">Jabatan</th>
            <th class="col">Angkatan</th>
            <th class="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pengurus as $key => $pengurusan)
              <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $pengurusan->nomor_induk }}</td>
                  <td>{{ $pengurusan->nama_lengkap }}</td>
                  <td>{{ $pengurusan->getProgramStudiName() }}</td>
                  <td>{{ $pengurusan->organisasis->nama_organisasi }}</td>
                  <td>{{ $pengurusan->divisis->nama_divisi }}</td>
                  <td>{{ $pengurusan->jabatans->nama_jabatan }}</td>
                  <td>{{ $pengurusan->angkatan }}</td>
                  <td>
                    <a href="{{ route('verifikasi.pengurus', $pengurusan->nomor_induk) }}" class="btn btn-primary">Verifikasi</a>
                  </td>
              </tr>
          @endforeach
      </tbody>      
      </table>
    </div>
  </div>
</main>

<!-- Tambahkan script DataTables -->
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#organisasi-table').DataTable();
  });
</script>
@endsection
