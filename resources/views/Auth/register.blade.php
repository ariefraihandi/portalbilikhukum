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
        
        <div class="col-12 d-flex align-items-center justify-content-center authentication-bg p-sm-5 p-3">
            <div class="w-px-700">
                <div class="shadow-none">
                    <div class="align-center" style="display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('assets') }}/img/illustrations/create-account-light.png" data-app-dark-img="illustrations/create-account-dark.png" data-app-light-img="illustrations/create-account-light.png" style="max-width: 100%; height: auto;" />            
                    </div>
                </div>
            </div>
        </div>           
        <section class="section-py first-section-pt">
            <div class="container">
                <h2 class="text-center mb-2">Pilih Jenis Pendaftaran</h2>     
                <br>                                            
                <div class="row mx-0 gy-3 px-lg-5">
                <!-- Basic -->
                <div class="col-lg mb-md-0 mb-4">
                    <div class="card border rounded shadow-none">
                    <div class="card-body">
                        <div class="my-3 pt-2 text-center">
                        <img
                        src="{{ asset('assets') }}/img/icons/unicons/mediator.png"
                        alt="Starter Image"
                        height="80" />
                        </div>
                        <h3 class="card-title text-center text-capitalize mb-1">Mediator</h3>
                        <p class="text-center">Mendaftar sebagai mediator</p>                               
                        <a href="{{ route('showRegisterMediator') }}" class="btn btn-label-success d-grid w-100">Mendaftar</a>
                    </div>
                    </div>
                </div>
        
                <!-- Pro -->
                <div class="col-lg mb-md-0 mb-4">
                    <div class="card border-primary border shadow-none">
                    <div class="card-body position-relative">
                        <div class="position-absolute end-0 me-4 top-0 mt-4">
                        <span class="badge bg-label-primary">Popular</span>
                        </div>
                        <div class="my-3 pt-2 text-center">
                        <img
                        src="{{ asset('assets') }}/img/icons/unicons/lawyer.png"
                        alt="Pro Image"
                        height="80" />
                        </div>
                        <h3 class="card-title text-center text-capitalize mb-1">Pengacara</h3>
                        <p class="text-center">Mendaftar sebagai pengacara</p>
                        <a href="{{ route('showRegisterPengacara') }}" class="btn btn-label-success d-grid w-100">Mendaftar</a>
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
        </section>
    </div>
</div>
@endsection

@push('footer-script')      
    <script src="{{ asset('assets') }}/vendor/libs/moment/moment.js"></script>
    
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