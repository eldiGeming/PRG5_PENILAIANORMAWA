<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sistem Penialaian</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="{{ asset('https://fonts.gstatic.com" rel="preconnect') }}">
  <link href="{{ asset('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i') }}" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

  <!-- jQuery -->
  <script  src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js') }}"></script>

  <!-- DataTables CSS -->
    <link  href="{{ asset('https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">

  <script  href="{{ asset('https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js') }}"></script>

</head>

<body>

  < <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="{{ asset('index.html') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/Aastra.png') }}" > <!-- Sesuaikan ukuran yang diinginkan -->
        <span style="color: navy;">Penilaian ORMAWA</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo  -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="{{ asset('#') }}">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="{{ asset('#') }}" data-bs-toggle="dropdown">            
          <span>Hai, {{ Auth::user()->nama_lengkap }}</span>
          </a><!-- End Profile Iamge Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->nama_lengkap }}</h6>
              <span>{{ Auth::user()->role }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Logout</button>
            </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->


  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/home">
          <i class="bi bi-person"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/verifPengurus-table">
          <i class="bi bi-envelope"></i>
          <span>Verifikasi Pengurus</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/pertanyaan-table">
          <i class="bi bi-envelope"></i>
          <span>Kelola Pertanyaan</span>
        </a>
      </li><!-- End Contact Page Nav -->
      
      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/admin-table">
          <i class="bi bi-envelope"></i>
          <span>Kelola Admin</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/organisasi-table">
          <i class="bi bi-question-circle"></i>
          <span>Kelola Organisasi</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/divisi-table">
          <i class="bi bi-envelope"></i>
          <span>Kelola Divisi</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/jabatan-table">
          <i class="bi bi-envelope"></i>
          <span>Kelola Jabatan</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/dataPengurus-table">
          <i class="bi bi-envelope"></i>
          <span>Data Pengurus</span>
        </a>
      </li><!-- End Contact Page Nav -->


      
  </aside><!-- End Sidebar-->

  <main id="main" class="main-wrapper">

    @yield('content')

  </main><!-- End #main -->

  

  

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
    // Mendapatkan URI dari halaman saat ini
    const currentLocation = window.location.pathname;
  
    // Mendapatkan semua elemen anchor (tag a) dalam sidebar
    const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-link');
  
    // Loop melalui setiap link dalam sidebar
    sidebarLinks.forEach(link => {
      // Memeriksa apakah href link sama dengan URI halaman saat ini
      if (link.getAttribute('href') === currentLocation) {
        // Menambahkan kelas 'active' jika sesuai dengan URI
        link.classList.add('active');
      }
    });

    function confirmLogout() {
        if (confirm('Kamu yakin ingin logout?')) {
          document.getElementById('logoutForm').submit();
        }
    }

  </script>
</body>

</html>