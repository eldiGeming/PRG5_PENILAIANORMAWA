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
        <h3>Data Divisi</h3>
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
          <a href="javascript:void(0)" onclick="add()" class="btn btn-primary">Tambah Divisi</a>
      </p>
      <table id="divisi-table" class="table table-striped table-bordered">
        <thead>
            <tr>
              <th class="col">NO</th>
              <th class="col">Organisasi</th>
              <th class="col">Nama Divisi</th>
              <th class="col">Status</th>
              <th class="col">Aksi</th>
            </tr>
        </thead>
    </table>
      </div>
    </div>
  </div>

    <div class="modal" tabindex="-1" id="divisi-modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Divisi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)"  id="divisiForm" name="divisiForm" class="form-horizontal" method="post" enctype="multipart/form-data">
              <input type="hidden" id="id" name="id">
              <tr>
                <td>
                    <label class="form-label" for="nama_divisi">Pilih Organisasi<span class="text-danger">*</span></label>
                </td>
                <td>
                    <select id="organisasi_id" name="organisasi_id" class="form-select">
                        <option value="">Pilih Organisasi</option>
                        @foreach($organisasi as $org)
                            <option value="{{ $org->id }}">{{ $org->nama_organisasi }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            
              <br>
              <br>
              <tr>
                <label class="form-label" for="nama_divisi">Nama Divisi<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="nama_divisi" name="nama_divisi"><br><br>
              </tr>
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
      $(document).ready(function() {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    
        $('#divisiForm').submit(function(e) {
          e.preventDefault();
          var formData = new FormData(this);
          $('#validation-messages').html('');
          $.ajax({
              type: 'POST',
              url: "{{ url('admin/divisi/store') }}",
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function(data) {
                  console.log(data);
                  $('#divisi-modal').modal('hide');
                  var oTable = $('#divisi-table').dataTable();
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

    
          $('#divisi-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ url('/admin/divisi-table') }}",
              columns: [
                  { 
                      data: 'DT_RowIndex',
                      name: 'DT_RowIndex',
                      orderable: false,
                      searchable: false,
                  },
                  { 
                      data: 'organisasi.nama_organisasi',
                      name: 'organisasi.nama_organisasi',
                      render: function(data, type, full, meta) {
                          return data; // Menampilkan nama organisasi
                      }
                  },
                  { data: 'nama_divisi', name: 'nama_divisi' },
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
        $('#validation-messages').html('');
        $('#divisiForm').trigger("reset");
        $('#divisi-modal').modal('show');
        $('#id').val('');
      }

              function editFunc(id) {
            $('#validation-messages').html('');
            $.ajax({
                type: "POST",
                url: "{{ url('/admin/divisi/edit') }}",
                data: { id: id },
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    $('#divisiModal').html("Edit Divisi");
                    $('#divisi-modal').modal('show');
                    $('#id').val(res.id);
                    $('#nama_divisi').val(res.nama_divisi);

                    // Panggil setOrganisasiValue setelah modal dibuka
                    $('#divisi-modal').on('shown.bs.modal', function () {
                        setOrganisasiValue();
                    });
                }
            });
        }



      function deleteFunc(id){
          if (confirm("Yakin ingin ubah status Divisi ini?") == true) {
              var id = id;
              // ajax
              $.ajax({
                  type:"POST",
                  url: "{{ url('/admin/divisi/delete') }}",
                  data: { id: id },
                  dataType: 'json',
                  success: function(res){
                      var oTable = $('#divisi-table').dataTable();
                      oTable.fnDraw(false);
                  }
              });
          }
      }
    </script>
  
  </main>
@endsection