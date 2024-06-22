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
    
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Office / {{$title}} /</span> Member</h4>

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
                      <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                          <div class="user-profile-info">
                              <h4>{{ $office->nama_kantor }}</h4>
                              <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                  <li class="list-inline-item fw-medium">
                                      @for ($i = 0; $i < $labelCount; $i++)
                                          <span>$</span>
                                      @endfor
                                  </li>
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
                          <div class="d-flex flex-column flex-sm-row gap-2">
                              @if($office->status == 1)
                                  <a href="javascript:void(0)" class="btn btn-info text-nowrap">
                                      <i class="bx bx-time me-1"></i>Menunggu Persetujuan Verifikasi
                                  </a>
                              @elseif($office->status == 2)
                                  <a href="javascript:void(0)" class="btn btn-success text-nowrap">
                                      <i class='bx bx-user-check me-1'></i>Verified
                                  </a>
                              @elseif($office->status == 3)
                                  <a href="javascript:void(0)" class="btn btn-secondary text-nowrap">
                                      <i class='bx bx-pause-circle me-1'></i>Suspended
                                  </a>
                              @elseif($office->status == 4)
                                  <a href="javascript:void(0)" class="btn btn-danger text-nowrap">
                                      <i class='bx bx-block me-1'></i>Blocked
                                  </a>
                              @else
                                  <a href="javascript:void(0)" class="btn btn-warning text-nowrap" id="verifyButton">
                                      <i class='bx bxs-user-x me-1'></i>Not Verified / Ajukan Verifikasi
                                  </a>
                              @endif
                              <a href="{{route('lawyer.website')}}" class="btn btn-info text-nowrap">
                                  <i class='bx bx-link'></i>Wesbite
                              </a>
                          </div>
                      </div>
                      
                  </div>
              </div>
          </div>
      </div>
  </div>

   <!-- Navbar pills -->
   <div class="row">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lawyer') }}"><i class="bx bx-user me-1"></i> Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lawyer.detil') }}"><i class="bx bxs-business me-1"></i> Detil Kantor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lawyer.perkara')}}"><i class='bx bx-spreadsheet'></i></i> Perkara & Biaya</a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link" href="{{ route('lawyer.klien') }}">
                        <i class='bx bxs-user-detail'></i> Klien
                        @if($klienChatStatus0Count > 0)
                            <span class="badge badge-center rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 0.8rem;">{{ $klienChatStatus0Count }}</span>
                        @endif
                    </a>
                </li>   
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lawyer.website')}}"><i class='bx bx-link'></i></i> Website</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="{{ route('lawyer.member')}}"><i class='bx bxs-group'></i></i> Member</a>
              </li>
            </ul>
        </div>
    </div>
