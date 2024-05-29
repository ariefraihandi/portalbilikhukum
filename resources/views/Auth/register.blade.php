@extends('Portal/Index/app-auth')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/css/pages/page-auth.css" />
    <link rel="stylesheet" href="{{ asset('portal_assets') }}/assets/vendor/libs/animate-css/animate.css" />
@endpush

@section('content')
<div class="authentication-wrapper authentication-cover">
    <div class="authentication-inner row m-0">
      <!-- Left Text -->
      <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-end p-5 pe-0">
        <div class="w-px-400">
          <img
            src="{{ asset('portal_assets') }}/assets/img/illustrations/create-account-light.png"
            class="img-fluid"
            alt="multi-steps"
            width="600"
            data-app-dark-img="illustrations/create-account-dark.png"
            data-app-light-img="illustrations/create-account-light.png" />
        </div>
      </div>
      <!-- /Left Text -->

      <!--  Multi Steps Registration -->
      <div class="d-flex col-lg-8 align-items-center justify-content-center authentication-bg p-sm-5 p-3">
        <div class="w-px-700">
            <div id="multiStepsValidation" class="bs-stepper shadow-none">
                <div class="bs-stepper-header border-bottom-0">
                    <div class="step" data-target="#accountDetailsValidation">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="bx bx-user"></i></span>
                            <span class="bs-stepper-label mt-1">
                                <span class="bs-stepper-title">Akun</span>
                                <span class="bs-stepper-subtitle">Detail Akun</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="bx bx-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#officeInfoValidation">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="bx bx-home-alt"></i></span>
                            <span class="bs-stepper-label mt-1">
                                <span class="bs-stepper-title">Kantor</span>
                                <span class="bs-stepper-subtitle">Data Kantor</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i class="bx bx-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#billingLinksValidation">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="bx bx-detail"></i></span>
                            <span class="bs-stepper-label mt-1">
                                <span class="bs-stepper-title">Pembayaran</span>
                                <span class="bs-stepper-subtitle">Detail Pembayaran</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form id="multiStepsForm" onSubmit="return false">
                        <!-- Account Details -->
                        <div id="accountDetailsValidation" class="content">
                            <div class="content-header mb-3">
                                <h3 class="mb-1">Informasi Akun</h3>
                                <span>Masukkan Detail Akun Anda</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsName">Nama Lengkap</label>
                                    <input type="text" name="multiStepsName" id="multiStepsName" class="form-control" placeholder="Nama Saya, S.H., M.H." />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsUsername">Username</label>
                                    <input type="text" name="multiStepsUsername" id="multiStepsUsername" class="form-control" placeholder="namasaya" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsEmail">Email</label>
                                    <input type="email" name="multiStepsEmail" id="multiStepsEmail" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                                </div>
                                <div class="col-sm-6">
                                  <label class="form-label" for="multiStepsWhatsapp">Whatsapp</label>
                                  <input type="text" name="multiStepsWhatsapp" id="multiStepsWhatsapp" class="form-control" placeholder="08xxxxxxxxxx" />
                              </div>
                                <div class="col-sm-6 form-password-toggle">
                                    <label class="form-label" for="multiStepsPass">Kata Sandi</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="multiStepsPass" name="multiStepsPass" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsPass2" />
                                        <span class="input-group-text cursor-pointer" id="multiStepsPass2"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-password-toggle">
                                    <label class="form-label" for="multiStepsConfirmPass">Konfirmasi Kata Sandi</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="multiStepsConfirmPass" name="multiStepsConfirmPass" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsConfirmPass2" />
                                        <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                  <label class="form-label" for="multiStepsProvince">Provinsi</label>
                                  <select class="form-select" id="multiStepsProvince" name="multiStepsProvince">
                                      <option value="" selected disabled>Pilih Provinsi</option>
                                  </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsRegency">Kabupaten/Kota</label>
                                    <select class="form-select" id="multiStepsRegency" name="multiStepsRegency" disabled>
                                        <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                  <label class="form-label" for="multiStepsDistrict">Kecamatan</label>
                                  <select class="form-select" id="multiStepsDistrict" name="multiStepsDistrict" disabled>
                                      <option value="" selected disabled>Pilih Kecamatan</option>
                                  </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsVillage">Desa</label>
                                    <select class="form-select" id="multiStepsVillage" name="multiStepsVillage" disabled>
                                        <option value="" selected disabled>Pilih Desa</option>
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                  <label class="form-label" for="multiStepsProfileImage">Gambar Profil</label>
                                  <input type="file" required name="multiStepsProfileImage" id="multiStepsProfileImage" class="form-control" accept="image/*">
                                  <div id="imagePreview" class="mt-2"></div>
                                </div>
                              
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev" disabled>
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Berikutnya</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Office Info -->
                        <div id="officeInfoValidation" class="content">
                            <div class="content-header mb-3">
                                <h3 class="mb-1">Informasi Kantor</h3>
                                <span>Masukkan Detail Kantor Anda</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="officeName">Nama Kantor</label>
                                    <input type="text" id="officeName" name="officeName" class="form-control" placeholder="Nama Kantor" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="officeEmail">Email Kantor</label>
                                    <input type="email" id="officeEmail" name="officeEmail" class="form-control" placeholder="email.kantor@contoh.com" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="officePhone">HP / Whatsapp</label>                                  
                                    <input type="text" id="officePhone" name="officePhone" class="form-control" placeholder="08xxxxxxxxxx" />
                                </div>                                
                                <div class="col-sm-6">
                                    <label for="flatpickr-date" class="form-label">Tanggal Pendirian</label>
                                    <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="officeAddress">Nama Jalan</label>
                                    <input type="text" id="officeAddress" name="officeAddress" class="form-control" placeholder="Nama Jalan" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="postCode">Kode Pos</label>
                                    <input type="text" id="postCode" name="postCode" class="form-control" placeholder="12345" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="officeProvince">Provinsi</label>
                                    <select class="form-select" id="officeProvince" name="officeProvince">
                                        <option value="" selected disabled>Pilih Provinsi</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="officeRegency">Kabupaten/Kota</label>
                                    <select class="form-select" id="officeRegency" name="officeRegency" disabled>
                                        <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="officeDistrict">Kecamatan</label>
                                    <select class="form-select" id="officeDistrict" name="officeDistrict" disabled>
                                        <option value="" selected disabled>Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="officeVillage">Desa</label>
                                    <select class="form-select" id="officeVillage" name="officeVillage" disabled>
                                        <option value="" selected disabled>Pilih Desa</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="website">Website (opsional)</label>
                                    <input type="text" id="website" name="website" class="form-control" placeholder="kantorsaya.com" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="slogan">Slogan Kantor</label>
                                    <textarea id="slogan" name="slogan" class="form-control" placeholder="Konsisten Membela Klien"></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="logo">Logo Kantor</label>
                                    <input type="file" id="logo" name="logo" class="form-control" accept="image/*" required/>
                                    <div id="logoPreview"></div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="legalDocument">Dokumen Pendirian Kantor</label>
                                    <input type="file" id="legalDocument" name="legalDocument" class="form-control" accept="application/pdf,image/*" required/>
                                    <div id="legalDocumentPreview"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Berikutnya</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Billing Links -->
                        <div id="billingLinksValidation" class="content">
                            <div class="content-header mb-3">
                                <h3 class="mb-1">Pilih Paket</h3>
                                <span>Pilih paket sesuai kebutuhan Anda</span>
                            </div>
                            <!-- Opsi paket kustom -->
                            <div class="row gap-md-0 gap-3 mb-4">
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="basicOption">
                                            <span class="custom-option-body">
                                                <span class="mb-2 h4 d-block">Dasar</span>                                                
                                                <span class="d-flex justify-content-center">
                                                    <sup class="text-primary fs-big lh-1 mt-3">Rp</sup>
                                                    <span class="display-5 text-primary">0</span>
                                                    <sub class="lh-1 fs-big mt-auto mb-2 text-muted">/bulan</sub>
                                                </span>
                                            </span>
                                            <input name="customRadioIcon" class="form-check-input" type="radio" value="0" id="basicOption" checked/>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="standardOption">
                                            <span class="custom-option-body">
                                                <span class="mb-2 h4 d-block">Standar</span>
                                                <span class="d-flex justify-content-center">
                                                    <sup class="text-primary fs-big lh-1 mt-3">Rp</sup>
                                                    <span class="display-5 text-primary">50k</span>
                                                    <sub class="lh-1 fs-big mt-auto mb-2 text-muted">/bulan</sub>
                                                </span>
                                            </span>
                                            <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="standardOption" disabled />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="enterpriseOption">
                                            <span class="custom-option-body">
                                                <span class="mb-2 h4 d-block">Enterprise</span>                                                
                                                <span class="d-flex justify-content-center">
                                                    <sup class="text-primary fs-big lh-1 mt-3">Rp</sup>
                                                    <span class="display-5 text-primary">100k</span>
                                                    <sub class="lh-1 fs-big mt-auto mb-2 text-muted">/bulan</sub>
                                                </span>
                                            </span>
                                            <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="enterpriseOption" disabled />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--/ Opsi paket kustom -->
                            <div class="content-header mb-3">
                                <h3 class="mb-1">Perjanjian Kerja Sama</h3>    
                                <span>Perjanjian Dapat dilihat dengan menekan tombol di bawah</span>   
                                <br>                 
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalScrollable">Baca Perjanjian Kerjasama</button>
                            </div>                                                        
                            <div class="row gap-md-0 gap-3 mb-4">
                                <div class="col-md">
                                    <label class="form-check-label" for="setuju">
                                        <input type="checkbox" id="setuju" name="setuju" value="1" required class="form-check-input">
                                        Saya setuju dengan Perjanjian Kerja Sama di atas.
                                    </label>
                                </div>
                            </div>

                            <div class="row g-3">
                               
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                                    </button>
                                    <button type="submit" class="btn btn-success btn-next btn-submit">Kirim</button>
                                </div>
                            </div>
                            <!--/ Detail Kartu Kredit -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
      <!-- / Multi Steps Registration -->
    </div>
  </div>

  <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScrollableTitle">Perjanjian Kerja Sama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">              
                <p>
                    Antara: Bilik Hukum (selanjutnya disebut "Pihak Pertama") dan Pengguna (selanjutnya disebut "Pihak Kedua")
                </p>
                <p>
                    1. Tujuan Kerja Sama: <br>
                    Pihak Pertama dan Pihak Kedua setuju untuk menjalin kerja sama untuk menjalankan sebuah layanan hukum yang bermamfaat dan dibutuhkan oleh Calon Klien
                </p>              
                <p>
                    2. Lingkup Kerja Sama: <br>                    
                    Pihak Pertama akan melakukan promosi untuk mengarahkan calon klien kepada Pihak Kedua, termasuk namun tidak terbatas pada menyediakan informasi tentang layanan hukum yang ditawarkan oleh Pihak Kedua. <br>
                    Pihak Kedua akan memberikan informasi yang diperlukan secara akurat dan tepat waktu kepada Pihak Pertama untuk menjalankan tugas-tugas promosi yang diminta.
                </p>
                <p>
                    3. Kewajiban Pihak Pertama: <br>
                    Pihak Pertama setuju untuk: <br>
                </p>
                <ul>
                    <li>Pihak Pertama Menyediakan layanan promosi untuk Pihak Kedua kepada calon Klien yang membutuhkan layanan hukum.</li>
                    <li>Bentuk promosi yang disediakan oleh Pihak Pertama berupa layanan pencarian jasa bantuan hukum kepada calon Klien.</li>
                    <li>Calon Klien bebas memilih penyedia jasa layanan hukum yang dia inginkan.</li>          
                </ul>
                <p>
                    4. Kewajiban Pihak Kedua: <br>
                    Pihak Kedua setuju untuk: <br>
                </p>
                <ul>
                    <li>Menyediakan layanan yang berkualitas kepada klien.</li>
                    <li>Mengoptimalkan layanan agar tujuan yang ingin dicapai Klien tecapai.</li>
                    <li>Bersedia untuk membagi hasil yang didapat dari Fee Pengacara kepada bilikhukum.</li>
                </ul>
                <p>
                    5. Biaya dan Pembayaran: <br>
                    Jumlah bagi hasil pada umumnya sebesar 10% dari Fee Pengacara yang didapat dari klien. dan jumlah lainnya akan ditentukan di perjanjiannya
                </p>
                <p>
                    6. Kepatuhan Hukum: <br>
                    Kedua belah pihak setuju untuk mematuhi semua hukum dan peraturan yang berlaku yang berkaitan dengan kerja sama ini.
                </p>
                <p>
                    7. Durasi Perjanjian: <br>
                    Perjanjian ini berlaku efektif sejak tanggal penyetujuan dan berlaku sampai ada hal-hal yang membatalkan perjanjian.
                </p>
                <p>
                    8. Pembatalan Perjanjian: <br>
                    <ul>
                        <li>Perjanjian akan batal jika Pihak Pertama menerima laporan dari klien yang menerangkan Pihak Kedua melakukan:</li>
                        <ul>
                            <li>Penipuan</li>
                            <li>Tidak memenuhi kewajibannya</li>
                            <li>Pelanggaran Asusila</li>
                        </ul>
                        <li>Perjanjian akan batal jika Pihak Kedua tidak memenuhi kewajiban yang telah disepakti dengan Pihak Pertama</li>
                    </ul>
                </p>                
                <p>
                    9. Hukum yang Berlaku: <br>
                    Perjanjian ini tunduk pada hukum yang berlaku di Negara Republik Indonesia.
                </p>
                <p>
                    Sebagai bukti kesepakatan, Pihak Kedua akan mencentang kotak centang di bawah ini.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Close
                </button>           
            </div>
        </div>
    </div>
