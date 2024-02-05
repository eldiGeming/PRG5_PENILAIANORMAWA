@extends('layout/navbar_pengurus')

@section('content')
    <main class="main-wrapper">
        <div class="container mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-center">Form Penilaian</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('proses_penilaian') }}" method="post">
                        @csrf
                        <table id="users-table" class="display table">
                            <thead>
                                <tr>
                                    <th>Aspek Penilaian</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $aspects = ['Integritas', 'Handal', 'Tangguh', 'Kolaborasi', 'Inovasi'];
                                @endphp
                                @foreach($aspects as $index => $aspect)
                                    <tr>
                                        <input type="hidden" name="nomor_induk" id="nomor_induk" value="{{ $user->nomor_induk }}">
                                        <td>{{ $aspect }}</td>
                                        <td id="rating-{{ $index }}">
                                            @for ($i = 0; $i <= 10; $i++)
                                                <input type="radio" name="penilaian[{{ strtolower($aspect) }}]" value="{{ $i }}" id="{{ strtolower($aspect) }}_{{ $i }}" {{ $index == 0 && $loop->first ? '' : 'disabled' }}>
                                                <span class="rating-label">{{ $i }}</span>
                                            @endfor
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Tombol Kirim -->
                        <button type="submit" class="btn btn-success">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Tambahkan script DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" >
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <style>
        .rating-label {
            margin-right: 10px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .rating-label:hover {
            color: #ffcc00; /* Warna kuning saat dihover */
        }

        .card {
            margin-top: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 15px 15px 0 0;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
    <script>
        // Inisialisasi DataTables pada tabel dengan ID 'users-table'
        $(document).ready(function() {
            // ... (Your existing DataTables initialization)
        });
    </script>
@endsection
