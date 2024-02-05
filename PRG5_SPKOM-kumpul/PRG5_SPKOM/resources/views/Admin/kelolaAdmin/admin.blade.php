@extends('layout/navbar_admin')

@section('content')
<head>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" >
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<main class="main-wrapper">
    <div class="container">
      <div class="card mt-5">
        <div class="card-header">
          <h3>Data Admin</h3>
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
            <a href="javascript:void(0)" onclick="add()" class="btn btn-primary">Tambah Admin</a>
        </p>
        <table id="admin-table" class="table table-striped table-bordered">
          <thead>
              <tr>
                <th class="col">No</th>
                <th class="col">Nomor Induk</th>
                <th class="col">Nama Admin</th>
                <th class="col">Status</th>
                <th class="col">Aksi</th>
              </tr>
          </thead>
      </table>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" id="admin-modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <style>
    .modal-body {
        width: 100%;
        height: 100%;
    }

    #adminForm {
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
              <form action="javascript:void(0)" id="adminForm" name="adminForm" class="form-horizontal" method="post" enctype="multipart/form-data">

                  <label for="nomor_induk" class="form-label">Nomor Induk<span class="text-danger">*</span></label>
                  <input type="text" id="nomor_induk" name="nomor_induk" class="form-control">

                  <label for="nama_lengkap" class="form-label">Nama Admin<span class="text-danger">*</span></label>
                  <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control">

                  <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                  <input type="password" id="password" name="password" class="form-control">

                  <label for="confirmPassword" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                  <input type="password" id="confirmPassword" name="confirmPassword" class="form-control">

                  
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

        $('#adminForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var password = $('#password').val();
        var confirmPassword = $('#confirmPassword').val();

        // Validasi password
        if (password !== confirmPassword) {
        $('#validation-messages').html('Password dan Confirm Password harus sama.');
        return;
        }
    
        $.ajax({
            type: 'POST',
            url: "{{ url('admin/admin/store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('#admin-modal').modal('hide');
                var oTable = $('#admin-table').DataTable();
                oTable.ajax.reload();
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

        var oTable = $('#admin-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/admin/admin-table') }}",
            columns: [
                { 
                    data: null,
                    name: 'nomor_induk',
                    render: function (data, type, row, meta) {
                        // Menghasilkan nomor urut berdasarkan posisi baris
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'nomor_induk', name: 'nomor_induk'},
                { data: 'nama_lengkap', name: 'nama_lengkap'},
                { 
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        return (data === 1) ? 'aktif' : 'tidak aktif';
                    }
                },
                { data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'asc']],
            rowCallback: function(row, data, index) {
                // Menambahkan ID yang sesuai dengan nomor urut
                $('td:eq(0)', row).attr('nomor_induk', 'row_' + (index + 1));
            }
        });

      });
    
      function add() {
        $('#adminForm').trigger("reset");
        $('#admin-modal').modal('show');
        
      }

function editFunc(nomor_induk) {
    // Mengosongkan elemen yang menampilkan pesan validasi
    $('#validation-messages').html('');

    $.ajax({
        type: "POST",
        url: "{{ url('/admin/admin/edit') }}",
        data: { nomor_induk: nomor_induk },
        dataType: 'json',
        success: function (res) {
            console.log(res);
            $('#admin-modal').find('.modal-title').html("Edit Admin");
            $('#admin-modal').modal('show');
            $('#nomor_induk').val(res.nomor_induk);
            $('#nama_lengkap').val(res.nama_lengkap);
        }
    });
}


      function deleteFunc(nomor_induk){
          if (confirm("Yakin ingin menghapus") == true) {
              var nomor_induk = nomor_induk;
              // ajax
              $.ajax({
                  type:"POST",
                  url: "{{ url('/admin/admin/delete') }}",
                  data: { nomor_induk: nomor_induk },
                  dataType: 'json',
                  success: function(res){
                      var oTable = $('#admin-table').DataTable();
                      oTable.ajax.reload();
                  }
              });
          }
        }
    </script>
  </main>
@endsection
