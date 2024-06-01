@extends('Auth/Index/app-auth')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/@form-validation/umd/styles/index.min.css" />    
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" />
@endpush

@section('content')
<div class="authentication-wrapper authentication-cover">
    <div class="authentication-inner row m-0">
        <!-- Image on Top -->
        
            
        
        <!-- /Image on Top -->
        
        <div class="col-12 d-flex align-items-center justify-content-center authentication-bg p-sm-5 p-3">
            <div class="w-px-700">
                <div class="shadow-none">
                    <div class="align-center" style="display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets') }}/img/illustrations/create-account-light.png" data-app-dark-img="illustrations/create-account-dark.png" data-app-light-img="illustrations/create-account-light.png" style="max-width: 100%; height: auto;" />            
                    </div>
                    
                    <form id="singleStepForm" method="POST" action="{{ route('registerMember') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Account Details -->
                        <div class="content">
                            <!-- Form fields for user details -->
                            <div class="row g-3">
                                <div class="divider">
                                    <div class="divider-text">Detil Pengguna</div>
                                </div>
                                <input type="text" name="url" id="url"  value="{{$url}}" />
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsName">Nama Lengkap</label>
                                    <input type="text" required name="multiStepsName" id="multiStepsName" class="form-control" placeholder="Nama Saya, S.H., M.H." />
                                    <small class="error-message text-danger"></small>
                                </div>
                                <!-- Username -->
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsUsername">Username</label>
                                    <input type="text" required name="multiStepsUsername" id="multiStepsUsername" class="form-control" placeholder="namasaya" />
                                    <small class="error-message text-danger"></small>
                                </div>
                                <!-- Email -->
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsEmail">Email</label>
                                    <input type="email" required name="multiStepsEmail" id="multiStepsEmail" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                                    <small class="error-message text-danger"></small>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsEmailVerify">Konfirmasi Email</label>
                                    <input type="email" required name="multiStepsEmailVerify" id="multiStepsEmailVerify" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                                    <small class="error-message text-danger"></small>
                                </div>
                                <!-- Whatsapp -->
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsWhatsapp">Whatsapp</label>
                                    <input type="text" required name="multiStepsWhatsapp" id="multiStepsWhatsapp" class="form-control" placeholder="08xxxxxxxxxx" />
                                    <small class="error-message text-danger"></small>
                                </div>
                                <div class="col-sm-6">
                                    <label for="dob" class="form-label">Tanggal Lahir</label>
                                    <input type="text" class="form-control" required placeholder="YYYY-MM-DD" id="flatpickr-date" name="dob" />
                                    <small class="error-message text-danger"></small>
                                </div>
                                <!-- Password -->
                                <div class="col-sm-6 form-password-toggle">
                                    <label class="form-label" for="multiStepsPass">Kata Sandi</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" required id="multiStepsPass" name="multiStepsPass" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsPass2" />
                                        <span class="input-group-text cursor-pointer" id="multiStepsPass2"><i class="bx bx-hide"></i></span>
                                    </div>
                                    <small class="error-message text-danger"></small>
                                </div>
                                <!-- Confirm Password -->
                                <div class="col-sm-6 form-password-toggle">
                                    <label class="form-label" for="multiStepsConfirmPass">Konfirmasi Kata Sandi</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" required id="multiStepsConfirmPass" name="multiStepsConfirmPass" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="multiStepsConfirmPass2" />
                                        <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"><i class="bx bx-hide"></i></span>
                                    </div>
                                    <small class="error-message text-danger"></small>
                                </div>
                                <!-- Provinsi -->
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsProvince">Provinsi</label>
                                    <select class="form-select" required id="multiStepsProvince" name="multiStepsProvince">
                                        <option value="" selected disabled>Pilih Provinsi</option>
                                    </select>
                                </div>
                                <!-- Kabupaten/Kota -->
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsRegency">Kabupaten/Kota</label>
                                    <select class="form-select" required id="multiStepsRegency" name="multiStepsRegency" disabled>
                                        <option value="" selected disabled>Pilih Kabupaten/Kota</option>
                                    </select>
                                </div>
                                <!-- Kecamatan -->
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsDistrict">Kecamatan</label>
                                    <select class="form-select" required id="multiStepsDistrict" name="multiStepsDistrict" disabled>
                                        <option value="" selected disabled>Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <!-- Desa -->
                                <div class="col-sm-6">
                                    <label class="form-label" for="multiStepsVillage">Desa</label>
                                    <select class="form-select" required id="multiStepsVillage" name="multiStepsVillage" disabled>
                                        <option value="" selected disabled>Pilih Desa</option>
                                    </select>
                                </div>
                                <!-- Gambar Profil -->
                                <div class="col-sm-12">
                                    <label class="form-label" for="multiStepsProfileImage">Gambar Profil</label>
                                    <input type="file" required name="multiStepsProfileImage" id="multiStepsProfileImage" class="form-control" accept="image/*">
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>
                            </div>                       
                            <div class="row g-3 mt-1">
                                <div class="col-12 d-flex justify-content-center align-items-center">
                                    <button type="submit" class="btn btn-success">Kirim</button>
                                </div>
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
    <script src="{{ asset('assets') }}/vendor/libs/moment/moment.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/pickr/pickr.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/cleavejs/cleave.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')    
    <script src="{{ asset('assets') }}/js/forms-pickers.js"></script>    
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
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('singleStepForm');
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    validateInput(input);
                });
            });

            function validateInput(input) {
                const errorMessage = input.nextElementSibling;
                let valid = true;

                if ((input.type === 'text' || input.type === 'email' || input.type === 'password') && input.value.trim() === '') {
                    errorMessage.textContent = 'Kolom ini tidak boleh kosong.';
                    valid = false;
                } else if (input.name === 'multiStepsName' || input.name === 'officeName') {
                    const nameRegex = /^[a-zA-Z.,' ]+$/; // Regex untuk nama
                    if (!nameRegex.test(input.value)) {
                        errorMessage.textContent = 'Nama hanya boleh terdiri dari huruf, titik, koma, dan spasi.';
                        valid = false;
                    } else if (input.value.length < 4 || input.value.length > 50) {
                        errorMessage.textContent = 'Nama harus terdiri dari 4 hingga 50 karakter.';
                        valid = false;
                    } else {
                        errorMessage.textContent = '';
                    }
                } else if (input.name === 'multiStepsUsername') {
                    const usernameRegex = /^[a-zA-Z0-9_]+$/; // Regex untuk username
                    if (!usernameRegex.test(input.value)) {
                        errorMessage.textContent = 'Username hanya boleh terdiri dari huruf (besar atau kecil), angka, dan garis bawah (_).';
                        valid = false;
                    } else if (input.value.length < 4 || input.value.length > 50) {
                        errorMessage.textContent = 'Panjang username harus antara 4 dan 50 karakter.';
                        valid = false;
                    } else {
                        errorMessage.textContent = '';
                    }
                } else if (input.name === 'multiStepsEmail') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex untuk email
                    if (!emailRegex.test(input.value)) {
                        errorMessage.textContent = 'Email tidak valid.';
                        valid = false;
                    } else {
                        errorMessage.textContent = '';
                    }
                } else if (input.name === 'multiStepsEmailVerify') {
                    const multiStepsEmail = document.getElementById('multiStepsEmail').value;
                    const multiStepsEmailVerify = document.getElementById('multiStepsEmailVerify').value;
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (multiStepsEmailVerify !== multiStepsEmail) {
                            errorMessage.textContent = 'Konfirmasi Email tidak cocok.';
                            valid = false;
                        } else {
                            errorMessage.textContent = '';
                            valid = true;
                        }
                } else if (input.id   === 'flatpickr-date') {
                    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
                    if (!dateRegex.test(input.value)) {
                        errorMessage.textContent = 'Format tanggal harus YYYY-MM-DD.';
                        valid = false;
                    }
                } else if (input.name === 'multiStepsPass' || input.name === 'multiStepsConfirmPass') {
                    const password = document.getElementById('multiStepsPass').value;
                    const confirmPassword = document.getElementById('multiStepsConfirmPass').value;

                    if (input.name === 'multiStepsPass') {
                        if (password.length < 6) {
                            errorMessage.textContent = 'Minimal 6 karakter.';
                            valid = false;
                        } else if (!/[A-Z]/.test(password)) {
                            errorMessage.textContent = 'Gunakan huruf kapital.';
                            valid = false;
                        } else if (!/\d/.test(password)) {
                            errorMessage.textContent = 'Gunakan angka.';
                            valid = false;
                        } else if (!/[!@#$%^&*()]/.test(password)) {
                            errorMessage.textContent = 'Gunakan simbol !@#$%^&*().';
                            valid = false;
                        } else {
                            errorMessage.textContent = '';
                            valid = true;
                        }
                    } else if (input.name === 'multiStepsConfirmPass') {
                        if (confirmPassword !== password) {
                            errorMessage.textContent = 'Konfirmasi kata sandi tidak cocok.';
                            valid = false;
                        } else {
                            errorMessage.textContent = '';
                            valid = true;
                        }
                    }
                } else {
                    errorMessage.textContent = '';
                }

                input.classList.toggle('is-invalid', !valid);
                input.classList.toggle('is-valid', valid);

                return valid;
            }
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