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
            <a class="nav-link" href="{{ route('lawyer.detil') }}"><i class="bx bxs-business me-1"></i> Detil Kantor</a>
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
        @php
        use Carbon\Carbon;
        @endphp

        <div class="col-xl-8 col-lg-7 col-md-7">
            <div class="card card-action mb-4">                
                <div class="card-body">
                    <ul class="timeline ms-2">
                        @if ($officeActivities->isEmpty())
                            <li class="timeline-item timeline-item-transparent">
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">Belum ada aktivitas</h6>
                                    </div>
                                </div>
                            </li>
                        @else
                            @foreach ($officeActivities as $activity)
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point-wrapper">
                                        <span class="timeline-point timeline-point-{{ $activity->badge }}"></span>
                                    </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">{{ $activity->name }}</h6>
                                            <small class="text-muted">
                                                @if (Carbon::parse($activity->created_at)->isToday())
                                                    Hari ini
                                                @elseif (Carbon::parse($activity->created_at)->isYesterday())
                                                    Kemarin
                                                @else
                                                    {{ Carbon::parse($activity->created_at)->diffForHumans() }}
                                                @endif
                                            </small>
                                        </div>
                                        <p class="mb-2">{{ $activity->description }}</p>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                        <li class="timeline-end-indicator">
                            <i class="bx bx-check-circle"></i>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>

    </div>
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