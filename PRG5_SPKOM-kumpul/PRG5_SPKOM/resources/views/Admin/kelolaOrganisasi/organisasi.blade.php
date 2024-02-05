@extends('layout/navbar_admin')

@section('content')
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
  <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" >
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<main class="main-wrapper">
    <div class="container">
      <div class="card mt-5">
        <div class="card-header">
          <h3>Data Organisasi</h3>
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
            <a href="javascript:void(0)" onclick="add()" class="btn btn-primary">Tambah Organisasi</a>
        </p>
        <table id="organisasi-table" class="table table-striped table-bordered">
          <thead>
              <tr>
                <th class="col">No</th>
                <th class="col">Nama Organisasi</th>
                <th class="col">Status</th>
                <th class="col">Aksi</th>
              </tr>
          </thead>
      </table>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" id="organisasi-modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Organisasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <style>
    .modal-body {
        width: 100%;
        height: 100%;
    }

    #organisasiForm {
        width: 100%;
        padding: 20px;
    }

    .form-label {
        font-size: 16px;
        margin-bottom: 5px; /* Spasi antara label dan input */
        display: block;
    }

    .form-control {
        width: 100%; /* Agar input memenuhi lebar container */
        font-size: 16px; /* Ganti ukuran font input */
        height: 40px; /* Ganti tinggi input */
        margin-bottom: 10px; /* Spasi antara input */
    }

    .modal-footer {
        margin-top: 20px; /* Spasi antara form dan footer */
    }
</style>

          <div class="modal-body">
              <form action="javascript:void(0)" id="organisasiForm" name="organisasiForm" class="form-horizontal" method="post" enctype="multipart/form-data">
                  <input type="hidden" id="id" name="id">

                  <label for="nama_organisasi" class="form-label">Nama Organisasi<span class="text-danger">*</span></label>
                  <input type="text" id="nama_organisasi" name="nama_organisasi" class="form-control">
                  
                  <!-- Menampilkan pesan validasi -->
                  <span id="validation-messages" class="text-danger"></span>

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
      $(document).ready(function() {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    
        $('#organisasiForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        // Mengosongkan elemen yang menampilkan pesan validasi
    $('#validation-messages').html('');
        $.ajax({
            type: 'POST',
            url: "{{ url('admin/organisasi/store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('#organisasi-modal').modal('hide');
                var oTable = $('#organisasi-table').dataTable();
                oTable.fnDraw(false);
                $('#btn-save').html('Submit');
                $('#btn-save').attr("disabled", false);
            },
            error: function(data) {
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
            }
        });
    });
    
                $('#organisasi-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/admin/organisasi-table') }}",
                columns: [
                    { 
                        data: null,
                        name: 'id',
                        render: function (data, type, row, meta) {
                            // Menghasilkan nomor urut berdasarkan posisi baris
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'nama_organisasi', name: 'nama_organisasi'},
                    { 
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            var badgeClass = (data === 1) ? 'badge bg-success' : 'badge bg-danger';
                            return '<span class="' + badgeClass + '">' + ((data === 1) ? 'AKTIF' : 'TIDAK AKTIF') + '</span>';
                        }
                    },
                    { data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'asc']],
                createdRow: function(row, data, index) {
                    // Menambahkan ID yang sesuai dengan nomor urut
                    $(row).attr('id', 'row_' + (index + 1));
                }
            });
      });
    
      function add() {
        $('#organisasiForm').trigger("reset");
        $('#organisasi-modal').modal('show');
        $('#id').val('');
      }

      function editFunc(id){
        // Mengosongkan elemen yang menampilkan pesan validasi
    $('#validation-messages').html('');
        $.ajax({
          type:"POST",
          url: "{{ url('/admin/organisasi/edit') }}",
          data: {id: id },
          dataType: 'json',
          success: function(res){
            console.log(res);
              $('#organisasiModal').html("Edit Organisasi");
              $('#organisasi-modal').modal('show');
              $('#id').val(res.id);
              $('#nama_organisasi').val(res.nama_organisasi);
            }
        });
      }

      function deleteFunc(id){
          if (confirm("Yakin ingin menghapus Organisasi ini?") == true) {
              var id = id;
              // ajax
              $.ajax({
                  type:"POST",
                  url: "{{ url('/admin/organisasi/delete') }}",
                  data: { id: id },
                  dataType: 'json',
                  success: function(res){
                      var oTable = $('#organisasi-table').dataTable();
                      oTable.fnDraw(false);
                  }
              });
          }
      }
    </script>
    
    
    
  </main>
@endsection