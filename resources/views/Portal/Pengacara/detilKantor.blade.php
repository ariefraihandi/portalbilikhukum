@extends('Portal.Index.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/page-profile.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Office / {{$title}} /</span> Detil Kantor</h4>

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
                                @if($office->website)
                                    <a href="https://bilikhukum.com/pengacara/{{ $office->website }}" target="_blank" class="btn btn-info text-nowrap">
                                        <i class='bx bx-link'></i> Lihat Website
                                    </a>
                                @else
                                    <a href="{{ route('lawyer.website') }}" class="btn btn-info text-nowrap">
                                        <i class='bx bx-link'></i> Website
                                    </a>
                                @endif
                            
                            </div>
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
                    <a class="nav-link" href="{{ route('lawyer') }}"><i class="bx bx-user me-1"></i> Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('lawyer.detil') }}"><i class="bx bxs-business me-1"></i> Detil Kantor</a>
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
                    <a class="nav-link" href="{{ route('lawyer.member')}}"><i class='bx bxs-group'></i></i> Member</a>
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
                        <i class="bx bx-check"></i><span class="fw-medium mx-2">Status:</span> <span>  @if($office->status <= 1)
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
            <div class="card mb-4">
                @if($officeDocuments->isEmpty())
                @else
                <div class="card-body">
                    <h5 class="card-header">Daftar Dokumen Kantor</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Dokumen</th>                                  
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($officeDocuments as $document)
                            @php
                                $baseUrl = asset('assets/img/office/document/');
                                $fileUrl = $baseUrl . '/' . $document->file;
                            @endphp
                            <tr>
                                <td>
                                    @if($document->url)
                                        {{ $document->name }}
                                    @else
                                        <a href="{{ $fileUrl }}" target="_blank">{{ $document->name }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if($document->url)
                                        <i class="bx bx-check"></i>
                                    @else
                                        <a href="#" class="text-body" onclick="event.preventDefault(); if(confirm('Hapus dokumen ini?')) { document.getElementById('delete-form-{{ $document->id }}').submit(); }">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                        <form id="delete-form-{{ $document->id }}" action="{{ route('office.documents.delete', $document->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                @if($officeDocuments->isEmpty() || $officeDocuments->contains('url', null))
                    <div class="card-body">
                    <h5 class="card-header">Input Dokumen Pendirian Kantor</h5>
                    <form class="form-repeater" action="{{ route('office.documents') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div data-repeater-list="group-a">
                            <div data-repeater-item>
                                <div class="row">
                                    <div class="mb-3 col-lg-6 col-xl-6 col-12 mb-0">
                                        <label class="form-label" for="document-name">Nama Dokumen</label>
                                        <input type="text" id="document-name" name="group-a[][document_name]" class="form-control" placeholder="Nama Dokumen" required />
                                    </div>
                                    <div class="mb-3 col-lg-6 col-xl-6 col-12 mb-0">
                                        <label class="form-label" for="document-file">File Dokumen</label>
                                        <input type="file" id="document-file" name="group-a[][document_file]" class="form-control" required />
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary col-5" type="button" data-repeater-create>
                                        <i class="bx bx-plus me-1"></i>
                                        <span class="align-middle">Tambah</span>
                                    </button>
                                    <button class="btn btn-success col-5" type="submit">
                                        <i class="bx bx-send me-1"></i>
                                        <span class="align-middle">Kirim</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                    @endif
            </div>
            
            
        </div>
        <div class="col-xl-8 col-lg-7 col-md-7">
            <div class="card card-action mb-4"> 
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <!-- Bagian untuk Logo -->
                            <div class="col-md-6">
                                <form id="uploadLogoForm" action="{{ route('upload.logo') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="{{ asset('assets') }}/img/office/logo/{{ $office->logo }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedLogo" />
                                        <div class="button-wrapper">
                                            <label for="uploadLogo" class="btn btn-secondary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">Ganti logo</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input type="file" id="uploadLogo" name="logo" hidden class="account-file-input" accept="image/png, image/jpeg" />
                                            </label>
                                            <p class="text-muted mb-0">Allowed Square JPG, GIF or PNG. Max size of 2MB</p>
                                            <small class="error-message text-danger">
                                                @if($office->logo == 'default.webp')
                                                    <span class="badge badge-dot bg-danger me-1"></span> Anda belum mengganti logo
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Bagian untuk Cover -->
                            <div class="col-md-6">
                                <form id="uploadCoverForm" action="{{ route('upload.cover') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="{{ asset('assets') }}/img/office/cover/{{ $office->cover }}" alt="cover-image" class="d-block rounded" height="100" width="100" id="uploadedCover" />
                                        <div class="button-wrapper">
                                            <label for="uploadCover" class="btn btn-secondary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">Ganti cover</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input type="file" id="uploadCover" name="cover" hidden class="account-file-input" accept="image/png, image/jpeg" />
                                            </label>
                                            <p class="text-muted mb-0">Gambar Harus Berukuran 2252x500. Max size of 2MB</p>
                                            <small class="error-message text-danger">
                                                @if($office->cover == 'profile-banner.png')
                                                    <span class="badge badge-dot bg-danger me-1"></span> Anda belum mengganti cover
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                
             
                <h5 class="card-header">Detail Kantor</h5>
                <div class="card-body">
                    <form id="formChangePassword" method="POST" action="{{ route('office.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            @php
                                $readonly = $office->status >= 2 ? 'readonly' : '';
                            @endphp
                    
                            <div class="col-sm-6">
                                <label class="form-label" for="officeName">Nama Kantor</label>
                                <input type="text" required name="officeName" id="officeName" class="form-control" value="{{ $office->nama_kantor }}" {{ $readonly }} />
                                <small class="error-message text-danger"></small>
                            </div>
                    
                            <div class="col-sm-6">
                                <label class="form-label" for="officeEmail">Email Kantor</label>
                                <input type="email" readonly name="officeEmail" id="officeEmail" class="form-control" value="{{ $office->email_kantor }}" />
                                <small class="error-message text-danger"></small>
                            </div>
                    
                            <div class="col-sm-6">
                                <label class="form-label" for="officePhone">HP/WhatsApp</label>
                                <input type="text" required name="officePhone" id="officePhone" class="form-control" value="{{ $office->hp_whatsapp }}" {{ $readonly }} />
                                <small class="error-message text-danger"></small>
                            </div>
                    
                            <div class="col-sm-6">
                                <label class="form-label" for="officedesa">Alamat</label>
                                <input type="text" required name="officedesa" id="officedesa" class="form-control" value="{{ $office->alamat }}" {{ $readonly }} />
                                <small class="error-message text-danger"></small>
                            </div>
                    
                            <div class="col-sm-6">
                                <label class="form-label" for="postCode">Kode Pos</label>
                                <input type="text" required name="postCode" id="postCode" class="form-control" value="{{ $office->kode_pos }}" {{ $readonly }} />
                                <small class="error-message text-danger"></small>
                            </div>
                    
                            @php
                                use Carbon\Carbon;
                                $tanggalPendirian = Carbon::parse($office->tanggal_pendirian)->format('d-m-Y');
                            @endphp
                            
                            <div class="col-sm-6">
                                <label for="tanggal-pendirian" class="form-label">Tanggal Pendirian</label>
                                <input type="text" class="form-control" readonly id="tanggal-pendirian" name="tanggal-pendirian" value="{{ $tanggalPendirian }}" />
                                <small class="error-message text-danger"></small>
                            </div>
                    
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsProvince">Provinsi</label>
                                <select class="form-select select2" required id="multiStepsProvince" name="multiStepsProvince" {{ $readonly }}>
                                    <option value="" selected disabled>Pilih Provinsi</option>
                                </select>
                                <small class="error-message text-danger">
                                    @if($office->desa == 'default_value')
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
                                    @if($office->desa == 'default_value')
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
                                    @if($office->desa == 'default_value')
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
                                    @if($office->desa == 'default_value')
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
</div>
@endsection

@push('footer-script')   
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/pickr/pickr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')

<script>
    $(document).ready(function() {
      var select2 = $('.select2');
      var desa = "{{ $office->desa }}";
      var desaParts = desa.split('.');

      var provinceCode = desaParts[0];
      var regencyCode = desaParts.length > 1 ? desaParts[0] + '.' + desaParts[1] : '';
      var districtCode = desaParts.length > 2 ? desaParts[0] + '.' + desaParts[1] + '.' + desaParts[2] : '';
      var villageCode = desaParts.length > 3 ? desaParts[0] + '.' + desaParts[1] + '.' + desaParts[2] + '.' + desaParts[3] : '';

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

      // Set initial values based on desa
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
    document.getElementById('uploadLogo').addEventListener('change', function() {
        document.getElementById('uploadLogoForm').submit();
    });
    document.getElementById('uploadCover').addEventListener('change', function() {
        document.getElementById('uploadCoverForm').submit();
    });
</script>

<script>
    document.getElementById('verifyButton').addEventListener('click', function() {
        var officeDocuments = @json($officeDocuments);
    
        if (officeDocuments.length === 0) {
            // Jika tidak ada dokumen, tampilkan pesan error menggunakan SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Dokumen Kantor Belum Diperbaharui'
            });
            window.location.href = "{{ route('lawyer.detil') }}";
        } else {
            // Jika ada dokumennya, arahkan ke route office.askverified
            window.location.href = "{{ route('office.askverified') }}";
        }
    });
</script>

<script>
    $(document).ready(function () {
        $('.form-repeater').repeater({
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                // We don't need delete functionality, so this can be empty
            },
            ready: function (setIndexes) {
                // Called when the repeater is initialized
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