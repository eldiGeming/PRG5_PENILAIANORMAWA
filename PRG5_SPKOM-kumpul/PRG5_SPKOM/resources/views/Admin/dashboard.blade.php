@extends('layout/navbar_admin')

@section('content')
<main class="main-wrapper">
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <a href="{{ route('organisasi.index') }}">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">ORGANISASI</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-building"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $jumlahOrganisasi }}</h6>
                      <span class="text-success small pt-1 fw-bold">Organisasi</span>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            </div><!-- End Sales Card -->

            <div class="col-xxl-4 col-md-6">
              <a href="{{ route('divisi.index') }}">
                <div class="card info-card sales-card">
                  <div class="card-body">
                    <h5 class="card-title">DIVISI</h5>
  
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-building"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{ $jumlahDivisi }}</h6>
                        <span class="text-success small pt-1 fw-bold">Divisi</span>
                      </div>
                    </div>
                  </a>
                </div>
  
                </div>
              </div>

              <div class="col-xxl-4 col-md-6">
                <a href="{{ route('jabatan.index') }}">
                <div class="card info-card sales-card">
                  <div class="card-body">
                    <h5 class="card-title">JABATAN</h5>
  
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-building"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{ $jumlahJabatan }}</h6>
                        <span class="text-success small pt-1 fw-bold">Jabatan</span>
  
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>  
        
    </section>

  </main><!-- End #main -->
  @endsection