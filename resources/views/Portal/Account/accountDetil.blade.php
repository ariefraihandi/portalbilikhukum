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
        <button type="button" class="btn btn-label-warning" data-bs-toggle="modal" data-bs-target="#daftarKantorModal">
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
          <a class="nav-link" href="{{ route('account.profile') }}"><i class="bx bx-user me-1"></i>Profile</a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link active" href="{{ route('account.detil') }}">
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

      <div class="card mb-4">      
        <form id="uploadForm" action="{{ route('upload.avatar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="{{ asset('assets') }}/img/member/{{ $userDetils->image }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-secondary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Ganti photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" name="avatar" hidden class="account-file-input" accept="image/png, image/jpeg" />
                        </label>
                        <p class="text-muted mb-0">Allowed Square JPG, GIF or PNG. Max size of 2MB</p>
                        <small class="error-message text-danger">
                          @if($userDetils->image == 'default.webp')
                              <span class="badge badge-dot bg-danger me-1"></span> Anda belum mengganti foto profile
                          @endif
                      </small>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="card mb-4">
        <h5 class="card-header">Profil Detil</h5>
        <div class="card-body">
            <form id="formChangePassword" method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data">                        
                @csrf                        
            <div class="row g-3">
                                            
                <div class="col-sm-6">
                    <label class="form-label" for="multiStepsName">Nama Lengkap</label>
                    <input type="text" required name="multiStepsName" id="multiStepsName" class="form-control" value="{{$userDetils->name}}" />
                    <small class="error-message text-danger"></small>
                </div>
                <!-- Username -->
                <div class="col-sm-6">
                    <label class="form-label" for="multiStepsUsername">Username</label>
                    <input type="text" required name="multiStepsUsername" id="multiStepsUsername" class="form-control" value="{{$userDetils->username}}" readonly/>
                    <small class="error-message text-danger"></small>
                </div>
                <!-- Email -->
                <div class="col-sm-6">
                    <div class="d-flex align-items-center lh-1 mb-3 mb-sm-0">
                        <label class="form-label me-3" for="multiStepsEmail">Email</label>
                    </div>
                    <input type="email" required name="multiStepsEmail" id="multiStepsEmail" class="form-control" value="{{ $userDetils->email }}" readonly aria-label="john.doe" />
                    <small class="error-message text-danger">
                        @if($userDetils->verified == 0)
                            <span class="badge badge-dot bg-danger me-1"></span> Not Verified
                        @endif
                    </small>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="gender">Jenis Kelamin</label>
                    <select class="form-select" required id="gender" name="gender">
                        <option value="" selected disabled>Pilih Jenis Kelamin</option>
                        <option value="1" {{ $userDetils->gender == 1 ? 'selected' : '' }}>Laki-laki</option>
                        <option value="2" {{ $userDetils->gender == 2 ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <small class="error-message text-danger">
                        @if($userDetils->gender == 'default_value')
                            <span class="badge badge-dot bg-danger me-1"></span> Not Set
                        @endif
                    </small>
                </div>
                
                <!-- Whatsapp -->
                <div class="col-sm-6">
                    <label class="form-label" for="multiStepsWhatsapp">Whatsapp</label>
                    <input type="text" required name="whatsapp" id="whatsapp" class="form-control" 
                    value="{{ $userDetils->whatsapp == 'default_value' ? '08xxxxxxxxxx' : $userDetils->whatsapp }}" />
                    <small class="error-message text-danger">
                        @if($userDetils->whatsapp == 'default_value')
                            <span class="badge badge-dot bg-danger me-1"></span> Not Set
                        @endif
                    </small>
                </div>
                <div class="col-sm-6">
                    <label for="dob" class="form-label">Tanggal Lahir</label>
                    <?php
                    

                    // Ambil tanggal lahir dari $userDetails dan konversi ke objek Carbon
                    $userDob = $userDetils->dob ? Carbon::parse($userDetils->dob)->format('Y-m-d') : '';
                    ?>
                    <input type="date" class="form-control" required placeholder="YYYY-MM-DD" id="flatpickr-date" name="dob" value="{{ $userDob }}" />
                    <small class="error-message text-danger">
                        @if($userDetils->dob == 'default_value')
                            <span class="badge badge-dot bg-danger me-1"></span> Not Set
                        @endif
                    </small>
                </div>                            
                <!-- Provinsi -->
                <div class="col-sm-6">
                    <label class="form-label" for="multiStepsProvince">Provinsi</label>
                    <select class="form-select select2" required id="multiStepsProvince" name="multiStepsProvince">
                        <option value="" selected disabled>Pilih Provinsi</option>
                    </select>
                    <small class="error-message text-danger">
                        @if($userDetils->address == 'default_value')
                            <span class="badge badge-dot bg-danger me-1"></span> Not Set
                        @endif
                    </small>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="multiStepsRegency">Kabupaten/Kota</label>
                    <select class="form-select select2" required id="multiStepsRegency" name="multiStepsRegency" disabled>
                        <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                    </select>
                    <small class="error-message text-danger">
                        @if($userDetils->address == 'default_value')
                            <span class="badge badge-dot bg-danger me-1"></span> Not Set
                        @endif
                    </small>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="multiStepsDistrict">Kecamatan</label>
                    <select class="form-select select2" required id="multiStepsDistrict" name="multiStepsDistrict" disabled>
                        <option value="" selected disabled>Pilih Kecamatan</option>
                    </select>
                    <small class="error-message text-danger">
                        @if($userDetils->address == 'default_value')
                            <span class="badge badge-dot bg-danger me-1"></span> Not Set
                        @endif
                    </small>
                </div>
                <div class="col-sm-6">
                    <label class="form-label" for="multiStepsVillage">Desa</label>
                    <select class="form-select select2" required id="multiStepsVillage" name="multiStepsVillage" disabled>
                        <option value="" selected disabled>Pilih Desa</option>
                    </select>
                    <small class="error-message text-danger">
                        @if($userDetils->address == 'default_value')
                            <span class="badge badge-dot bg-danger me-1"></span> Not Set
                        @endif
                    </small>
                </div>                           
            </div>                       
            <div class="row g-3 mt-1">
                <div class="d-grid gap-2 col-lg-12 mx-auto">    
                    <button type="submit" class="btn btn-success">Update Data</button>
                </div>
            </div>
          </form>
        </div>
      </div>
      </div>

      
    </div>
    <!--/ Customer Content -->
  </div>

  <!-- Modal -->
  <!-- Edit User Modal -->
  <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3>Edit User Information</h3>
            <p>Updating user details will receive a privacy audit.</p>
          </div>
          <form id="editUserForm" class="row g-3" onsubmit="return false">
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserFirstName">First Name</label>
              <input
                type="text"
                id="modalEditUserFirstName"
                name="modalEditUserFirstName"
                class="form-control"
                placeholder="John" />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserLastName">Last Name</label>
              <input
                type="text"
                id="modalEditUserLastName"
                name="modalEditUserLastName"
                class="form-control"
                placeholder="Doe" />
            </div>
            <div class="col-12">
              <label class="form-label" for="modalEditUserName">Username</label>
              <input
                type="text"
                id="modalEditUserName"
                name="modalEditUserName"
                class="form-control"
                placeholder="john.doe.007" />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserEmail">Email</label>
              <input
                type="text"
                id="modalEditUserEmail"
                name="modalEditUserEmail"
                class="form-control"
                placeholder="example@domain.com" />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserStatus">Status</label>
              <select
                id="modalEditUserStatus"
                name="modalEditUserStatus"
                class="form-select"
                aria-label="Default select example">
                <option selected>Status</option>
                <option value="1">Active</option>
                <option value="2">Inactive</option>
                <option value="3">Suspended</option>
              </select>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditTaxID">Tax ID</label>
              <input
                type="text"
                id="modalEditTaxID"
                name="modalEditTaxID"
                class="form-control modal-edit-tax-id"
                placeholder="123 456 7890" />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserPhone">Phone Number</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text">+1</span>
                <input
                  type="text"
                  id="modalEditUserPhone"
                  name="modalEditUserPhone"
                  class="form-control phone-number-mask"
                  placeholder="202 555 0111" />
              </div>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserLanguage">Language</label>
              <select
                id="modalEditUserLanguage"
                name="modalEditUserLanguage"
                class="select2 form-select"
                multiple>
                <option value="">Select</option>
                <option value="english" selected>English</option>
                <option value="spanish">Spanish</option>
                <option value="french">French</option>
                <option value="german">German</option>
                <option value="dutch">Dutch</option>
                <option value="hebrew">Hebrew</option>
                <option value="sanskrit">Sanskrit</option>
                <option value="hindi">Hindi</option>
              </select>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="modalEditUserCountry">Country</label>
              <select
                id="modalEditUserCountry"
                name="modalEditUserCountry"
                class="select2 form-select"
                data-allow-clear="true">
                <option value="">Select</option>
                <option value="Australia">Australia</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Belarus">Belarus</option>
                <option value="Brazil">Brazil</option>
                <option value="Canada">Canada</option>
                <option value="China">China</option>
                <option value="France">France</option>
                <option value="Germany">Germany</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Japan">Japan</option>
                <option value="Korea">Korea, Republic of</option>
                <option value="Mexico">Mexico</option>
                <option value="Philippines">Philippines</option>
                <option value="Russia">Russian Federation</option>
                <option value="South Africa">South Africa</option>
                <option value="Thailand">Thailand</option>
                <option value="Turkey">Turkey</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
              </select>
            </div>
            <div class="col-12">
              <label class="switch">
                <input type="checkbox" class="switch-input" />
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
                <span class="switch-label">Use as a billing address?</span>
              </label>
            </div>
            <div class="col-12 text-center">
              <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
              <button
                type="reset"
                class="btn btn-label-secondary"
                data-bs-dismiss="modal"
                aria-label="Close">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--/ Edit User Modal -->

  <!-- Add New Credit Card Modal -->
  <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3>Upgrade Plan</h3>
            <p>Choose the best plan for user.</p>
          </div>
          <form id="upgradePlanForm" class="row g-3" onsubmit="return false">
            <div class="col-sm-9">
              <label class="form-label" for="choosePlan">Choose Plan</label>
              <select id="choosePlan" name="choosePlan" class="form-select" aria-label="Choose Plan">
                <option selected>Choose Plan</option>
                <option value="standard">Standard - $99/month</option>
                <option value="exclusive">Exclusive - $249/month</option>
                <option value="Enterprise">Enterprise - $499/month</option>
              </select>
            </div>
            <div class="col-sm-3 d-flex align-items-end">
              <button type="submit" class="btn btn-primary">Upgrade</button>
            </div>
          </form>
        </div>
        <hr class="mx-md-n5 mx-n3" />
        <div class="modal-body">
          <h6 class="mb-0">User current plan is standard plan</h6>
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex justify-content-center me-2 mt-3">
              <sup class="h5 pricing-currency pt-1 mt-3 mb-0 me-1 text-primary">$</sup>
              <h1 class="display-3 mb-0 text-primary">99</h1>
              <sub class="h5 pricing-duration mt-auto mb-2">/month</sub>
            </div>
            <button class="btn btn-label-danger cancel-subscription mt-3">Cancel Subscription</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Add New Credit Card Modal -->

  <!-- /Modal -->
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
    <script src="{{ asset('assets') }}/js/modal-edit-user.js"></script>
    <script src="{{ asset('assets') }}/js/app-ecommerce-customer-detail.js"></script>
    <script src="{{ asset('assets') }}/js/app-ecommerce-customer-detail-overview.js"></script>
    
    <script>
      $(document).ready(function() {
        var select2 = $('.select2');
        var address = "{{ $userDetils->address }}";
        var addressParts = address.split('.');

        var provinceCode = addressParts[0];
        var regencyCode = addressParts.length > 1 ? addressParts[0] + '.' + addressParts[1] : '';
        var districtCode = addressParts.length > 2 ? addressParts[0] + '.' + addressParts[1] + '.' + addressParts[2] : '';
        var villageCode = addressParts.length > 3 ? addressParts[0] + '.' + addressParts[1] + '.' + addressParts[2] + '.' + addressParts[3] : '';

        function initSelect2() {
            select2.each(function () {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this.select2({
                    placeholder: 'Select an option',
                    dropdownParent: $this.parent()
                });
            });
        }

        function fetchData(url, params, callback) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: params,
                success: function(data) {
                    callback(data);
                }
            });
        }

        function setSelectedOption($element, value, text) {
            var option = new Option(text, value, true, true);
            $element.append(option).trigger('change');
        }

        function loadRegencies(provinceCode) {
            $('#multiStepsRegency').val(null).trigger('change').prop('disabled', true);
            $('#multiStepsDistrict').val(null).trigger('change').prop('disabled', true);
            $('#multiStepsVillage').val(null).trigger('change').prop('disabled', true);
            if (provinceCode) {
                fetchData('{{ route("getRegencies") }}', { province_code: provinceCode }, function(data) {
                    data.forEach(function(regency) {
                        var text = regency.name.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); });
                        $('#multiStepsRegency').append(new Option(text, regency.code, false, regency.code === regencyCode));
                    });
                    $('#multiStepsRegency').prop('disabled', false);
                    if (regencyCode) {
                        $('#multiStepsRegency').val(regencyCode).trigger('change');
                    }
                });
            }
        }

        function loadDistricts(regencyCode) {
            $('#multiStepsDistrict').val(null).trigger('change').prop('disabled', true);
            $('#multiStepsVillage').val(null).trigger('change').prop('disabled', true);
            if (regencyCode) {
                fetchData('{{ route("getDistricts") }}', { regency_code: regencyCode }, function(data) {
                    data.forEach(function(district) {
                        var text = district.name.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); });
                        $('#multiStepsDistrict').append(new Option(text, district.code, false, district.code === districtCode));
                    });
                    $('#multiStepsDistrict').prop('disabled', false);
                    if (districtCode) {
                        $('#multiStepsDistrict').val(districtCode).trigger('change');
                    }
                });
            }
        }

        function loadVillages(districtCode) {
            $('#multiStepsVillage').val(null).trigger('change').prop('disabled', true);
            if (districtCode) {
                fetchData('{{ route("getVillages") }}', { district_code: districtCode }, function(data) {
                    data.forEach(function(village) {
                        var text = village.name.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); });
                        $('#multiStepsVillage').append(new Option(text, village.code, false, village.code === villageCode));
                    });
                    $('#multiStepsVillage').prop('disabled', false);
                    if (villageCode) {
                        $('#multiStepsVillage').val(villageCode).trigger('change');
                    }
                });
            }
        }

        initSelect2();

        $('#multiStepsProvince').select2({
            placeholder: 'Pilih Provinsi',
            allowClear: true,
            ajax: {
                url: '{{ route("getProvinces") }}',
                type: 'GET',
                dataType: 'json',
                processResults: function(data) {
                    var formattedData = data.map(function(province) {
                        var text = province.name.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); });
                        return {
                            id: province.code,
                            text: text
                        };
                    });
                    return {
                        results: formattedData
                    };
                }
            }
        }).on('select2:select', function(e) {
            var provinceCode = e.params.data.id;
            loadRegencies(provinceCode);
        });

        $('#multiStepsRegency').on('select2:select', function(e) {
            var regencyCode = e.params.data.id;
            loadDistricts(regencyCode);
        });

        $('#multiStepsDistrict').on('select2:select', function(e) {
            var districtCode = e.params.data.id;
            loadVillages(districtCode);
        });

        // Set initial values based on address
        if (provinceCode) {
            fetchData('{{ route("getProvinces") }}', {}, function(data) {
                var province = data.find(p => p.code === provinceCode);
                if (province) {
                    setSelectedOption($('#multiStepsProvince'), province.code, province.name.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); }));
                    loadRegencies(provinceCode);
                }
            });
        }
        if (regencyCode) {
            fetchData('{{ route("getRegencies") }}', { province_code: provinceCode }, function(data) {
                var regency = data.find(r => r.code === regencyCode);
                if (regency) {
                    setSelectedOption($('#multiStepsRegency'), regency.code, regency.name.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); }));
                    loadDistricts(regencyCode);
                }
            });
        }
        if (districtCode) {
            fetchData('{{ route("getDistricts") }}', { regency_code: regencyCode }, function(data) {
                var district = data.find(d => d.code === districtCode);
                if (district) {
                    setSelectedOption($('#multiStepsDistrict'), district.code, district.name.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); }));
                    loadVillages(districtCode);
                }
            });
        }
        if (villageCode) {
        fetchData('{{ route("getVillages") }}', { district_code: districtCode }, function(data) {
            var village = data.find(v => villageCode === v.code);
            if (village) {
                setSelectedOption($('#multiStepsVillage'), village.code, village.name.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); }));
            }
          });
        }
      });
      document.getElementById('upload').addEventListener('change', function() {
        document.getElementById('uploadForm').submit();
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