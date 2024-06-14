@extends('Portal.Index.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
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
                <h3 class="mb-0">Rp. 0,-</h3>
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
                <h3 class="mb-0">Rp. 0</h3>
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
                <h3 class="mb-0">Member</h3>
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
                <h3 class="mb-0">Rp. 0,-</h3>
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
                    @if(!is_null($hasReferralCode))
                    <div class="mb-4 mt-1 text-center">
                        <span><i class="bx bx-money text-success bx-md p-3 border border-success rounded-circle border-dashed mb-2"></i></span>
                    </div>
                    
                    @endif
                    @if(is_null($hasReferralCode))
                        <div class="mb-4 mt-1">
                            <h5>Buat Link Undangan</h5>
                            <div class="d-grid gap-2 col-lg-12 mx-auto">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#referAndEarn">Generate Link</button>
                            </div>
                        </div>
                    @endif
                    
                    @if(is_null($hasReferralCode))
                    <div>
                        <h5>Ajukan Refferal Code</h5>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-3 align-items-end">
                            <div class="w-75">
                                <label class="form-label mb-0" for="referralLink">Ajukan refferal code</label>
                                <input
                                    type="text"
                                    id="referralLink"
                                    name="referralLink"
                                    class="form-control w-100"
                                    value="Daftar dan ajukan refferal code untuk memulai"
                                    readonly
                                />
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-primary btn-icon me-2">
                                    <i class="bx bx-copy text-white bx-sm"></i>
                                </button>
                                <a href="{{ route('refferal') }}" class="btn btn-success btn-icon">
                                    <i class="bx bx-user-plus text-white bx-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div>
                        <h5>Bagikan tautan undangan</h5>
                        <div class="d-flex flex-wrap flex-lg-nowrap gap-3 align-items-end">
                            <div class="w-75">
                                <label class="form-label mb-0" for="referralLink">Bagikan tautan undangan ini di social media</label>
                                <input
                                    type="text"
                                    id="referralLink"
                                    name="referralLink"
                                    class="form-control w-100"
                                    value="https://bilikhukum.com/join?token={{$hasReferralCode->code}}"
                                    readonly
                                />
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-primary btn-icon me-2" onclick="copyURLToClipboard()">
                                    <i class="bx bx-copy text-white bx-sm"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-icon" onclick="shareToWhatsApp('https://bilikhukum.com/join?token={{$hasReferralCode->code}}')">
                                    <i class="bx bxl-whatsapp text-white bx-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

       
                </div>
            </div>
        </div>
    </div>

    <!-- Referral List Table -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table  id="refferal-table" class="datatables-referral table border-top">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Member</th>
                    <th>Since</th>
                    <th>Status</th>
                    <th>Revanue</th>             
                </tr>
            </thead>
            </table>
        </div>
    </div>
</div>
<!-- / Content -->

<!-- Modal -->
    <div class="modal fade" id="referAndEarn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-refer-and-earn">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3>Refer & Earn</h3>
                    <p class="text-center mb-5 w-75 m-auto">
                    Undang teman anda untuk menjadi member di Bilikhukum.com dan hasilkan pendapatan tambahan
                    </p>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4 px-4">
                    <div class="d-flex justify-content-center mb-4">
                        <div class="modal-refer-and-earn-step bg-label-primary">
                        <i class="bx bx-detail"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5>Pelajari Aturan ⚖️</h5>
                    </div>
                    <div class="d-grid gap-2 col-lg-12 mx-auto">                    
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#twoFactorAuthOne">Baca Peraturan</button>
                    </div>                
                    </div>
                    <div class="col-12 col-lg-4 px-4">
                    <div class="d-flex justify-content-center mb-4">
                        <div class="modal-refer-and-earn-step bg-label-primary">
                        <i class="bx bxs-paper-plane"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5>Bagikan Tautan 🖖</h5>
                        <p class="mb-lg-0">Manfaatkan media social anda, Bagikan tautan</p>
                    </div>
                    </div>
                    <div class="col-12 col-lg-4 px-4">
                    <div class="d-flex justify-content-center mb-4">
                        <div class="modal-refer-and-earn-step bg-label-primary">
                        <i class="bx bx-money-withdraw"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5>Hasilkan Uang 💰</h5>
                        <p class="mb-0">Lakukan persiapan shoping untuk pasangan anda</p>
                    </div>
                    </div>
                </div>
                <hr class="my-5" />          
                    <form class="row g-3" method="POST" action="{{ route('refferal.generate') }}">
                        @csrf
                        <input type="hidden" name="agreed" id="agreed" value="1">
                        <button type="submit" class="btn btn-primary">Setujui & Buat Tautan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="twoFactorAuthOne" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-2">
                    <h3 class="mb-0">Peraturan Penggunaan Refferal Code</h3>
                </div>
                <h5 class="mb-2 pt-1 text-break">A. Sumber Pendapatan</h5>
                <ol>
                        <li>Member mendapatkan pendapatan dari:</li>
                        <ul>
                            <li>Penghasilan yang diperoleh Bilikhukum.com dari bagi hasil antara:</li>
                            <ul>
                                <li>Pengacara yang mendaftar dengan link Refferal member</li>
                                <li>Notaris yang mendaftar dengan link Refferal member</li>
                                <li>Pengacara yang mendaftar dengan link Refferal member</li>
                            </ul>
                            <li>Pembyaran biaya langganan member baru (Jika member baru menjadi member premium)<br>Berlaku disetiap renewal pembayaran</li>
                        </ul>
                        <li>Skema Pendapatan</li>
                    </ol>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>Jumlah</th>
                            <th>Bilikhukum (%)</th>
                            <th>Rekan (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td><= 10 juta</td>
                            <td>70%</td>
                            <td>30%</td>
                            </tr>
                            <tr>
                            <td><= 50 juta</td>
                            <td>75%</td>
                            <td>25%</td>
                            </tr>
                            <tr>
                            <td><= 100 juta</td>
                            <td>80%</td>
                            <td>20%</td>
                            </tr>
                            <tr>
                            <td>>= 101 juta</td>
                            <td>90%</td>
                            <td>10%</td>
                            </tr>
                            <tr>
                            <td>Member Premium</td>
                            <td>-</td>
                            <td>10%-30%</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <h5 class="mb-2 pt-1 text-break">B. Metode Pembayaran</h5>
                    <ol>
                        <li>Member yang dapat melakukan request pembayaran adalah member yang terverifikasi</li>
                        <li>Member dapat melakukan request pembayaran kapanpun.</li>
                        <li>Request pembayaran akan diproses pada tanggal 15 ke atas di setiap bulannya.</li>
                        <li>Proses Pembayaran akan dilakukan dalam periode tanggal 1 s.d 15 di setiap bulan.</li>
                    </ol> 
                    <h5 class="mb-2 pt-1 text-break">C. Pembatalan Pembayaran</h5>
                    <ol>
                        <li>Pembatalan pembayaran dapat diminta oleh member SEBELUM Periode proses pembayaran</li>
                        <li>Pembatalan pembayaran akan dilakukan oleh Bilikhukum jika dalam proses pengecekan transaksi terjadi kecurangan</li>                
                    </ol> 
                    <h5 class="mb-2 pt-1 text-break">D. Pemblokiran Akun</h5>
                    <ol>
                        <li>Pemblokiran akun dilakukan oleh Bilikhukum jika member melakukan kecurangan dan merugikan pihak lain</li>
                        <li>Akun yang sudah diblokir tidak dapat dipulihkan kembali.</li>                
                    </ol> 
                    <div class="divider">
                        <div class="divider-text">
                            <i class="bx bx-star"></i>
                        </div>
                    </div>
                    <div class="d-grid gap-2 col-lg-12 mx-auto">                    
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#referAndEarn"><i class="bx bx-right-arrow-alt bx-xs ms-2 scaleX-n1-rtl"></i></i><span class="align-middle">Setujui</span></button>
                    </div>   
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
  
@endsection

@push('footer-script')        
    <script src="{{ asset('assets') }}/vendor/libs/moment/moment.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
    {{-- <script src="{{ asset('assets') }}/js/app-ecommerce-referral.js"></script> --}}
    <script>
        function copyURLToClipboard() {
            var referralLink = document.getElementById("referralLink");
            referralLink.select();
            document.execCommand("copy");
            var response = {
                success: true, // Anda dapat menentukan apakah operasi berhasil atau tidak
                title: "Success", // Judul Sweet Alert
                message: "Tautan undangan berhasil disalin!" // Pesan Sweet Alert
            };
            showSweetAlert(response); // Panggil fungsi untuk menampilkan Sweet Alert
        }
    
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
        function shareToWhatsApp(url) {            
            window.open(`https://wa.me/?text=${encodeURIComponent(url)}`, '_blank');
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#refferal-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('getDataRefferal') !!}',
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'member', name: 'member' },
                    { data: 'since', name: 'since' },
                    { data: 'status', name: 'status' },            
                    { data: 'revenue', name: 'revenue' },                    
                ]
            });
        });
      </script>
@endpush
