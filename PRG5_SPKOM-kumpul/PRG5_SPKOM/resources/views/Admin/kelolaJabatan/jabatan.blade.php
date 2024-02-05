@extends('layout/navbar_admin')

@section('content')
<head>
  <!-- Hapus salah satu dari dua pemanggilan jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Gunakan satu versi jQuery -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
  <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" >
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<main class="main-wrapper">
    <div class="container">
      <div class="card mt-5">
        <div class="card-header">
          <h3>Data Jabatan</h3>
        </div>

        @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
        @endif

        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-success">{{ session('error') }}</div>
        @endif
        
        <br>
        <p>
            <a href="javascript:void(0)" onclick="add()" class="btn btn-primary">Tambah Jabatan</a>
        </p>
        <table id="jabatan-table" class="table table-striped table-bordered">
          <thead>
              <tr>
                <th class="col-1">NO</th>
                <th class="col-2">Organisasi</th>
                <th class="col-2">Divisi</th>
                <th class="col-3">Nama Jabatan</th>
                <th class="col-2">Status</th>
                <th class="col-6">Aksi</th>
              </tr>
          </thead>
      </table>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" id="jabatan-modal" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Jabatan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="javascript:void(0)" id="jabatanForm" name="jabatanForm" class="form-horizontal" method="post" enctype="multipart/form-data" novalidate>
                      <input type="hidden" id="id" name="id">
  
                      <label for="organisasi_id">Pilih Organisasi<span class="text-danger">*</span></label>
                      <select id="organisasi_id" class="form-select" id="organisasi_id" name="organisasi_id">
                          <option value="">Pilih Organisasi</option>
                          @foreach($organisasi as $org)
                          <option value="{{ $org->id }}">
                              {{ $org->nama_organisasi }}
                          </option>
                          @endforeach
                      </select>
  
                      <br>
                      <label for="divisi" class="form-label">Divisi<span class="text-danger">*</span></label>
                      <select name="divisi_id" class="form-select" id="divisi_id" required>
                          <option value="">Pilih Divisi</option>
                          <!-- Opsi divisi akan diperbarui menggunakan JavaScript -->
                      </select>
  
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
                                              $('#divisi_id').empty(); // Kosongkan elemen sebelum menambahkan opsi baru
                                              $('#divisi_id').html(data);
                                          },
                                          error: function(xhr, status, error) {
                                              console.error(xhr.responseText); // Tampilkan pesan kesalahan jika terjadi
                                          }
                                      });
                                  } else {
                                      // Kosongkan opsi divisi dan jabatan jika tidak ada organisasi yang dipilih
                                      $('#divisi_id').empty();
                                  }
                              });
                          });
                      </script>
                      <br>
  
                      <label class="form-label" for="nama_jabatan">Nama Jabatan<span class="text-danger">*</span></label>
                      <input type="text" id="nama_jabatan" class="form-control" name="nama_jabatan"><br><br>
  
                      <!-- Elemen untuk menampilkan pesan validasi -->
                      <div id="validation-messages" class="text-danger"></div>
  
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
  

    <!--script modal-->
    <script type="text/javascript">
      $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });

    $('#jabatanForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ url('admin/jabatan/store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                $('#jabatan-modal').modal('hide');
                var oTable = $('#jabatan-table').DataTable();
                oTable.ajax.reload(); // Gunakan metode ajax.reload() untuk merender ulang tabel DataTable
                $('#btn-save').html('Submit');
                $('#btn-save').attr('disabled', false);
            },
            error: function (data) {
                console.log(data);

                // Menampilkan pesan validasi dari server jika ada
                if (data.responseJSON && data.responseJSON.errors) {
                    var errors = data.responseJSON.errors;
                    var errorMessages = '';

                    // Menggabungkan pesan-pesan validasi menjadi satu string
                    for (var key in errors) {
                        errorMessages += errors[key].join('<br>') + '<br>';
                    }

                    // Menampilkan pesan validasi pada elemen tertentu, misalnya pada div dengan id "validation-messages"
                    $('#validation-messages').html(errorMessages);
                }
            },
        });
    });
    
        $('#jabatan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('jabatan.index') }}",
                data: function (d) {
                    d.organisasi_id = $('#organisasi_id').val();
                    d.divisi_id = $('#divisi_id').val();
                }
            },
            columns: [
                { 
                  data: 'DT_RowIndex',
                  name: 'DT_RowIndex',
                  orderable: false,
                  searchable: false,
                },
                { data: 'nama_organisasi', name: 'organisasi.nama_organisasi' },
                { data: 'nama_divisi', name: 'divisi.nama_divisi' },
                { data: 'nama_jabatan', name: 'nama_jabatan' },
                { 
                          data: 'status',
                          name: 'status',
                            render: function(data) {
                            var badgeClass = (data === 1) ? 'badge bg-success' : 'badge bg-danger';
                            return '<span class="' + badgeClass + '">' + ((data === 1) ? 'AKTIF' : 'TIDAK AKTIF') + '</span>';
                            }
                        },
                { data: 'action', name: 'action', orderable: false },
            ],
            order: [[0, 'asc']]
        });
      });
    
      function add() {
        $('#jabatanForm').trigger("reset");
        $('#jabatan-modal').modal('show');
        $('#id').val('');
      }

      function editFunc(id){
        $.ajax({
          type:"POST",
          url: "{{ url('/admin/jabatan/edit') }}",
          data: {id: id },
          dataType: 'json',
          success: function(res){
            console.log(res);
              $('#jabatanModal').html("Edit Jabatan");
              $('#jabatan-modal').modal('show');
              $('#id').val(res.id);
              $('#nama_jabatan').val(res.nama_jabatan);
            }
        });
      }

      function deleteFunc(id){
          if (confirm("Yakin ingin menghapus Jabatan ini?") == true) {
              var id = id;
              // ajax
              $.ajax({
                  type:"POST",
                  url: "{{ url('/admin/jabatan/delete') }}",
                  data: { id: id },
                  dataType: 'json',
                  success: function(res){
                      var oTable = $('#jabatan-table').dataTable();
                      oTable.fnDraw(false);
                  }
              });
          }
      }
    </script>
  </main>
@endsection
