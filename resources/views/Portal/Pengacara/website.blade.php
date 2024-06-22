@extends('Portal.Index.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
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
    <!--/ Header -->

    <!-- Navbar pills -->
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
              <a class="nav-link active" href="{{ route('lawyer.website')}}"><i class='bx bx-link'></i></i> Website</a>
          </li>
          </ul>
      </div>
    </div>
    <!--/ Navbar pills -->

    <div class="row mt-4">
        <!-- Navigation -->
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
          <div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
            <ul class="nav nav-align-left nav-pills flex-column">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#configuration">
                  <i class="bx bx-cog faq-nav-icon me-1"></i>
                  <span class="align-middle">Hero</span>
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#aboutus">
                  <i class="bx bx-cog faq-nav-icon me-1"></i>
                  <span class="align-middle">Tentang Kami</span>
                </button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#galery">
                  <i class="bx bx-photo-album faq-nav-icon me-1"></i>
                  <span class="align-middle">Galery</span>
                </button>
              </li>              
            </ul>
            <div class="d-none d-md-block">
              <div class="mt-5">
                <img src="../../assets/img/illustrations/sitting-girl-with-laptop-light.png" class="img-fluid w-px-200" alt="FAQ Image" data-app-light-img="illustrations/sitting-girl-with-laptop-light.png" data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png" />
              </div>
            </div>
          </div>
        </div>
        <!-- /Navigation -->
      
        <!-- Tab Content -->
        <div class="col-lg-9 col-md-8 col-12">
          <div class="tab-content py-0">
            <div class="tab-pane fade show active" id="configuration" role="tabpanel">
              <div class="card card-action">
                <div class="card mb-4">
                  <div class="card-header d-flex justify-content-center">
                    <h5 class="card-title">Konfigurasi Landing Page</h5>
                  </div>
                  <div class="card-body">
                    <div class="row" id="configuration-row">
                      <!-- Row Pertama -->
                      <div class="col-md-6 mb-4">
                        <form id="uploadCoverForm" action="{{ route('upload.cover') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="d-flex align-items-start align-items-sm-center gap-4">                                
                            <img src="{{ asset('assets/img/office/site/') }}/{{ $officeSite && $officeSite->icon_image ? $officeSite->icon_image : 'icon_default.webp' }}" alt="cover-image" class="d-block rounded" height="100" width="100" id="uploadedCover" />
                            <div class="button-wrapper">
                              <label for="uploadCover" class="btn btn-secondary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Ganti Icon Kantor</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="uploadCover" name="cover" hidden class="account-file-input" accept="image/png, image/jpeg" />
                              </label>
                              <p class="text-muted mb-0">Gambar Harus Berukuran 200x200. Max size of 2MB</p>
                              <p>
                                <a href="{{ asset('assets/index/landingPage/images/logos/logo_home_20.png') }}" target="_blank">Lihat contoh gambar</a>
                              </p>
                              <small class="error-message text-danger">
                                @if($office->cover == 'profile-banner.png')
                                  <span class="badge badge-dot bg-danger me-1"></span> Anda belum mengganti cover
                                @endif
                              </small>
                            </div>
                          </div>
                        </form>
                      </div>
      
                      <!-- Row Kedua -->
                      <div class="col-md-6 mb-4">
                        <form id="uploadCoverForm" action="{{ route('upload.cover') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ asset('assets/img/office/site/') }}/{{ $officeSite && $officeSite->logo_image ? $officeSite->logo_image : 'logo_default.png' }}" alt="cover-image" class="d-block rounded" height="40" width="100" id="uploadedCover" />                             
                            <div class="button-wrapper">
                              <label for="uploadCover" class="btn btn-secondary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Ganti Logo Kantor</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="uploadCover" name="cover" hidden class="account-file-input" accept="image/png, image/jpeg" />
                              </label>
                              <p class="text-muted mb-0">Gambar Harus Berukuran 221x83. Max size of 2MB</p>
                              <p>
                                <a href="{{ asset('assets/index/landingPage/images/logos/logo_home_20.png') }}" target="_blank">Lihat contoh gambar</a>
                              </p>
                              <small class="error-message text-danger">
                                @if($office->cover == 'profile-banner.png')
                                  <span class="badge badge-dot bg-danger me-1"></span> Anda belum mengganti cover
                                @endif
                              </small>
                            </div>
                          </div>
                        </form>
                      </div>
      
                      <div class="col-md-6 mb-4">
                        <form id="uploadLogoForm" action="{{ route('upload.logo') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ asset('assets/img/office/site/') }}/{{ $officeSite && $officeSite->owner_image ? $officeSite->owner_image : 'default-image.webp' }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedCover" />
                            <div class="button-wrapper">
                              <label for="uploadLogo" class="btn btn-secondary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Foto Direktur/Pemilik Kantor</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="uploadLogo" name="logo" hidden class="account-file-input" accept="image/png, image/jpeg" />
                              </label>
                              <p class="text-muted mb-0">Allowed Square PNG. Max size of 2MB</p>
                              <p>
                                <a href="{{ asset('assets/img/office/site/default-image.webp') }}" target="_blank">Lihat contoh gambar</a>
                              </p>
                              <small class="error-message text-danger">
                                @if($office->logo == 'default.webp')
                                  <span class="badge badge-dot bg-danger me-1"></span> Anda belum mengganti logo
                                @endif
                              </small>
                            </div>
                          </div>
                        </form>
                      </div>
      
                      <div class="col-md-6 mb-4">
                        <form id="uploadCoverForm" action="{{ route('upload.cover') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ asset('assets/img/office/site/') }}/{{ $officeSite && $officeSite->owner_sec_image ? $officeSite->owner_sec_image : 'default-image.webp' }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedCover" />                                                                
                            <div class="button-wrapper">
                              <label for="uploadCover" class="btn btn-secondary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Foto 2 Direktur/Pemilik Kantor</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="uploadCover" name="cover" hidden class="account-file-input" accept="image/png, image/jpeg" />
                              </label>
                              <p class="text-muted mb-0">Allowed Square PNG. Max size of 2MB</p>
                              <p>
                                <a href="{{ asset('assets/img/office/site/default-image.webp') }}" target="_blank">Lihat contoh gambar</a>
                              </p>
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
              </div>
            </div>

            <div class="tab-pane fade" id="aboutus" role="tabpanel">
              <div class="card card-action">
                <div class="card mb-4">
                  <div class="card-header d-flex justify-content-center">
                    <h5 class="card-title">Tentang Kami</h5>
                  </div>
                  <div class="card-body">
                    <div class="row g-3">
                      <div class="col-sm-6">
                        <label class="form-label" for="aboutMe_title">Judul</label>
                        <input type="text" required name="aboutMe_title" id="aboutMe_title" class="form-control" value="{{ $officeSite->aboutMe_title ?? '' }}" />
                        <small class="error-message text-danger"></small>
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="aboutMe_description">Deskripsi</label>
                        <input type="text" required name="aboutMe_description" id="aboutMe_description" class="form-control" value="{{ $officeSite->aboutMe_description ?? '' }}" />
                        <small class="error-message text-danger"></small>
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="slogan">Slogan</label>
                        <input type="text" required name="slogan" id="slogan" class="form-control" value="{{ $office->slogan }}" />
                        <small class="error-message text-danger"></small>
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="tagLine">Tag Line</label>                            
                        <input type="text" required name="tagLine" id="tagLine" class="form-control" value="{{ $officeSite->tagline ?? '' }}" />
                        <small class="error-message text-danger"></small>
                      </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

           
            <div class="tab-pane fade" id="galery" role="tabpanel">
              <div class="card mt-3">
                  <div class="card-body">
                      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImageModal">Tambah Gallery</button>
                  </div>
                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th scope="col">No</th>
                              <th scope="col">Gambar</th>
                              <th scope="col">Judul Pendek</th>
                              <th scope="col">Judul</th>
                              <th scope="col">Deskripsi</th>
                              <th scope="col">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @forelse ($officeGalleries as $index => $gallery)
                              <tr>
                                  <th scope="row">{{ $index + 1 }}</th>
                                  <td><img src="{{ asset('assets/img/office/site/' . $gallery->image_file) }}" class="img-thumbnail" alt="{{ $gallery->short_title }}" style="max-width: 100px;"></td>
                                  <td>{{ $gallery->short_title }}</td>
                                  <td>{{ $gallery->title }}</td>
                                  <td>{{ $gallery->description }}</td>
                                  <td>
                                      <form action="" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                      </form>
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="6">Tidak ada data gallery.</td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
          
       
          </div>
        </div>  
    </div>
</div>

<!-- Example Edit Modal -->
@foreach($officeCases as $officeCase)
<div class="modal fade" id="editMenuModal_{{ $officeCase->id }}" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit form content -->
                <form id="editForm_{{ $officeCase->id }}" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="perkara">Perkara</label>
                        <input type="text" class="form-control" id="perkara" name="perkara" value="{{ $officeCase->legalCase->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="min_biaya">Min Biaya</label>
                        <input type="text" class="form-control" id="min_biaya" name="min_biaya" value="{{ $officeCase->min_fee }}">
                    </div>
                    <div class="form-group">
                        <label for="max_biaya">Max Biaya</label>
                        <input type="text" class="form-control" id="max_biaya" name="max_biaya" value="{{ $officeCase->max_fee }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach


<div class="modal fade" id="websiteModal" tabindex="-1" aria-labelledby="websiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="websiteModalLabel">Masukkan Nama Page</h5>
            </div>
            <div class="modal-body">
                <form id="websiteForm" action="{{ route('addWebsite') }}" method="POST">
                    @csrf                  
                    <div class="mb-3">
                        <label for="websiteName" class="form-label">Nama Page</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">https://bilikhukum.com/pengacara/</span>
                            <input type="text" class="form-control" id="websiteName" name="websiteName" required>
                        </div>
                        <input type="hidden" id="office_id" name="office_id" value="{{$office->id}}">
                        <small class="form-text text-muted">Silakan tulis nama lengkap kantor Anda atau singkatan nama kantor Anda.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                    <button type="button" class="btn btn-secondary" id="backButton">Back</button>   
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addImageModalLabel">Tambah Gambar ke Galeri</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('storeGallery') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
              <label for="shortTitle" class="form-label">Short Title</label>
              <input type="text" class="form-control" id="shortTitle" name="shortTitle" placeholder="Sidang">
          </div>
          <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Sidang perkara 12/Pdt.G/....">
          </div>
          <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="imageFile" class="form-label">Pilih Gambar (JPEG, PNG)</label>
            <input type="file" class="form-control" id="imageFile" name="imageFile" accept="image/jpeg, image/png">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Tambah Gambar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('footer-script')   
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/pickr/pickr.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if the office's website is null
            var officeWebsite = "{{ $office->website }}";
            if (!officeWebsite) {
                // Show the modal
                var websiteModal = new bootstrap.Modal(document.getElementById('websiteModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                websiteModal.show();

                // Disable the configuration row
                document.getElementById('configuration-row').classList.add('disabled');
            }

            // Handle the back button click to redirect
            document.getElementById('backButton').addEventListener('click', function() {
                window.history.back();
            });
        });
    </script>

    <script>
        document.getElementById('websiteName').addEventListener('input', function() {
            const websiteName = this.value;
            const url = `{{ route('checkWebsite') }}?websiteName=${websiteName}`;
            const inputField = this;
            const inputGroup = inputField.closest('.input-group-merge');
            let errorMessage = document.getElementById('websiteNameError');
            const submitButton = document.getElementById('submitButton');
        
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        if (!errorMessage) {
                            errorMessage = document.createElement('small');
                            errorMessage.id = 'websiteNameError';
                            errorMessage.className = 'form-text text-danger';
                            errorMessage.innerHTML = 'URL sudah ada. Silakan pilih nama lain.<br>';
                            inputGroup.parentNode.insertBefore(errorMessage, inputGroup.nextSibling);
                        }
                        submitButton.disabled = true;
                    } else {
                        if (errorMessage) {
                            errorMessage.remove();
                        }
                        submitButton.disabled = false;
                    }
                });
        });
    </script>
    

    <script>
        $(document).ready(function() {
            function fetchData(url, data, callback) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        callback(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Initialize Select2
            $('#kategoriPerkara').select2({
                placeholder: "Pilih Kategori",
                allowClear: true
            });

            // Fetch data for kategoriPerkara
            fetchData('{{ route("getcase") }}', {}, function(data) {
                // Create a map to group cases by kategori
                var groupedData = {};
                data.forEach(function(caseItem) {
                    if (!groupedData[caseItem.kategori]) {
                        groupedData[caseItem.kategori] = [];
                    }
                    groupedData[caseItem.kategori].push(caseItem);
                });

                // Append grouped options to select
                for (var kategori in groupedData) {
                    var optgroup = $('<optgroup>').attr('label', kategori);
                    groupedData[kategori].forEach(function(caseItem) {
                        var displayText = caseItem.name + ' | ' + caseItem.kategori;
                        optgroup.append(new Option(displayText, caseItem.id, false, false));
                    });
                    $('#kategoriPerkara').append(optgroup);
                }
                $('#kategoriPerkara').trigger('change');
            });
        });

        $(document).ready(function() {
            function formatRupiah(number) {
                var rupiah = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(number);

                // Remove 'Rp' from the start
                return rupiah.replace('Rp', '').trim();
            }

            function handleBiayaInput(event) {
                var value = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters
                if (value) {
                    event.target.value = formatRupiah(parseInt(value, 10)); // Format as rupiah
                } else {
                    event.target.value = '';
                }
            }

            $('#minBiaya, #maxBiaya').on('input', handleBiayaInput);
        });

        function showDeleteConfirmation(url, message) {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
      
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