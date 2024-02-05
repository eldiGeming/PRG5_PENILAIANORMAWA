@extends('layout/navbar_pengurus')

@section('content')
<main class="main-wrapper">

    <div class="blue-block text-center">
    <h1 class="blue-background">Kuisioner Non-Performance</h1>
    </div>
     
    <p><br><br><strong>Selamat Mengerjakan, {{ $pengurus->nama_lengkap }}</strong></p>

    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Penilaian -->
    <form action="{{ route('proses_penilaian_nonperformance') }}" method="post">
        @csrf
        <input type="hidden" name="total_keperibadian" id="total_keperibadian" value="0">
        <input type="hidden" name="total_kepemimpinan" id="total_kepemimpinan" value="0">
        <input type="hidden" name="total_kecerdasan_emosi" id="total_kecerdasan_emosi" value="0">
        <input type="hidden" name="total_kebahagiaan_kecemasan" id="total_kebahagiaan_kecemasan" value="0">
        <input type="hidden" name="nomor_induk_dinilai" id="nomor_induk_dinilai" value="{{ $pengurus->nomor_induk }}">
        <div class="kuisioner-section">
            <p><strong>1. Kepribadian</strong></p>
            <table class="kuisioner-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pertanyaan</th>
                        <th>Rating</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($pertanyaan as $item)
                        @if ($item->aspek_penilaian == 'Kepribadian')
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    <strong>{{ $item->pertanyaan }}</strong> <br>
                                    {{ $item->detail_pertanyaan }}
                                </td>
                                <td class="kuisioner-rating">
                                    @for ($i = 1; $i <= 10; $i++)
                                    <input type="radio" name="total_kepribadian" value="{{ $i }}" id="total_kepribadian">
                                    <label for="total_kepribadian" style="margin-right: 20px;">{{ $i }}</label>                                    
                                    @endfor
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br> <br>


            <p><strong>2. Kepemimpinan</strong></p>
            <table class="kuisioner-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pertanyaan</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($pertanyaan as $item)
                        @if ($item->aspek_penilaian == 'Kepemimpinan')
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    <strong>{{ $item->pertanyaan }}</strong> <br>
                                    {{ $item->detail_pertanyaan }}
                                </td>
                                <td class="kuisioner-rating">
                                    @for ($i = 1; $i <= 10; $i++)
                                    <input type="radio" name="total_kepemimpinan" value="{{ $i }}" id="total_kepemimpinan">
                                    <label for="total_kepemimpinan" style="margin-right: 20px;">{{ $i }}</label>                                    
                                    @endfor
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br>
            <br>


            <p><strong>3. Kecerdasan Emosi</strong></p>
            <table class="kuisioner-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pertanyaan</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($pertanyaan as $item)
                        @if ($item->aspek_penilaian == 'Kecerdasan Emosi')
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    <strong>{{ $item->pertanyaan }}</strong> <br>
                                    {{ $item->detail_pertanyaan }}
                                </td>
                                <td class="kuisioner-rating">
                                    @for ($i = 1; $i <= 10; $i++)
                                    <input type="radio" name="total_kecerdasan_emosi" value="{{ $i }}" id="total_kecerdasan_emosi">
                                    <label for="total_kecerdasan_emosi" style="margin-right: 20px;">{{ $i }}</label>                                    
                                    @endfor
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br><br>

            <p><strong>4. Kebahagiaan dan Kecemasan</strong></p>
            <table class="kuisioner-table">
                <thead>
                    <tr>
                        <th>Aspek 1</th>
                        <th>Rating</th>
                        <th>Aspek 2</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>
                                <strong>Kebahagiaan</strong> <br>
                                Suatu keadaan perasaan kesenangan, <br>
                                ketentraman hidup secara lahir dan batin <br>
                                yang maknanya untuk meningkatkan visi diri.
                            </td>                            
                            <td class="kuisioner-rating">
                                @for ($i = 1; $i <= 10; $i++)
                                <input type="radio" name="total_kebahagiaan_kecemasan" value="{{ $i }}" id="total_kebahagiaan_kecemasan">
                                <label for="total_kebahagiaan_kecemasan" style="margin-right: 10px;">{{ $i }}</label>                                    
                                @endfor
                            </td>
                            <td>
                                <strong>Kecemasan</strong> <br>
                                Kekhawatiran dan rasa takut <br>
                                yang intens, berlebihan, dan terus-menerus<br>
                                sehubungan dengan situasi sehari-hari.
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
        <br><br>
        <button class="btn btn-success" type="submit" id="kirimButton" {{ $userHasNonPerformanceData ? 'disabled' : '' }}>Kirim</button>
    </form>
</main>

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
    }
    </style>

<script>
    $(document).ready(function() {
        $('#users-table').DataTable();

        var waktuMinimum = 5; // waktu minimal dalam menit
        var waktuMilidetik = waktuMinimum * 60 * 1000;

        // Mengaktifkan tombol kirim setelah waktu minimal tercapai
        setTimeout(function() {
            $('#kirimButton').prop('disabled', false);
        }, waktuMilidetik);

        // Menambahkan validasi waktu minimal pada pengiriman formulir
        $('#penilaianForm').submit(function(e) {
            var currentTime = new Date();
            var submissionTime = new Date($('#penilaianForm input[name="tanggal"]').val());

            var differenceInMinutes = Math.floor((currentTime - submissionTime) / 60000);

            if (differenceInMinutes < waktuMinimum) {
                alert('Anda hanya dapat menilai setelah 5 menit.');
                e.preventDefault(); // Mencegah pengiriman formulir jika waktu kurang dari 5 menit
            }
        });
    });
</script>
@endsection
