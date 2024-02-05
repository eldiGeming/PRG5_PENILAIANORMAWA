@extends('layout/navbar_pengurus')

@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" >
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<main class="main-wrapper">
    <!-- Judul atau teks di atas tabel -->
    <div class="blue-block text-center">
        <div style="margin-bottom: 20px;">
        <h2 class="blue-background">Kuisioner Performance</h2>
        </div>
    </div>

    <!-- Tabel dengan DataTables -->
    <table id="users-table" class="display">
        <thead>
            <tr>
                <th>Nomor Induk</th>
                <th>Nama Lengkap</th>
                <th>Organisasi</th>
                <th>Divisi</th>
                <th>Aksi</th> <!-- Tambahkan kolom aksi di sini -->
            </tr>
        </thead>
        <tbody>
            @foreach($usersWithSameOrganisasiDivisi as $user)
                <tr>
                    <td>{{ $user->nomor_induk }}</td>
                    <td>{{ $user->nama_lengkap }}</td>
                    <td>{{ $user->organisasis->nama_organisasi }}</td>
                    <td>{{ $user->divisis->nama_divisi }}</td>
                    
                    <td>
                        @php
                            $isButtonDisabled = false;

                            // Check if 'if_nomor_induk_penilai' exists in $transaksi
                            foreach ($tableTransaksi as $transaksi) {
                                if ($transaksi->fk_nomor_induk_dinilai == $user->nomor_induk) {
                                    $isButtonDisabled = true;
                                    break;
                                }
                            }
                        @endphp

                        @if (!$isButtonDisabled)
                            <a href="{{ route('pengurus.quizPerformance.index', ['nomor_induk' => $user->nomor_induk]) }}" class="btn btn-primary">Nilai</a>
                        @else
                            <button class="btn btn-secondary" disabled>Nilai</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main><!-- End #main -->

<style>
        /* Menambahkan garis pada tabel */
        .kuisioner-table {
            border-collapse: collapse;
            width: 100%;
        }

        .kuisioner-table th, .kuisioner-table td {
            border: 2px solid #000000;
            padding: 8px;
            text-align: left;
        }

        .kuisioner-table th {
            background-color: #f2f2f2;
        }
        .blue-background {
        background-color: #3498db;
        color: #fff;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    </style>

<script>
    // Inisialisasi DataTables pada tabel dengan ID 'users-table'
    $(document).ready(function() {
        $('#users-table').DataTable();
    });


</script>
@endsection
