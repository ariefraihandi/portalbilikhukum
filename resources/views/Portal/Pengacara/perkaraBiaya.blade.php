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
                <a class="nav-link active" href="{{ route('lawyer.perkara')}}"><i class='bx bx-spreadsheet'></i></i> Perkara & Biaya</a>
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
                        <i class="bx bx-check"></i><span class="fw-medium mx-2">Status:</span> <span>  @if($office->status == 0)
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
        </div>
        <div class="col-xl-8 col-lg-7 col-md-7">
            <div class="card card-action mb-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <!-- Input Daftar Perkara -->
                            <form id="inputPerkaraForm" action="{{route('office.upperkara')}}" method="POST">
                                @csrf
                                <div class="row g-3 align-items-start">
                                    <!-- Kategori Perkara -->
                                    <div class="col-md-6">
                                        <label for="kategoriPerkara" class="form-label">Kategori Perkara</label>
                                        <select id="kategoriPerkara" name="kategori" class="form-select">
                                            <option value="" disabled selected>Pilih Kategori</option>
                                        </select>
                                    </div>
                                    <!-- Minimum Biaya -->
                                    <div class="col-md-5 col-lg-3">
                                        <label for="minBiaya" class="form-label">Min Biaya</label>
                                        <input type="text" id="minBiaya" name="min_biaya" class="form-control" placeholder="0" />
                                    </div>
                                    
                                    <!-- Maksimum Biaya -->
                                    <div class="col-md-5 col-lg-3">
                                        <label for="maxBiaya" class="form-label">Max Biaya</label>
                                        <input type="text" id="maxBiaya" name="max_biaya" class="form-control" placeholder="0" />
                                    </div>
                                </div>                                
                                <!-- Tombol Submit -->
                                <input type="hidden" id="office_id" name="office_id" value="{{$office->id}}" />
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Tambahkan Perkara</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-datatable table-responsive">
                            <table id="perkara-table" class="datatables table border-top">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Perkara</th>
                                        <th>Min Biaya</th>
                                        <th>Max Biaya</th>
                                        <th>Rata-Rata</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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

<script type="text/javascript">
    $(document).ready(function() {
        var officeId = "{{ $office->id }}";
        $('#perkara-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("/getdata/perkara") }}/' + officeId,
                type: 'GET',
                error: function(xhr, error, code) {
                    console.log('Error: ', error);
                    console.log('Code: ', code);
                    console.log('Response: ', xhr.responseText);
                }
            },
            columns: [
                { data: 'no', name: 'no', searchable: false, orderable: false },
                { data: 'perkara', name: 'perkara' },
                { data: 'min_biaya', name: 'min_biaya' },
                { data: 'max_biaya', name: 'max_biaya' },
                { data: 'rata_rata', name: 'rata_rata' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Function to show the SweetAlert edit form
        function showEditForm(id, perkara, minFee, maxFee) {
            Swal.fire({
                title: 'Edit Biaya Perkara: ' + perkara,
                html:
                    '<div class="form-group">' +
                    '<label for="swal-input1">Min Fee</label>' +
                    '<input id="swal-input1" class="swal2-input" placeholder="Min Fee" value="' + formatRupiah(minFee) + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="swal-input2">Max Fee</label>' +
                    '<input id="swal-input2" class="swal2-input" placeholder="Max Fee" value="' + formatRupiah(maxFee) + '">' +
                    '</div>',
                focusConfirm: false,
                didOpen: () => {
                    const minFeeInput = document.getElementById('swal-input1');
                    const maxFeeInput = document.getElementById('swal-input2');
                    minFeeInput.addEventListener('input', handleBiayaInput);
                    maxFeeInput.addEventListener('input', handleBiayaInput);
                },
                preConfirm: () => {
                    return [
                        parseNumber(document.getElementById('swal-input1').value),
                        parseNumber(document.getElementById('swal-input2').value)
                    ]
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let minFee = result.value[0];
                    let maxFee = result.value[1];
                    $.ajax({
                        url: '{{ url("/update/office-case") }}/' + id,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            min_fee: minFee,
                            max_fee: maxFee
                        },
                        success: function(response) {
                            showSweetAlert(response.response);
                            $('#perkara-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            showSweetAlert({
                                success: false,
                                title: 'Error',
                                message: 'There was an error updating the data.'
                            });
                        }
                    });
                }
            });
        }

        // Add event listener for edit buttons
        $('#perkara-table').on('click', '.edit', function() {
            var id = $(this).data('id');
            var perkara = $(this).data('perkara');
            var minFee = $(this).data('minfee');
            var maxFee = $(this).data('maxfee');
            showEditForm(id, perkara, minFee, maxFee);
        });

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

        function parseNumber(numberString) {
            return numberString.replace(/\./g, '');
        }
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