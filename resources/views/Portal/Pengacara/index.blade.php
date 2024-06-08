@extends('Portal.Index.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/page-profile.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Office / {{$title}} /</span> Beranda</h4>

    <!-- Header -->
    <div class="row">
    <div class="col-12">
        <div class="card mb-4">
        <div class="user-profile-header-banner">
            <img src="{{ asset('assets') }}/img/office/cover/{{$office->cover}}" alt="Banner image" class="rounded-top" />
        </div>
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img
                src="{{ asset('assets') }}/img/office/logo/{{$office->logo}}"
                alt="user image"
                class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
            </div>
            <div class="flex-grow-1 mt-3 mt-sm-5">
            <div
                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                <div class="user-profile-info">
                <h4>{{$office->nama_kantor}}</h4>
                <ul
                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                    @if($office->type == 1)
                        <li class="list-inline-item fw-medium"><i class='bx bxs-business'></i> Pengacara</li>
                    @elseif($office->type == 2)
                        <li class="list-inline-item fw-medium"><i class='bx bxs-business'></i> Notaris</li>
                    @elseif($office->type == 3)
                        <li class="list-inline-item fw-medium"><i class='bx bxs-business'></i> Mediator</li>
                    @endif
                    @php
                    $codeParts = explode('.', $office->desa);
                
                    // Pastikan bahwa kode wilayah memiliki setidaknya 4 bagian
                    if (count($codeParts) >= 4) {
                        // Ambil kode provinsi
                        $provinceCode = $codeParts[0];
                
                        // Ambil nama provinsi dari database berdasarkan kode
                        $provinceName = ucfirst(strtolower(App\Models\Province::where('code', $provinceCode)->value('name')));
                
                        // Ambil kode kabupaten/kota
                        $regencyCode = $codeParts[0] . '.' . $codeParts[1];
                
                        // Ambil nama kabupaten/kota dari database berdasarkan kode
                        $regencyName = ucfirst(strtolower(App\Models\Regency::where('code', $regencyCode)->value('name')));
                
                        // Ambil kode kecamatan
                        $districtCode = $codeParts[0] . '.' . $codeParts[1] . '.' . $codeParts[2];
                
                        // Ambil nama kecamatan dari database berdasarkan kode
                        $districtName = ucfirst(strtolower(App\Models\District::where('code', $districtCode)->value('name')));
                
                        // Ambil kode desa/kelurahan
                        $villageCode = $codeParts[0] . '.' . $codeParts[1] . '.' . $codeParts[2] . '.' . $codeParts[3];
                
                        // Ambil nama desa/kelurahan dari database berdasarkan kode
                        $villageName = ucfirst(strtolower(App\Models\Village::where('code', $villageCode)->value('name')));
                    } else {
                        // Jika jumlah bagian kode wilayah kurang dari 4, berikan nilai default
                        $provinceName = $regencyName = $districtName = $villageName = null;
                    }
                @endphp
                
                    <li class="list-inline-item fw-medium"><i class="bx bx-map"></i> {{$provinceName}}, {{$regencyName}}</li>
                    <li class="list-inline-item fw-medium">
                    <i class="bx bx-calendar-alt"></i> Joined {{$joinedDate}}
                    </li>
                </ul>
                </div>
                @if($office->status == 1)
                    <a href="javascript:void(0)" class="btn btn-success text-nowrap">
                        <i class="bx bx-user-check me-1"></i>Verified
                    </a>
                @else
                    <a href="javascript:void(0)" class="btn btn-warning text-nowrap">
                        <i class='bx bxs-user-x me-1'></i>Not Verified
                    </a>
                @endif

            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!--/ Header -->

    <!-- Navbar pills -->
    <div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('lawyer') }}"><i class="bx bx-user me-1"></i> Beranda</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pages-profile-teams.html"><i class="bx bx-group me-1"></i> Teams</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pages-profile-projects.html"
            ><i class="bx bx-grid-alt me-1"></i> Projects</a
            >
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pages-profile-connections.html"
            ><i class="bx bx-link-alt me-1"></i> Connections</a
            >
        </li>
        </ul>
    </div>
    </div>
    <!--/ Navbar pills -->

    <!-- User Profile Content -->
    <div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
        <!-- About User -->
        <div class="card mb-4">
        <div class="card-body">
            <small class="text-muted text-uppercase">About</small>
            <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3">
                <i class="bx bx-user"></i><span class="fw-medium mx-2">Alamat:</span> <span>{{$office->nama_kantor}}</span>
            </li>
            <li class="d-flex align-items-center mb-3">
                <i class="bx bx-map"></i><span class="fw-medium mx-2">Alamat Kantor:</span> <span>{{$office->alamat}}, {{$villageName}}</span>
            </li>         
            <li class="d-flex align-items-center mb-3">
                <i class="bx bx-map"></i><span class="fw-medium mx-2">Kecamatan:</span> <span>{{$districtName}}</span>
            </li>
            <li class="d-flex align-items-center mb-3">
                <i class="bx bx-map"></i><span class="fw-medium mx-2">Kab/Prov:</span> <span>{{$regencyName}}, {{$provinceName}}</span>
            </li>
            <li class="d-flex align-items-center mb-3">
                <i class="bx bx-check"></i><span class="fw-medium mx-2">Status:</span> <span>  @if($office->status == 0)
                    Not Verified
                @else
                    Verified
                @endif</span>
            </li>
            </ul>
            <small class="text-muted text-uppercase">Contacts</small>
            <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3">
                <i class="bx bx-phone"></i><span class="fw-medium mx-2">Whatsapp:</span>
                <span>{{$office->hp_whatsapp}}</span>
            </li>      
            <li class="d-flex align-items-center mb-3">
                <i class="bx bx-envelope"></i><span class="fw-medium mx-2">Email:</span>
                <span>{{$office->email_kantor}}</span>
            </li>
            </ul>           
        </div>
        </div>
        <!--/ About User -->       
    </div>
    <div class="col-xl-8 col-lg-7 col-md-7">
        <!-- Activity Timeline -->
        <div class="card card-action mb-4">
        <div class="card-header align-items-center">
            <h5 class="card-action-title mb-0"><i class="bx bx-list-ul me-2"></i>Activity Timeline</h5>
            <div class="card-action-element">
            <div class="dropdown">
                <button
                type="button"
                class="btn dropdown-toggle hide-arrow p-0"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share timeline</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                </ul>
            </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="timeline ms-2">
            <li class="timeline-item timeline-item-transparent">
                <span class="timeline-point-wrapper"
                ><span class="timeline-point timeline-point-warning"></span
                ></span>
                <div class="timeline-event">
                <div class="timeline-header mb-1">
                    <h6 class="mb-0">Client Meeting</h6>
                    <small class="text-muted">Today</small>
                </div>
                <p class="mb-2">Project meeting with john @10:15am</p>
                <div class="d-flex flex-wrap">
                    <div class="avatar me-3">
                    <img src="{{ asset('assets') }}/img/avatars/3.png" alt="Avatar" class="rounded-circle" />
                    </div>
                    <div>
                    <h6 class="mb-0">Lester McCarthy (Client)</h6>
                    <span>CEO of Infibeam</span>
                    </div>
                </div>
                </div>
            </li>
            <li class="timeline-item timeline-item-transparent">
                <span class="timeline-point-wrapper"
                ><span class="timeline-point timeline-point-info"></span
                ></span>
                <div class="timeline-event">
                <div class="timeline-header mb-1">
                    <h6 class="mb-0">Create a new project for client</h6>
                    <small class="text-muted">2 Day Ago</small>
                </div>
                <p class="mb-0">Add files to new design folder</p>
                </div>
            </li>
            <li class="timeline-item timeline-item-transparent">
                <span class="timeline-point-wrapper"
                ><span class="timeline-point timeline-point-primary"></span
                ></span>
                <div class="timeline-event">
                <div class="timeline-header mb-1">
                    <h6 class="mb-0">Shared 2 New Project Files</h6>
                    <small class="text-muted">6 Day Ago</small>
                </div>
                <p class="mb-2">
                    Sent by Mollie Dixon
                    <img
                    src="{{ asset('assets') }}/img/avatars/4.png"
                    class="rounded-circle ms-3"
                    alt="avatar"
                    height="20"
                    width="20" />
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="javascript:void(0)" class="me-3">
                    <img
                        src="{{ asset('assets') }}/img/icons/misc/pdf.png"
                        alt="Document image"
                        width="20"
                        class="me-2" />
                    <span class="h6">App Guidelines</span>
                    </a>
                    <a href="javascript:void(0)">
                    <img
                        src="{{ asset('assets') }}/img/icons/misc/doc.png"
                        alt="Excel image"
                        width="20"
                        class="me-2" />
                    <span class="h6">Testing Results</span>
                    </a>
                </div>
                </div>
            </li>
            <li class="timeline-item timeline-item-transparent">
                <span class="timeline-point-wrapper"
                ><span class="timeline-point timeline-point-success"></span
                ></span>
                <div class="timeline-event pb-0">
                <div class="timeline-header mb-1">
                    <h6 class="mb-0">Project status updated</h6>
                    <small class="text-muted">10 Day Ago</small>
                </div>
                <p class="mb-0">Woocommerce iOS App Completed</p>
                </div>
            </li>
            <li class="timeline-end-indicator">
                <i class="bx bx-check-circle"></i>
            </li>
            </ul>
        </div>
        </div>
        <!--/ Activity Timeline -->
        <div class="row">
        <!-- Connections -->
        <div class="col-lg-12 col-xl-6">
            <div class="card card-action mb-4">
            <div class="card-header align-items-center">
                <h5 class="card-action-title mb-0">Connections</h5>
                <div class="card-action-element">
                <div class="dropdown">
                    <button
                    type="button"
                    class="btn dropdown-toggle hide-arrow p-0"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="javascript:void(0);">Share connections</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                <li class="mb-3">
                    <div class="d-flex align-items-start">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img src="{{ asset('assets') }}/img/avatars/2.png" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="me-2">
                        <h6 class="mb-0">Cecilia Payne</h6>
                        <small class="text-muted">45 Connections</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-label-primary btn-icon btn-sm">
                        <i class="bx bx-user"></i>
                        </button>
                    </div>
                    </div>
                </li>
                <li class="mb-3">
                    <div class="d-flex align-items-start">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img src="{{ asset('assets') }}/img/avatars/3.png" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="me-2">
                        <h6 class="mb-0">Curtis Fletcher</h6>
                        <small class="text-muted">1.32k Connections</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-primary btn-icon btn-sm"><i class="bx bx-user"></i></button>
                    </div>
                    </div>
                </li>
                <li class="mb-3">
                    <div class="d-flex align-items-start">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img src="{{ asset('assets') }}/img/avatars/10.png" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="me-2">
                        <h6 class="mb-0">Alice Stone</h6>
                        <small class="text-muted">125 Connections</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-primary btn-icon btn-sm"><i class="bx bx-user"></i></button>
                    </div>
                    </div>
                </li>
                <li class="mb-3">
                    <div class="d-flex align-items-start">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img src="{{ asset('assets') }}/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="me-2">
                        <h6 class="mb-0">Darrell Barnes</h6>
                        <small class="text-muted">456 Connections</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-label-primary btn-icon btn-sm">
                        <i class="bx bx-user"></i>
                        </button>
                    </div>
                    </div>
                </li>

                <li class="mb-3">
                    <div class="d-flex align-items-start">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img src="{{ asset('assets') }}/img/avatars/12.png" alt="Avatar" class="rounded-circle" />
                        </div>
                        <div class="me-2">
                        <h6 class="mb-0">Eugenia Moore</h6>
                        <small class="text-muted">1.2k Connections</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-label-primary btn-icon btn-sm">
                        <i class="bx bx-user"></i>
                        </button>
                    </div>
                    </div>
                </li>
                <li class="text-center">
                    <a href="javascript:;">View all connections</a>
                </li>
                </ul>
            </div>
            </div>
        </div>
        <!--/ Connections -->
        <!-- Teams -->
        <div class="col-lg-12 col-xl-6">
            <div class="card card-action mb-4">
            <div class="card-header align-items-center">
                <h5 class="card-action-title mb-0">Teams</h5>
                <div class="card-action-element">
                <div class="dropdown">
                    <button
                    type="button"
                    class="btn dropdown-toggle hide-arrow p-0"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="javascript:void(0);">Share teams</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                <li class="mb-3">
                    <div class="d-flex align-items-center">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img
                            src="{{ asset('assets') }}/img/icons/brands/react-label.png"
                            alt="Avatar"
                            class="rounded-circle" />
                        </div>
                        <div class="me-2">
                        <h6 class="mb-0">React Developers</h6>
                        <small class="text-muted">72 Members</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="javascript:;"><span class="badge bg-label-danger">Developer</span></a>
                    </div>
                    </div>
                </li>
                <li class="mb-3">
                    <div class="d-flex align-items-center">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img
                            src="{{ asset('assets') }}/img/icons/brands/support-label.png"
                            alt="Avatar"
                            class="rounded-circle" />
                        </div>
                        <div class="me-2">
                        <h6 class="mb-0">Support Team</h6>
                        <small class="text-muted">122 Members</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="javascript:;"><span class="badge bg-label-primary">Support</span></a>
                    </div>
                    </div>
                </li>
                <li class="mb-3">
                    <div class="d-flex align-items-center">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img
                            src="{{ asset('assets') }}/img/icons/brands/figma-label.png"
                            alt="Avatar"
                            class="rounded-circle" />
                        </div>
                        <div class="me-2">
                        <h6 class="mb-0">UI Designers</h6>
                        <small class="text-muted">7 Members</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="javascript:;"><span class="badge bg-label-info">Designer</span></a>
                    </div>
                    </div>
                </li>
                <li class="mb-3">
                    <div class="d-flex align-items-center">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img
                            src="{{ asset('assets') }}/img/icons/brands/vue-label.png"
                            alt="Avatar"
                            class="rounded-circle" />
                        </div>
                        <div class="me-2">
                        <h6 class="mb-0">Vue.js Developers</h6>
                        <small class="text-muted">289 Members</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="javascript:;"><span class="badge bg-label-danger">Developer</span></a>
                    </div>
                    </div>
                </li>
                <li class="mb-3">
                    <div class="d-flex align-items-center">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-3">
                        <img
                            src="{{ asset('assets') }}/img/icons/brands/twitter-label.png"
                            alt="Avatar"
                            class="rounded-circle" />
                        </div>
                        <div class="me-w">
                        <h6 class="mb-0">Digital Marketing</h6>
                        <small class="text-muted">24 Members</small>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="javascript:;"><span class="badge bg-label-secondary">Marketing</span></a>
                    </div>
                    </div>
                </li>
                <li class="text-center">
                    <a href="javascript:;">View all teams</a>
                </li>
                </ul>
            </div>
            </div>
        </div>
        <!--/ Teams -->
        </div>
        <!-- Projects table -->
        <div class="card mb-4">
        <h5 class="card-header">Projects List</h5>
        <div class="table-responsive mb-3">
            <table class="table datatable-project">
            <thead class="table-light">
                <tr>
                <th></th>
                <th></th>
                <th>Project</th>
                <th class="text-nowrap">Total Task</th>
                <th>Progress</th>
                <th>Hours</th>
                </tr>
            </thead>
            </table>
        </div>
        </div>
        <!--/ Projects table -->
    </div>
    </div>
    <!--/ User Profile Content -->
</div>
@endsection

@push('footer-script')   
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
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