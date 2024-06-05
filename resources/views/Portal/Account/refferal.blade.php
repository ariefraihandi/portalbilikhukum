@extends('Portal.Index.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">eCommerce / </span> Referrals</h4>

    <div class="row mb-4 g-3">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
            <div class="content-left">
                <h3 class="mb-0">Rp. 234.242,-</h3>
                <small>Total Pendapatan</small>
            </div>
            <span class="badge bg-label-primary rounded-circle p-2">
                <i class="bx bx-dollar bx-sm"></i>
            </span>
            </div>
        </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
            <div class="content-left">
                <h3 class="mb-0">Rp. 39.000</h3>
                <small>Pembayaran Selanjutnya</small>
            </div>
            <span class="badge bg-label-success rounded-circle p-2">
                <i class="bx bx-gift bx-sm"></i>
            </span>
            </div>
        </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
            <div class="content-left">
                <h3 class="mb-0">2,367 Member</h3>
                <small>Refferal</small>
            </div>
            <span class="badge bg-label-danger rounded-circle p-2">
                <i class="bx bx-user bx-sm"></i>
            </span>
            </div>
        </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
            <div class="content-left">
                <h3 class="mb-0">Rp. 400.000,-</h3>
                <small>Pembayaran Tertunda</small>
            </div>
            <span class="badge bg-label-info rounded-circle p-2">
                <i class="bx bx-infinite bx-sm"></i>
            </span>
            </div>
        </div>
        </div>
    </div>
    </div>

    <div class="row mb-4 g-4">
    <div class="col-lg-7">
        <div class="card h-100">
        <div class="card-body">
            <h5 class="mb-1">Penggunaan</h5>
            <p class="mb-4">3 Langkah Mudah Menambah Pendapatan</p>
            <div class="d-flex flex-column flex-sm-row justify-content-between text-center gap-3">
            <div class="d-flex flex-column align-items-center">
                <span
                ><i 
                    class="bx bx-barcode-reader text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-2"></i
                ></span>
                <h5 class="text-primary mt-3 mb-2">Buat Link</h5>
                <p class="mb-0 w-75">Buat Link Undangan Untuk Disebarkan</p>
            </div>
            <div class="d-flex flex-column align-items-center">
                <span
                ><i
                    class="bx bxs-paper-plane text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-2"></i
                ></span>
                <h5 class="text-primary mt-3 mb-2">Share</h5>
                <p class="mb-0 w-75">Bagikan Tautan Melalui Berbagai Social Media</p>
            </div>
            <div class="d-flex flex-column align-items-center">
                <span
                ><i
                    class="bx bx-money text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-2"></i
                ></span>
                <h5 class="text-primary mt-3 mb-2">Hasilkan Uang</h5>
                <p class="mb-0 w-75">Dapatkan 10-30% Dari Member Anda</p>
            </div>
            </div>
        </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card h-100">
        <div class="card-body">
            <form class="referral-form">
            <div class="mb-4 mt-1">
                <h5>Buat Link Undangan</h5>
                <div class="d-flex flex-wrap flex-lg-nowrap gap-3 align-items-end">
                <div class="w-75">
                    <label class="form-label mb-0" for="referralEmail"
                    >Enter friend’s email address and invite them</label
                    >
                    <input
                    type="email"
                    id="referralEmail"
                    name="referralEmail"
                    class="form-control w-100"
                    placeholder="Email address" />
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </div>
            <div>
                <h5>Share the referral link</h5>
                <div class="d-flex flex-wrap flex-lg-nowrap gap-3 align-items-end">
                <div class="w-75">
                    <label class="form-label mb-0" for="referralLink"
                    >Share referral link in social media</label
                    >
                    <input
                    type="text"
                    id="referralLink"
                    name="referralLink"
                    class="form-control w-100"
                    placeholder="pixinvent.com/?ref=6479" />
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-facebook btn-icon me-2">
                    <i class="bx bxl-facebook text-white bx-sm"></i>
                    </button>
                    <button type="button" class="btn btn-twitter btn-icon">
                    <i class="bx bxl-twitter text-white bx-sm"></i>
                    </button>
                </div>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>

    <!-- Referral List Table -->
    <div class="card">
    <div class="card-datatable table-responsive">
        <table class="datatables-referral table border-top">
        <thead>
            <tr>
            <th></th>
            <th></th>
            <th>Users</th>
            <th class="text-nowrap">Referred ID</th>
            <th>Status</th>
            <th>Value</th>
            <th class="text-nowrap">Earnings</th>
            </tr>
        </thead>
        </table>
    </div>
    </div>
</div>
<!-- / Content -->
@endsection

@push('footer-script') 
            
    <script src="{{ asset('assets') }}/vendor/libs/moment/moment.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    @endpush

    @push('footer-Sec-script')
    <script src="{{ asset('assets') }}/js/app-ecommerce-referral.js"></script>
    @endpush