</div>
<!--/ Navbar pills -->

    <!-- Connection Cards -->
    <div class="row g-4">
      <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body text-center">
            <div class="dropdown btn-pinned">
              <button
                type="button"
                class="btn dropdown-toggle hide-arrow p-0"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share connection</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Block connection</a></li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item text-danger" href="javascript:void(0);">Delete</a></li>
              </ul>
            </div>
            <div class="mx-auto mb-3">
              <img src="{{ asset('assets') }}/img/avatars/3.png" alt="Avatar Image" class="rounded-circle w-px-100" />
            </div>
            <h5 class="mb-1 card-title">Mark Gilbert</h5>
            <span>UI Designer</span>
            <div class="d-flex align-items-center justify-content-center my-3 gap-2">
              <a href="javascript:;" class="me-1"><span class="badge bg-label-secondary">Figma</span></a>
              <a href="javascript:;"><span class="badge bg-label-warning">Sketch</span></a>
            </div>

            <div class="d-flex align-items-center justify-content-around my-4 py-2">
              <div>
                <h4 class="mb-1">18</h4>
                <span>Projects</span>
              </div>
              <div>
                <h4 class="mb-1">834</h4>
                <span>Tasks</span>
              </div>
              <div>
                <h4 class="mb-1">129</h4>
                <span>Connections</span>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <a href="javascript:;" class="btn btn-primary d-flex align-items-center me-3"
                ><i class="bx bx-user-check me-1"></i>Connected</a
              >
              <a href="javascript:;" class="btn btn-label-secondary btn-icon"
                ><i class="bx bx-envelope"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body text-center">
            <div class="dropdown btn-pinned">
              <button
                type="button"
                class="btn dropdown-toggle hide-arrow p-0"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share connection</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Block connection</a></li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item text-danger" href="javascript:void(0);">Delete</a></li>
              </ul>
            </div>
            <div class="mx-auto mb-3">
              <img src="{{ asset('assets') }}/img/avatars/12.png" alt="Avatar Image" class="rounded-circle w-px-100" />
            </div>
            <h5 class="mb-1 card-title">Eugenia Parsons</h5>
            <span>Developer</span>
            <div class="d-flex align-items-center justify-content-center my-3 gap-2">
              <a href="javascript:;" class="me-1"><span class="badge bg-label-danger">Angular</span></a>
              <a href="javascript:;"><span class="badge bg-label-info">React</span></a>
            </div>

            <div class="d-flex align-items-center justify-content-around my-4 py-2">
              <div>
                <h4 class="mb-1">112</h4>
                <span>Projects</span>
              </div>
              <div>
                <h4 class="mb-1">23.1k</h4>
                <span>Tasks</span>
              </div>
              <div>
                <h4 class="mb-1">1.28k</h4>
                <span>Connections</span>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <a href="javascript:;" class="btn btn-label-primary d-flex align-items-center me-3"
                ><i class="bx bx-user-plus me-1"></i>Connect</a
              >
              <a href="javascript:;" class="btn btn-label-secondary btn-icon"
                ><i class="bx bx-envelope"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body text-center">
            <div class="dropdown btn-pinned">
              <button
                type="button"
                class="btn dropdown-toggle hide-arrow p-0"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share connection</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Block connection</a></li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item text-danger" href="javascript:void(0);">Delete</a></li>
              </ul>
            </div>
            <div class="mx-auto mb-3">
              <img src="{{ asset('assets') }}/img/avatars/5.png" alt="Avatar Image" class="rounded-circle w-px-100" />
            </div>
            <h5 class="mb-1 card-title">Francis Byrd</h5>
            <span>Developer</span>
            <div class="d-flex align-items-center justify-content-center my-3 gap-2">
              <a href="javascript:;" class="me-1"><span class="badge bg-label-info">React</span></a>
              <a href="javascript:;"><span class="badge bg-label-primary">HTML</span></a>
            </div>

            <div class="d-flex align-items-center justify-content-around my-4 py-2">
              <div>
                <h4 class="mb-1">32</h4>
                <span>Projects</span>
              </div>
              <div>
                <h4 class="mb-1">1.25k</h4>
                <span>Tasks</span>
              </div>
              <div>
                <h4 class="mb-1">890</h4>
                <span>Connections</span>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <a href="javascript:;" class="btn btn-label-primary d-flex align-items-center me-3"
                ><i class="bx bx-user-plus me-1"></i>Connect</a
              >
              <a href="javascript:;" class="btn btn-label-secondary btn-icon"
                ><i class="bx bx-envelope"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body text-center">
            <div class="dropdown btn-pinned">
              <button
                type="button"
                class="btn dropdown-toggle hide-arrow p-0"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share connection</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Block connection</a></li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item text-danger" href="javascript:void(0);">Delete</a></li>
              </ul>
            </div>
            <div class="mx-auto mb-3">
              <img src="{{ asset('assets') }}/img/avatars/18.png" alt="Avatar Image" class="rounded-circle w-px-100" />
            </div>
            <h5 class="mb-1 card-title">Leon Lucas</h5>
            <span>UI/UX Designer</span>
            <div class="d-flex align-items-center justify-content-center my-3 gap-2">
              <a href="javascript:;" class="me-1"><span class="badge bg-label-secondary">Figma</span></a>
              <a href="javascript:;" class="me-1"><span class="badge bg-label-warning">Sketch</span></a>
              <a href="javascript:;"><span class="badge bg-label-primary">Photoshop</span></a>
            </div>

            <div class="d-flex align-items-center justify-content-around my-4 py-2">
              <div>
                <h4 class="mb-1">86</h4>
                <span>Projects</span>
              </div>
              <div>
                <h4 class="mb-1">12.4k</h4>
                <span>Tasks</span>
              </div>
              <div>
                <h4 class="mb-1">890</h4>
                <span>Connections</span>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <a href="javascript:;" class="btn btn-label-primary d-flex align-items-center me-3"
                ><i class="bx bx-user-plus me-1"></i>Connect</a
              >
              <a href="javascript:;" class="btn btn-label-secondary btn-icon"
                ><i class="bx bx-envelope"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body text-center">
            <div class="dropdown btn-pinned">
              <button
                type="button"
                class="btn dropdown-toggle hide-arrow p-0"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share connection</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Block connection</a></li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item text-danger" href="javascript:void(0);">Delete</a></li>
              </ul>
            </div>
            <div class="mx-auto mb-3">
              <img src="{{ asset('assets') }}/img/avatars/9.png" alt="Avatar Image" class="rounded-circle w-px-100" />
            </div>
            <h5 class="mb-1 card-title">Jayden Rogers</h5>
            <span>Full Stack Developer</span>
            <div class="d-flex align-items-center justify-content-center my-3 gap-2">
              <a href="javascript:;" class="me-1"><span class="badge bg-label-info">React</span></a>
              <a href="javascript:;" class="me-1"><span class="badge bg-label-danger">Angular</span></a>
              <a href="javascript:;"><span class="badge bg-label-primary">HTML</span></a>
            </div>

            <div class="d-flex align-items-center justify-content-around my-4 py-2">
              <div>
                <h4 class="mb-1">244</h4>
                <span>Projects</span>
              </div>
              <div>
                <h4 class="mb-1">23.8k</h4>
                <span>Tasks</span>
              </div>
              <div>
                <h4 class="mb-1">2.14k</h4>
                <span>Connections</span>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <a href="javascript:;" class="btn btn-primary d-flex align-items-center me-3"
                ><i class="bx bx-user-check me-1"></i>Connected</a
              >
              <a href="javascript:;" class="btn btn-label-secondary btn-icon"
                ><i class="bx bx-envelope"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body text-center">
            <div class="dropdown btn-pinned">
              <button
                type="button"
                class="btn dropdown-toggle hide-arrow p-0"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share connection</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Block connection</a></li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item text-danger" href="javascript:void(0);">Delete</a></li>
              </ul>
            </div>
            <div class="mx-auto mb-3">
              <img src="{{ asset('assets') }}/img/avatars/10.png" alt="Avatar Image" class="rounded-circle w-px-100" />
            </div>
            <h5 class="mb-1 card-title">Jeanette Powell</h5>
            <span>SEO</span>
            <div class="d-flex align-items-center justify-content-center my-3 gap-2">
              <a href="javascript:;" class="me-1"><span class="badge bg-label-success">Writing</span></a>
              <a href="javascript:;"><span class="badge bg-label-secondary">Analysis</span></a>
            </div>

            <div class="d-flex align-items-center justify-content-around my-4 py-2">
              <div>
                <h4 class="mb-1">32</h4>
                <span>Projects</span>
              </div>
              <div>
                <h4 class="mb-1">1.28k</h4>
                <span>Tasks</span>
              </div>
              <div>
                <h4 class="mb-1">1.27k</h4>
                <span>Connections</span>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <a href="javascript:;" class="btn btn-label-primary d-flex align-items-center me-3"
                ><i class="bx bx-user-plus me-1"></i>Connect</a
              >
              <a href="javascript:;" class="btn btn-label-secondary btn-icon"
                ><i class="bx bx-envelope"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Connection Cards -->
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