@extends('Auth/Index/app-auth')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/@form-validation/umd/styles/index.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/page-auth.css" />
@endpush

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
            <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center">
                    <a href="index.html" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('assets/img/icons/icon.webp') }}" alt="Logo" width="100">
                        </span>                        
                    </a>
                </div>
                <!-- /Logo -->
                <div style="text-align: center;">
                    <p class="mb-2">Selamat Datang Di</p>
                    <h3 class="mb-4">Bilik Hukum ⚖️</h3>
                </div>
                <form id="formAuthentication" class="mb-3" action="index.html" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email or Username</label>
                    <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email-username"
                    placeholder="Enter your email or username"
                    autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <a href="auth-forgot-password-basic.html">
                        <small>Forgot Password?</small>
                    </a>
                    </div>
                    <div class="input-group input-group-merge">
                    <input
                        type="password"
                        id="password"
                        class="form-control"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
                </form>

                <p class="text-center">
                <span>Belum punya akun?</span>                
                    <a href="#" id="openModalDaftar">
                    <span>Daftar</span>
                </a>
                </p>
                </div>
            </div>
            </div>
            <!-- /Register -->
        </div>
        </div>
    </div>

    <!-- Create App Modal -->
    <div class="modal fade" id="createApp" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-simple modal-upgrade-plan">
          <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-2">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="rounded-top">
                        <h2 class="text-center mb-2 mt-0 mt-md-4 px-2">Pilih Jenis Pendaftaran</h2>
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
                                <a href="#" class="btn btn-label-success d-grid w-100">Mendaftar</a>
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
                                <a href="https://bilikhukum.com/pengacara/register" class="btn btn-label-success d-grid w-100" disabled>Mendaftar</a>
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
            <!--/ App Wizard -->
          </div>
        </div>
      </div>
      <!--/ Create App Modal -->
@endsection


@push('footer-script')  
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="{{ asset('portal_assets/assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
    <script src="{{ asset('assets') }}/js/pages-auth.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil elemen tautan "Daftar"
            var openModalDaftarLink = document.getElementById("openModalDaftar");
    
            // Ambil modal
            var createAppModal = document.getElementById("createApp");
    
            // Ketika pengguna mengklik tautan "Daftar"
            openModalDaftarLink.addEventListener("click", function(event) {
                // Hentikan aksi default dari tautan
                event.preventDefault();
    
                // Tampilkan modal
                createAppModal.classList.add("show");
                createAppModal.style.display = "block";
            });
    
            // Tambahkan event listener untuk tombol close modal jika diperlukan
            var closeModalButton = document.querySelector("#createApp .btn-close");
            closeModalButton.addEventListener("click", function() {
                createAppModal.classList.remove("show");
                createAppModal.style.display = "none";
            });
        });
    </script>
    
    <script>
        @if(session('response'))
            var response = @json(session('response'));
            showSweetAlert(response);
        @endif
    </script>  
@endpush
