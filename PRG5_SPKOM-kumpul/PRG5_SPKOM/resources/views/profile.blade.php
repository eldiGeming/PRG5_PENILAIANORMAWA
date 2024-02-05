@extends('layout/navbar_admin')

@section('content')
<head>
    <link href= "{{ asset ('img/favicon.png') }}" rel="icon">
    <link href= "{{ asset ('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href= "{{ asset ('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href= "{{ asset ('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href= "{{ asset ('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href= "{{ asset ('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href= "{{ asset ('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href= "{{ asset ('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href= "{{ asset ('vendor/simple-datatables/style.css') }}" rel="stylesheet">
</head>

<body>

  <main id="main" class="main">
    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              {{-- <img src= "{{ asset ('img/profile-img.jpg') }}" alt="Profile" class="rounded-circle"> --}}
              <h2>{{ Auth::user()->nama_lengkap }}</h2>
              <h3>{{ Auth::user()->role }}</h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form>
                    {{-- <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src= "{{ asset ('img/profile-img.jpg') }}" alt="Profile">
                        <div class="pt-2">
                          <a href= "{{ asset ('#') }}" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href= "{{ asset ('#') }}" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div> --}}

                    <div class="row mb-3">
                        <label for="nomor_induk" class="col-md-4 col-lg-3 col-form-label">Nomor Induk</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="nomor_induk" type="text" class="form-control" id="nomor_induk" value="{{ Auth::user()->nomor_induk }}">
                        </div>
                      </div>
                    <div class="row mb-3">
                      <label for="nama_lengkap" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nama_lengkap" type="text" class="form-control" id="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>


                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
  </footer>

  <a href= "{{ asset ('#') }}" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src= "{{ asset ('vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src= "{{ asset ('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src= "{{ asset ('vendor/chart.js/chart.umd.js') }}"></script>
  <script src= "{{ asset ('vendor/echarts/echarts.min.js') }}"></script>
  <script src= "{{ asset ('vendor/quill/quill.min.js') }}"></script>
  <script src= "{{ asset ('vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src= "{{ asset ('vendor/tinymce/tinymce.min.js') }}"></script>
  <script src= "{{ asset ('vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src= "{{ asset ('js/main.js') }}"></script>

</body>

</html>