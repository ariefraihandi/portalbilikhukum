@extends('Portal.Index.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/@form-validation/umd/styles/index.min.css" />
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">                
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Account /</span> {{$title}}
    </h4>
    
    @if($office->isEmpty())
    <button type="button" class="btn btn-label-warning" data-bs-toggle="modal" data-bs-target="#officeRegister">
      Daftarkan Kantor Hukum Anda
    </button>
    @else
        <button type="button" class="btn btn-label-success">
            Kelola Kantor Hukum Anda
        </button>
    @endif
  </div> 

  <div class="row">
    <!-- Customer-detail Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
      <!-- Customer-detail Card -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="customer-avatar-section">
            <div class="d-flex align-items-center flex-column">
              <img
                class="img-fluid rounded my-3"
                src="{{ asset('assets/img/member/' . $userDetils->image) }}"
                height="110"
                width="110"
                alt="User avatar" />
              <div class="customer-info text-center">
                <h4 class="mb-1">{{$userDetils->name}}</h4>
                @php
                  $codeParts = explode('.', $userDetils->address);

                  // Ambil kode provinsi
                  $provinceCode = $codeParts[0];

                  // Ambil nama provinsi dari database berdasarkan kode
                  $provinceName = App\Models\Province::where('code', $provinceCode)->value('name');
                  $provinceName = ucfirst(strtolower($provinceName)); // Ubah menjadi huruf kapital pada awal kata

                  // Inisialisasi variabel nama kabupaten
                  $regencyName = null;

                  // Jika ada nama provinsi, lanjutkan untuk mendapatkan nama kabupaten
                  if ($provinceName) {
                      // Ambil kode kabupaten
                      $regencyCode = $codeParts[0] . '.' . $codeParts[1];

                      // Ambil nama kabupaten dari database berdasarkan kode
                      $regencyName = App\Models\Regency::where('code', $regencyCode)->value('name');
                      $regencyName = ucfirst(strtolower($regencyName)); // Ubah menjadi huruf kapital pada awal kata
                  }
                @endphp
                <small>{{$provinceName}}, {{$regencyName}}</small>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-around flex-wrap mt-4 py-3">
            <div class="d-flex align-items-center gap-2">
              <div class="avatar">
                <div class="avatar-initial rounded bg-label-primary">                              
                  <i class="bx bxs-user-plus bx-sm"></i>
                </div>
              </div>
              <div>
                <h5 class="mb-0">184</h5>
                <span>Refferal</span>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="avatar">
                <div class="avatar-initial rounded bg-label-primary">
                  <i class="bx bxs-calendar bx-sm"></i>                              
                </div>
              </div>
              <div>
                @php
                use Carbon\Carbon;
            @endphp
            
            {{-- Set locale menjadi Bahasa Indonesia --}}
            @php
                Carbon::setLocale('id');
            @endphp
            
            {{-- Format tanggal menggunakan Carbon --}}
            <h5 class="mb-0">
                {{ Carbon::parse($userDetils->created_at)->translatedFormat('d M Y') }}
            </h5>
                <span>Since</span>
              </div>
            </div>
          </div>

          <div class="info-container">
            <small class="d-block pt-4 border-top fw-normal text-uppercase text-muted my-3">DETAILS</small>
            <ul class="list-unstyled">
              <li class="mb-3">
                <span class="fw-medium me-2">Username:</span>
                <span>{{$userDetils->username}}</span>
              </li>
              <li class="mb-3">
                <span class="fw-medium me-2">Email:</span>
                <span>{{$userDetils->email}}</span>
              </li>
              <li class="mb-3">
                <span class="fw-medium me-2">Status:</span>
                <span class="badge bg-label-success">Active</span>
              </li>
              @if($userDetils->whatsapp !== 'default_value')
              <li class="mb-3">
                  <span class="fw-medium me-2">Contact:</span>
                  <span>{{$userDetils->whatsapp}}</span>
              </li>
              @endif

              @if(!empty($regencyName))
              <li class="mb-3">
                  <span class="fw-medium me-2">Alamat:</span>
                  <span>{{$regencyName}}</span>
              </li>
              @endif
            </ul>
            <div class="d-flex justify-content-center">
              <a
                href="javascript:;"
                class="btn btn-primary me-3"
                data-bs-target="#editUser"
                data-bs-toggle="modal"
                >Edit Details</a
              >
            </div>
          </div>
        </div>
      </div>
      <!-- /Customer-detail Card -->
      <!-- Plan Card -->

      {{-- <div class="card mb-4 bg-gradient-primary">
        <div class="card-body">
          <div class="row justify-content-between mb-3">
            <div
              class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-center text-lg-start text-xl-center text-xxl-start order-1 order-lg-0 order-xl-1 order-xxl-0">
              <h4 class="card-title text-white text-nowrap">Upgrade</h4>
              <p class="card-text text-white">
                Akses 100+ Manfaat Dengan Upgrade Jenis Keanggotaan
              </p>
            </div>
            <span class="col-md-12 col-lg-5 col-xl-12 col-xxl-5 text-center mx-auto mx-md-0 mb-2"
              ><img src="{{ asset('assets') }}/img/illustrations/rocket.png" class="w-px-75 m-2" alt="3dRocket"
            /></span>
          </div>
          <button
            class="btn btn-white text-primary w-100 fw-medium shadow-sm"
            data-bs-target="#upgradePlanModal"
            data-bs-toggle="modal">
            Upgrade Sekarang
          </button>
        </div>
      </div> --}}

      <!-- /Plan Card -->
    </div>
    <!--/ Customer Sidebar -->

    <!-- Customer Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
      <!-- Customer Pills -->
      <ul class="nav nav-pills flex-column flex-md-row mb-4">
        <li class="nav-item position-relative">
          <a class="nav-link active" href="{{ route('account.profile') }}"><i class="bx bx-user me-1"></i>Profile</a>
          
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link" href="{{ route('account.detil') }}">
              <i class="bx bxs-user-detail me-1"></i>Detils
      
              @if($erorDetil > 4)
                  <span class="badge badge-center bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 0.8rem;">{{ $erorDetil }}</span>
              @endif
          </a>
        </li>                                                        
        <li class="nav-item">
          <a class="nav-link" href="app-ecommerce-customer-details-billing.html"
            ><i class="bx bx-detail me-1"></i>Address & Billing</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" href="app-ecommerce-customer-details-notifications.html"
            ><i class="bx bx-bell me-1"></i>Notifications</a
          >
        </li>
      </ul>
      <!--/ Customer Pills -->

      <!-- / Customer cards -->
      <div class="row text-nowrap">
        <div class="col-md-6 mb-4">
          <div class="card h-100">
              <div class="card-body">
                  <div class="card-icon mb-3">
                      @if(!is_null($hasReferralCode))
                      <div class="avatar">
                          <div class="avatar-initial rounded bg-label-primary">
                              <i class="bx bx-wallet-alt bx-sm"></i>
                          </div>
                      </div>
                      @else
                      <div class="avatar">
                          <div class="avatar-initial rounded bg-label-primary">
                              <i class="bx bx-user-plus bx-sm"></i>
                          </div>
                      </div>
                      @endif
                  </div>
                  <div class="card-info">
                    @if(!is_null($hasReferralCode))
                      <h4 class="card-title mb-3">Dompet</h4>
                      <div class="d-flex align-items-end mb-1 gap-1">
                          <h4 class="text-primary mb-0">Rp. 0,-</h4>
                      </div>
                      <p class="text-muted mb-0 text-truncate">Total Penarikan Rp. 0,-</p>
                      @else
                      <h4 class="card-title mb-3">Ikuti Program Loyalitas</h4>
                      <div class="d-flex align-items-end mb-1 gap-1">
                        <a href="{{ route('refferal') }}" class="btn btn-primary">Berbagi dan Dapatkan Keuntungan</a>
                      </div>
                      {{-- <p class="text-muted mb-0 text-truncate">Ajak teman & Mulai Menghasilkan</p>                                   --}}
                      @endif
                  </div>
              </div>
          </div>
        </div>
                          <div class="col-md-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-icon mb-3">
                <div class="avatar">
                  <div class="avatar-initial rounded bg-label-warning">
                    <i class="bx bxs-calendar-event bx-sm"></i>
                  </div>
                </div>
              </div>
              <div class="card-info">
                <h4 class="card-title mb-3">Next Event</h4>
                <span class="badge bg-label-warning mb-1">Coming Soon..!</span>
                <p class="text-muted mb-0">Nantikan kegiatan seru lainnya</p>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="col-md-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-icon mb-3">
                <div class="avatar">
                  <div class="avatar-initial rounded bg-label-warning">
                    <i class="bx bx-star bx-sm"></i>
                  </div>
                </div>
              </div>
              <div class="card-info">
                <h4 class="card-title mb-3">Wishlist</h4>
                <div class="d-flex align-items-end mb-1 gap-1">
                  <h4 class="text-warning mb-0">15</h4>
                  <p class="mb-0">Items in wishlist</p>
                </div>
                <p class="text-muted mb-0 text-truncate">Receive notification when items go on sale</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-icon mb-3">
                <div class="avatar">
                  <div class="avatar-initial rounded bg-label-info">
                    <i class="bx bxs-discount bx-sm"></i>
                  </div>
                </div>
              </div>
              <div class="card-info">
                <h4 class="card-title mb-3">Coupons</h4>
                <div class="d-flex align-items-end mb-1 gap-1">
                  <h4 class="text-info mb-0">21</h4>
                  <p class="mb-0">Coupons you win</p>
                </div>

                <p class="text-muted mb-0 text-truncate">Use coupon on next purchase</p>
              </div>
            </div>
          </div>
        </div> --}}
      </div>

      <!-- / customer cards -->

      <!-- Invoice table -->
      <div class="card mb-4">
        <h5 class="card-header">Last Activity</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                  <th>No</th>
                  <th>User</th>
                  <th>IP Address</th>
                  <th>User Agent</th>
                  <th>Last Activity</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($sessions as $session)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $session->user->name }}</td>
                    <td>{{ $session->ip_address }}</td>
                    <td>
                        @php
                        $userAgent = $session->user_agent;
                        $device = 'Unknown';
                        if (strpos(strtolower($userAgent), 'mobile') !== false || strpos(strtolower($userAgent), 'android') !== false || strpos(strtolower($userAgent), 'iphone') !== false || strpos(strtolower($userAgent), 'ipad') !== false) {
                            $device = 'Mobile';
                        } elseif (strpos(strtolower($userAgent), 'macintosh') !== false || strpos(strtolower($userAgent), 'windows') !== false || strpos(strtolower($userAgent), 'linux') !== false) {
                            $device = 'Laptop/Desktop';
                        }
                        echo $device;
                        @endphp
                    </td>
                    <td>{{ \Carbon\Carbon::parse($session->last_activity)->format('Y-m-d H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!--/ Customer Content -->
  </div>
</div>

<div class="modal fade" id="officeRegister" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-simple modal-upgrade-plan">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body p-2">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="rounded-top">
          <h2 class="text-center mb-2 mt-0 mt-md-4 px-2">Pilih Jenis Kantor Hukum Anda</h2>
          <p class="text-center pb-3 px-2">
              Silahkan pilih jenis pendaftaran yang ingin Anda lakukan.
          </p>
          <div class="row mx-0 gy-3">
            <!-- Basic -->
            <div class="col-lg mb-md-0 mb-4">
              <div class="card border rounded shadow-none">
                <div class="card-body position-relative">
                  <div class="my-3 pt-2 text-center">
                    <img
                      src="{{ asset('assets') }}/img/icons/unicons/mediator.png"
                      alt="Starter Image"
                      height="80" />
                  </div>
                  <h3 class="card-title text-center text-capitalize mb-1">Mediator</h3>
                  <p class="text-center">Mendaftar sebagai mediator</p>  
                  <button type="button" class="btn btn-label-success d-grid w-100" data-bs-toggle="modal" data-bs-target="#twoFactorAuthOne">Mendaftar</button>                                                       
                </div>
              </div>
            </div>
            <!-- Pro -->
            <div class="col-lg mb-md-0 mb-4">
              <div class="card border-primary border shadow-none">
                <div class="card-body position-relative">                               
                  <div class="my-3 pt-2 text-center">
                    <img
                      src="{{ asset('assets') }}/img/icons/unicons/lawyer.png"
                      alt="Pro Image"
                      height="80" />
                  </div>
                  <h3 class="card-title text-center text-capitalize mb-1">Pengacara</h3>
                  <p class="text-center">Mendaftar sebagai pengacara</p>
                  <a href="#" class="btn btn-label-success d-grid w-100 btn-mendaftar">Mendaftar</a>
                </div>
              </div>
            </div>

            <!-- Enterprise -->
            <div class="col-lg">
              <div class="card border rounded shadow-none">
                <div class="card-body">
                  <div class="my-3 pt-2 text-center">
                    <img
                      src="{{ asset('assets') }}/img/icons/unicons/notary.png"
                      alt="Pro Image"
                      height="80" />
                  </div>
                  <h3 class="card-title text-center text-capitalize mb-1">Notaris</h3>
                  <p class="text-center">Mendaftar sebagai notaris</p>
                  <a href="#" class="btn btn-label-success d-grid w-100">Mendaftar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('footer-script') 
    <script src="{{ asset('assets') }}/vendor/libs/moment/moment.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/cleavejs/cleave.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
@endpush

@push('footer-Sec-script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
      // Event listener untuk tombol Mendaftar
      document.querySelector('.btn-mendaftar').addEventListener('click', function(event) {
          event.preventDefault(); // Mencegah navigasi default

          var erorDetil = {{ $erorDetil }}; // Asumsikan erorDetil tersedia dari backend

          if (erorDetil > 4) {
              Swal.fire({
                  icon: 'error',
                  title: 'Profile Belum Lengkap',
                  text: 'Lengkapi profile anda dan ubah avatar anda sebelum mendaftar',
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = '{{ route("account.detil") }}';
                  }
              });
          } else {
              window.location.href = '{{ route("showRegisterPengacara") }}';
          }
      });
  });
</script>

<script>
  function showSweetAlert(response) {
      Swal.fire({
          icon: response.success ? 'success' : 'error',
          title: response.title,
          text: response.message,
      });
  }
  
  document.addEventListener('DOMContentLoaded', function() {
      @if(session('response'))
          var response = @json(session('response'));
          showSweetAlert(response);
      @endif
  });
</script>
@endpush