</div>

  
  <script>
    // Check selected custom option
    window.Helpers.initCustomOptionCheck();
  </script>
@endsection

@push('footer-script')      
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/moment/moment.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/pickr/pickr.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="{{ asset('portal_assets/assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
    <script src="{{ asset('portal_assets') }}/assets/js/pages-auth-multisteps.js"></script>
    <script src="{{ asset('portal_assets') }}/assets/js/forms-pickers.js"></script>    
    <script>
        $(document).ready(function() {
            var select2 = $('.select2');

            if (select2.length) {
                select2.each(function () {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>');
                    $this.select2({
                        placeholder: 'Select an option',
                        dropdownParent: $this.parent()
                    });
                });
            }

            $('#multiStepsProvince').select2({
                placeholder: 'Pilih Provinsi',
                allowClear: true,
                ajax: {
                    url: '{{ route("getProvinces") }}',
                    type: 'GET',
                    dataType: 'json',
                    processResults: function(data) {
                        var formattedData = data.map(function(province) {
                            var words = province.name.toLowerCase().split(' ');
                            for (var i = 0; i < words.length; i++) {
                                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
                            }
                            return {
                                id: province.code,
                                text: words.join(' ')
                            };
                        });
                        return {
                            results: formattedData
                        };
                    },
                    data: function (params) {
                        var query = {
                            search: params.term
                        }
                        return query;
                    }
                }
            });

            $('#multiStepsProvince').on('select2:select', function(e) {
                var provinceCode = e.params.data.id;
                $('#multiStepsRegency').val(null).trigger('change').prop('disabled', true);
                $('#multiStepsDistrict').val(null).trigger('change').prop('disabled', true);
                $('#multiStepsVillage').val(null).trigger('change').prop('disabled', true);
                if (provinceCode) {
                    $('#multiStepsRegency').select2({
                        placeholder: 'Pilih Kabupaten/Kota',
                        allowClear: true,
                        ajax: {
                            url: '{{ route("getRegencies") }}',
                            type: 'GET',
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    province_code: provinceCode,
                                    search: params.term
                                }
                                return query;
                            },
                            processResults: function(data) {
                                var formattedData = data.map(function(regency) {
                                    var words = regency.name.toLowerCase().split(' ');
                                    for (var i = 0; i < words.length; i++) {
                                        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
                                    }
                                    return {
                                        id: regency.code,
                                        text: words.join(' ')
                                    };
                                });
                                return {
                                    results: formattedData
                                };
                            }
                        }
                    }).prop('disabled', false);
                }
            });

            $('#multiStepsRegency').on('select2:select', function(e) {
                var regencyCode = e.params.data.id;
                $('#multiStepsDistrict').val(null).trigger('change').prop('disabled', true);
                $('#multiStepsVillage').val(null).trigger('change').prop('disabled', true);
                if (regencyCode) {
                    $('#multiStepsDistrict').select2({
                        placeholder: 'Pilih Kecamatan',
                        allowClear: true,
                        ajax: {
                            url: '{{ route("getDistricts") }}',
                            type: 'GET',
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    regency_code: regencyCode,
                                    search: params.term
                                }
                                return query;
                            },
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(district) {
                                        return {
                                            id: district.code,
                                            text: district.name
                                        };
                                    })
                                };
                            }
                        }
                    }).prop('disabled', false);
                }
            });

            $('#multiStepsDistrict').on('select2:select', function(e) {
                var districtCode = e.params.data.id;
                $('#multiStepsVillage').val(null).trigger('change').prop('disabled', true);
                if (districtCode) {
                    $('#multiStepsVillage').select2({
                        placeholder: 'Pilih Desa',
                        allowClear: true,
                        ajax: {
                            url: '{{ route("getVillages") }}',
                            type: 'GET',
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    district_code: districtCode,
                                    search: params.term
                                }
                                return query;
                            },
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(village) {
                                        return {
                                            id: village.code,
                                            text: village.name
                                        };
                                    })
                                };
                            }
                        }
                    }).prop('disabled', false);
                }
            });

            // Script for Office Select2 Dropdowns
            $('#officeProvince').select2({
                placeholder: 'Pilih Provinsi',
                allowClear: true,
                ajax: {
                    url: '{{ route("getProvinces") }}',
                    type: 'GET',
                    dataType: 'json',
                    processResults: function(data) {
                        var formattedData = data.map(function(province) {
                            var words = province.name.toLowerCase().split(' ');
                            for (var i = 0; i < words.length; i++) {
                                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
                            }
                            return {
                                id: province.code,
                                text: words.join(' ')
                            };
                        });
                        return {
                            results: formattedData
                        };
                    },
                    data: function (params) {
                        var query = {
                            search: params.term
                        }
                        return query;
                    }
                }
            });

            $('#officeProvince').on('select2:select', function(e) {
                var provinceCode = e.params.data.id;
                $('#officeRegency').val(null).trigger('change').prop('disabled', true);
                $('#officeDistrict').val(null).trigger('change').prop('disabled', true);
                $('#officeVillage').val(null).trigger('change').prop('disabled', true);
                if (provinceCode) {
                    $('#officeRegency').select2({
                        placeholder: 'Pilih Kabupaten/Kota',
                        allowClear: true,
                        ajax: {
                            url: '{{ route("getRegencies") }}',
                            type: 'GET',
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    province_code: provinceCode,
                                    search: params.term
                                }
                                return query;
                            },
                            processResults: function(data) {
                                var formattedData = data.map(function(regency) {
                                    var words = regency.name.toLowerCase().split(' ');
                                    for (var i = 0; i < words.length; i++) {
                                        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
                                    }
                                    return {
                                        id: regency.code,
                                        text: words.join(' ')
                                    };
                                });
                                return {
                                    results: formattedData
                                };
                            }
                        }
                    }).prop('disabled', false);
                }
            });

            $('#officeRegency').on('select2:select', function(e) {
                var regencyCode = e.params.data.id;
                $('#officeDistrict').val(null).trigger('change').prop('disabled', true);
                $('#officeVillage').val(null).trigger('change').prop('disabled', true);
                if (regencyCode) {
                    $('#officeDistrict').select2({
                        placeholder: 'Pilih Kecamatan',
                        allowClear: true,
                        ajax: {
                            url: '{{ route("getDistricts") }}',
                            type: 'GET',
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    regency_code: regencyCode,
                                    search: params.term
                                }
                                return query;
                            },
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(district) {
                                        return {
                                            id: district.code,
                                            text: district.name
                                        };
                                    })
                                };
                            }
                        }
                    }).prop('disabled', false);
                }
            });

            $('#officeDistrict').on('select2:select', function(e) {
                var districtCode = e.params.data.id;
                $('#officeVillage').val(null).trigger('change').prop('disabled', true);
                if (districtCode) {
                    $('#officeVillage').select2({
                        placeholder: 'Pilih Desa',
                        allowClear: true,
                        ajax: {
                            url: '{{ route("getVillages") }}',
                            type: 'GET',
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    district_code: districtCode,
                                    search: params.term
                                }
                                return query;
                            },
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(village) {
                                        return {
                                            id: village.code,
                                            text: village.name
                                        };
                                    })
                                };
                            }
                        }
                    }).prop('disabled', false);
                }
            });
        });


        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + previewId).html('<img src="' + e.target.result + '" class="img-fluid" style="max-height: 200px;" />');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Mengaktifkan event onchange pada input file
        $('#multiStepsProfileImage').change(function () {
            previewImage(this, 'imagePreview');
        });


      document.getElementById('multiStepsProfileImage').addEventListener('change', function() {
        var file = this.files[0];
        var imageType = /image.*/;

        if (file.type.match(imageType)) {
          if (file.size <= 2 * 1024 * 1024) { // Ukuran maksimum 2MB (2 * 1024 * 1024 bytes)
            var reader = new FileReader();
            reader.onload = function(e) {
              document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '" style="max-width: 100%; max-height: 200px;">';
            };
            reader.readAsDataURL(file);
          } else {
            alert('Ukuran gambar melebihi batas 2MB.');
            this.value = '';
          }
        } else {
          alert('Hanya file gambar yang diizinkan.');
          this.value = '';
        }
      });
    </script>
      
        
    <script>
        @if(session('response'))
            var response = @json(session('response'));
            showSweetAlert(response);
        @endif
    </script>  
@endpush