@extends('Portal.Index.app')

@push('head-script')     
     <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
     <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
     <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/page-faq.css" />    
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mt-4">    
        <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-3">
            <div class="d-flex justify-content-between flex-column mb-2 mb-md-0">
            <ul class="nav nav-align-left nav-pills flex-column">
                <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detil-kantor">
                    <i class="bx bxs-detail faq-nav-icon me-1"></i>
                    <span class="align-middle">Detil</span>
                </button>
                </li>
                <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#document-detil">
                    <i class="bx bxs-file-doc faq-nav-icon me-1"></i>
                    <span class="align-middle">Document</span>
                </button>
                </li>                
            </ul>
            <div class="d-none d-md-block">
                <div class="mt-5">
                <img
                    src="{{ asset('assets') }}/img/illustrations/sitting-girl-with-laptop-light.png"
                    class="img-fluid w-px-200"
                    alt="FAQ Image"
                    data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                    data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png" />
                </div>
            </div>
            </div>
        </div>
        <!-- /Navigation -->

        <!-- FAQ's -->
        <div class="col-lg-9 col-md-8 col-12">
            <div class="tab-content py-0">
                <div class="tab-pane fade show active" id="detil-kantor" role="tabpanel">
                    <div class="d-flex mb-3 gap-3">
                        <div>
                            <span class="badge bg-label-primary rounded-2">
                                <i class="bx bxs-detail bx-md"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">
                                <span class="align-middle">Detil Kantor</span>
                            </h4>
                            <span>Harap lakukan validasi nomor hp dan alamat kantor</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="officeName">Nama Kantor</label>
                                <input type="text" readonly name="officeName" id="officeName" class="form-control" value="{{$office->nama_kantor}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                
                            <div class="col-sm-6">
                                <label class="form-label" for="officeEmail">Email Kantor</label>
                                <input type="email" readonly name="officeEmail" id="officeEmail" class="form-control" value="{{$office->email_kantor}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                
                            <div class="col-sm-6">
                                <label class="form-label" for="officePhone">HP/WhatsApp</label>
                                <input type="text" readonly name="officePhone" id="officePhone" class="form-control" value="{{$office->hp_whatsapp}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                
                            <div class="col-sm-6">
                                <label class="form-label" for="officedesa">Alamat</label>
                                <input type="text" readonly name="officedesa" id="officedesa" class="form-control" value="{{$office->alamat}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                
                            <div class="col-sm-6">
                                <label class="form-label" for="postCode">Kode Pos</label>
                                <input type="text" readonly name="postCode" id="postCode" class="form-control" value="{{$office->kode_pos}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                
                            <div class="col-sm-6">
                                <label class="form-label" for="slogan">Slogan</label>
                                <input type="text" readonly name="slogan" id="slogan" class="form-control" value="{{$office->slogan}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                            @php
                                use Carbon\Carbon;
                                Carbon::setLocale('id');
                            @endphp
                            
                            <div class="col-sm-6">
                                <label for="tanggal-pendirian" class="form-label">Tanggal Pendirian</label>
                                <input type="text" class="form-control" readonly id="tanggal-pendirian" name="tanggal-pendirian" value="{{ Carbon::parse($office->tanggal_pendirian)->translatedFormat('d F Y') }}" />
                                <small class="error-message text-danger"></small>
                            </div>
                        
                            <div class="col-sm-6">
                                <label class="form-label" for="website">Website</label>
                                <input type="url" readonly name="website" id="website" class="form-control" value="{{$office->website}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                            
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsProvince">Provinsi</label>
                                <input type="text" readonly name="multiStepsProvince" id="multiStepsProvince" class="form-control" value="{{$office->province->name}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsRegency">Kabupaten/Kota</label>
                                <input type="text" readonly name="multiStepsRegency" id="multiStepsRegency" class="form-control" value="{{$office->regency->name}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsDistrict">Kecamatan</label>
                                <input type="text" readonly name="multiStepsDistrict" id="multiStepsDistrict" class="form-control" value="{{$office->district->name}}" />
                                <small class="error-message text-danger"></small>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="multiStepsVillage">Desa</label>
                                <input type="text" readonly name="multiStepsVillage" id="multiStepsVillage" class="form-control" value="{{$office->village->name}}" />
                                <small class="error-message text-danger"></small>
                            </div>                       
                        </div>              
                    </div>
                </div>
                
                <div class="tab-pane fade" id="document-detil" role="tabpanel">
                    <div class="d-flex mb-3 gap-3">
                        <div>
                            <span class="badge bg-label-primary rounded-2">
                                <i class="bx bxs-file-doc bx-md"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">
                                <span class="align-middle">Documents</span>
                            </h4>
                            <span>All office related documents</span>
                        </div>
                    </div>
                
                    <div id="accordionDocuments" class="accordion">
                        @foreach($officeDocuments as $index => $document)
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                        {{ $document->name }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionDocuments">
                                    <div class="accordion-body">
                                        <embed src="{{ asset('assets/img/office/document/' . $document->file) }}" type="application/pdf" width="100%" height="600px">
                                        <p>if Your browser does not support embedded PDFs. <a href="{{ asset('assets/img/office/document/' . $document->file) }}" target="_blank">Click here to download the PDF file.</a></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>   
            </div>
        </div>
    <!-- /FAQ's -->
    </div>

    <!-- Contact -->
    <div class="row mt-5 align-items-center">
        <div class="col-lg-12 mx-auto text-center">         
            <button type="button" class="btn btn-secondary " data-bs-toggle="modal" data-bs-target="#notVerified">Not Verified</button>
            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#verifiedModal">Verified</button>            
        </div>        
    </div>
</div>

<div class="modal fade" id="notVerified" tabindex="-1" aria-labelledby="notVerifiedLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notVerifiedLabel">Not Verified</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulir -->
                <form action="/submit-not-verified" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!-- Tambahkan kolom formulir lainnya sesuai kebutuhan -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- Tambahkan tombol-tombol tambahan jika diperlukan -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="verifiedModal" tabindex="-1" aria-labelledby="verifiedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifiedModalLabel">Ganti Link Document Sebelum Verifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm" method="POST" action="{{ route('bisnis.updateDoc') }}">
                    @csrf
                    @foreach($officeDocuments as $document)
                        <div class="mb-3 row">
                            <input type="hidden" name="documents[{{ $document->id }}][id]" value="{{ $document->id }}">
                            <div class="col-md-6">
                                <label for="documentName{{ $document->id }}" class="form-label">Name</label>
                                <input type="text" class="form-control" id="documentName{{ $document->id }}" name="documents[{{ $document->id }}][name]" value="{{ $document->name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="documentUrl{{ $document->id }}" class="form-label">Url</label>
                                <input type="text" class="form-control" id="documentUrl{{ $document->id }}" name="documents[{{ $document->id }}][url]" value="{{ old('documents.'.$document->id.'.url', $document->url) }}">
                            </div>
                            </div>
                            @endforeach
                            <input type="text" name="office_id" id="office_id" value="{{$office->id}}">
                            <input type="text" name="user_id" id="user_id" value="{{$office->user_id}}">
                            <input type="text" name="token" id="token" value="{{$token}}">
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')      
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush
@push('footer-Sec-script')
<script>
    function showDeleteConfirmation(url, message) {
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
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
  </script>
@endpush
