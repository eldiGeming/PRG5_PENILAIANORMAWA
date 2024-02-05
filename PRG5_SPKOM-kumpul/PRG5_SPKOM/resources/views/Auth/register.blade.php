<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<body style="background-image: url('/assets/img/background.jpg'); background-size: cover;">
<div class="row justify-content-center mt-5">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title" style="text-align:center;">Registrasi</h1>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('register') }}" method="POST" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="nomor_induk" class="form-label">Nomor Induk Mahasiswa<span class="text-danger">*</span></label>
                            <input type="text" name="nomor_induk" class="form-control" id="nomor_induk" placeholder="Nomor Induk Mahasiswa" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" placeholder="Nama Lengkap" required>
                        </div>

                        <div class="mb-3">
                        <label class="form-label" for="aspek_pertanyaan">Program Studi<span class="text-danger">*</span></label>
                            <select class="form-select" id="program_studi" name="program_studi">
                                <option>---Pilih Program Studi---</option>
                                <option value="1">Manajemen Informatika</option>
                                <option value="2">Teknik Konstruksi Bangunan dan Gedung</option>
                                <option value="3">Mekatronika</option>
                                <option value="4">Tekni Mesin Otomotif</option>
                                <option value="4">Teknik Alat Berat</option>
                                <option value="5">Teknik Produksi & Manufaktur</option>
                                <option value="6">P4 </option>
                                <option value="7">Teknik Rekayasa Logistik</option>
                            </select>
                        </div>
                        
                        <!-- Organisasi -->
                        <div class="mb-3">
                            <label for="organisasi" class="form-label">Organisasi<span class="text-danger">*</span></label>
                            <select name="organisasi_id" class="form-select" id="organisasi_id" required>
                                <option value="">Pilih Organisasi</option>
                                @foreach($organisasi as $org)
                                    <option value="{{ $org->id }}">{{ $org->nama_organisasi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Divisi -->
                        <div class="mb-3">
                            <label for="divisi" class="form-label">Divisi<span class="text-danger">*</span></label>
                            <select name="divisi_id" class="form-select" id="divisi_id" required>
                                <option value="">Pilih Divisi</option>
                                <!-- Opsi divisi akan diperbarui menggunakan JavaScript -->
                            </select>
                        </div>

                        <!-- Jabatan -->
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan<span class="text-danger">*</span></label>
                            <select name="jabatan_id" class="form-select" id="jabatan_id" required>
                                <option value="">Pilih Jabatan</option>
                                <!-- Opsi jabatan akan diperbarui menggunakan JavaScript -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="angkatan" class="form-label">Angkatan<span class="text-danger">*</span></label>
                            <input type="number" name="angkatan" class="form-control" id="angkatan" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <div class="d-grid">
                                <button class="btn btn-primary">Register</button>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a href="{{ route('login') }}"><p class="small mb-0">Klik untuk kembali ke Halaman Login</p></a>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
    // Ketika organisasi dipilih, perbarui opsi divisi
    $('#organisasi_id').on('change', function() {
        let organisasiId = $(this).val(); // Mendapatkan nilai id organisasi yang dipilih
        console.log("Nilai organisasiId:", organisasiId); // Menampilkan nilai organisasiId di konsol

        if (organisasiId) {
            // Lakukan permintaan AJAX untuk mendapatkan divisi yang terkait dengan organisasi yang dipilih
            $.ajax({
                type: 'GET',
                url: '/get-divisi/' + organisasiId, // Ganti URL sesuai kebutuhan Anda
                success: function(data) {
                    // Memperbarui opsi divisi dalam elemen select dengan id "divisi"
                    $('#divisi_id').html(data);
                    $('#jabatan_id').empty(); // Kosongkan opsi jabatan ketika pilihan organisasi berubah
                }
            });
        } else {
            // Kosongkan opsi divisi dan jabatan jika tidak ada organisasi yang dipilih
            $('#divisi_id').empty();
            $('#jabatan_id').empty();
        }
    });

    // Ketika divisi dipilih, perbarui opsi jabatan
    $('#divisi_id').on('change', function() {
        let divisiId = $(this).val(); // Mendapatkan nilai id divisi yang dipilih
        if (divisiId) {
            // Lakukan permintaan AJAX untuk mendapatkan jabatan yang terkait dengan divisi yang dipilih
            $.ajax({
                type: 'GET',
                url: '/get-jabatan/' + divisiId, // Ganti URL sesuai kebutuhan Anda
                success: function(data) {
                    // Memperbarui opsi jabatan dalam elemen select dengan id "jabatan"
                    $('#jabatan_id').html(data);
                }
            });
        } else {
            // Kosongkan opsi jabatan jika tidak ada divisi yang dipilih
            $('#jabatanid').empty();
        }
    });
});


    </script>
</body>
</html>