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
          <h3>Data Pertanyaan</h3>
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
            <a href="javascript:void(0)" onclick="add()" class="btn btn-primary">Tambah Pertanyaan</a>
        </p>
        <table id="pertanyaan-table" class="table table-striped table-bordered">
          <thead>
            <tr>
                <th class="col">No</th>
                <th class="col">Aspek Pertanyaan</th>
                <th class="col">Pertanyaan</th>
                <th class="col">Detail Pertanyaan</th>
                <th class="col">Status</th>
                <th class="col">Aksi</th>
            </tr>
        </thead>        
      </table>
        </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" id="pertanyaan-modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Pertanyaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)"  id="pertanyaanForm" name="pertanyaanForm" class="form-horizontal" method="post" enctype="multipart/form-data">
              <input type="hidden" id="id" name="id">
          
              <label class="form-label" for="aspek_pertanyaan">Aspek Penilaian<span class="text-danger">*</span>:</label>
                <select class="form-select" id="aspek_penilaian" name="aspek_penilaian">
                    <option>---Pilih Aspek---</option>
                    <option value="Kepribadian">Kepribadian</option>
                    <option value="Kepemimpinan">Kepemimpinan</option>
                    <option value="Kecerdasan Emosi">Kecerdasan Emosi</option>
                </select>


                <br>
              <label class="form-label" for="nama_organisasi">Pertanyaan<span class="text-danger">*</span></label>
              <input class="form-control" type="text" id="pertanyaan" name="pertanyaan"><br>

              <label class="form-label" for="nama_organisasi">Detail Pertanyaan<span class="text-danger">*</span></label>
              <textarea class="form-control" id="detail_pertanyaan" name="detail_pertanyaan"></textarea><br>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn-save">Save changes</button>
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
    
        $('#pertanyaanForm').submit(function(e) {
          e.preventDefault();
          var formData = new FormData(this);
          $.ajax({
            type: 'POST',
            url: "{{ url('admin/pertanyaan/store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
              console.log(data);
              $('#pertanyaan-modal').modal('hide');
              var oTable = $('#pertanyaan-table').dataTable();
              oTable.fnDraw(false);
              $('#btn-save').html('Submit');
              $('#btn-save').attr("disabled", false);
            },
            error: function(data) {
              console.log(data);
            }
          });
        });
    
        $('#pertanyaan-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ url('/admin/pertanyaan-table') }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'aspek_penilaian', name: 'aspek_penilaian' },
        { data: 'pertanyaan', name: 'pertanyaan' },
        { data: 'detail_pertanyaan', name: 'detail_pertanyaan' },
        { 
            data: 'status',
            name: 'status',
            render: function(data) {
                return (data === 1) ? 'aktif' : 'tidak aktif';
            }
        },
        { data: 'action', name: 'action', orderable: false },
    ],
    order: [[0, 'asc']]
});


      });
    
      function add() {
        $('#pertanyaanForm').trigger("reset");
        $('#pertanyaan-modal').modal('show');
        $('#id').val('');
      }

      function editFunc(id){
        $.ajax({
          type:"POST",
          url: "{{ url('/admin/pertanyaan/edit') }}",
          data: {id: id },
          dataType: 'json',
          success: function(res){
            console.log(res);
              $('#pertanyaanModal').html("Edit Pertanyaan");
              $('#pertanyaan-modal').modal('show');
              $('#id').val(res.id);
              $('#aspek_penilaian').val(res.aspek_penilaian);
              $('#pertanyaan').val(res.pertanyaan);
              $('#detail_pertanyaan').val(res.detail_pertanyaan);
            }
        });
      }

      function deleteFunc(id){
          if (confirm("Yakin ingin menghapus Pertanyaan ini?") == true) {
              var id = id;
              // ajax
              $.ajax({
                  type:"POST",
                  url: "{{ url('/admin/pertanyaan/delete') }}",
                  data: { id: id },
                  dataType: 'json',
                  success: function(res){
                      var oTable = $('#pertanyaan-table').dataTable();
                      oTable.fnDraw(false);
                  }
              });
          }
      }
    </script>
    
    
    
  </main>
@endsection