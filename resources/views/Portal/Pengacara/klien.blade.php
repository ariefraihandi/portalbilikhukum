@extends('Portal.Index.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/pages/page-profile.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">    
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Office / {{$title}} /</span> Klien</h4>

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

    <!-- Navbar pills -->
    <div class="row">
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
                        <a class="nav-link active" href="{{ route('lawyer.klien') }}">
                            <i class='bx bxs-user-detail'></i> Klien
                            @if($klienChatStatus0Count > 0)
                                <span class="badge badge-center rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 0.8rem;">{{ $klienChatStatus0Count }}</span>
                            @endif
                        </a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lawyer.website')}}"><i class='bx bx-link'></i></i> Website</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--/ Navbar pills -->

    @if(isset($klienChats) && $klienChats->isNotEmpty())
        <div class="row g-4">
            @foreach($klienChats as $klien)                
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-start">
                                <div class="me-2">
                                    <h5 class="mb-1">{{ $klien->name }}</h5>                        
                                    <h6 class="mb-1">Tanggal: <span class="text-body fw-normal">{{ \Carbon\Carbon::parse($klien->last_contacted_at)->translatedFormat('d F Y') }}</span></h6>
                                </div>
                                <div class="ms-auto">
                                    <div class="dropdown zindex-2">
                                        <button
                                            type="button"
                                            class="btn dropdown-toggle hide-arrow p-0"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="javascript:void(0);">Response</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $klien->keperluan }}</p>
                        </div>
                        <div class="card-body border-top">
                            @php
                                $statusText = '';
                                $badgeClass = '';
                                $progressPercentage = 0;

                                switch ($klien->status) {
                                    case 0:
                                        $statusText = 'Belum Diresponse';
                                        $badgeClass = 'bg-danger';
                                        $progressPercentage = 0;
                                        break;
                                    case 1:
                                        $statusText = 'Sudah Diresponse';
                                        $badgeClass = 'bg-primary';
                                        $progressPercentage = 20;
                                        break;
                                    case 2:
                                        $statusText = 'Sudah Ada Kesepakatan';
                                        $badgeClass = 'bg-primary';
                                        $progressPercentage = 40;
                                        break;
                                    case 3:
                                        $statusText = 'Dalam Proses Persidangan';
                                        $badgeClass = 'bg-label-info';
                                        $progressPercentage = 60;
                                        break;
                                    case 4:
                                        $statusText = 'Selesai';
                                        $badgeClass = 'bg-label-success';
                                        $progressPercentage = 100;
                                        break;
                                    case 5:
                                        $statusText = 'Batal/Tidak Ada Kelanjutan';
                                        $badgeClass = 'bg-label-secondary';
                                        $progressPercentage = 0;
                                        break;
                                    default:
                                        $statusText = 'Status Tidak Diketahui';
                                        $badgeClass = 'bg-label-warning';
                                        $progressPercentage = 0;
                                        break;
                                }
                            @endphp
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-1">Status:</h6>
                                <span class="badge {{ $badgeClass }} ms-auto">{{ $statusText }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small>Progres</small>
                                <small>{{ $progressPercentage }}% Completed</small>
                            </div>
                            <div class="progress mb-3" style="height: 8px">
                                <div
                                    class="progress-bar"
                                    role="progressbar"
                                    style="width: {{ $progressPercentage }}%"
                                    aria-valuenow="{{ $progressPercentage }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>                          
                        </div>
                    </div>
                </div>  
            @endforeach
        </div>
    @endif


    <div class="card mt-4">
        <div class="card-datatable table-responsive">
            <table id="klien-table" class="datatables-users table border-top">              
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Klien</th>                 
                        <th>Keperluan</th>                 
                        <th>Budget</th>                                                        
                        <th>Action</th>                   
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@foreach($klienChatsForStatus as $klien)
<div class="modal fade" id="updateStatusModal_{{ $klien->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel_{{ $klien->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel_{{ $klien->id }}">Update Status Klien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm_{{ $klien->id }}" action="{{ route('updateStatusKlien') }}" method="post">
                    @csrf
                    <input type="hidden" name="clientId" value="{{ $klien->id }}">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control status-select" id="status_{{ $klien->id }}" name="status" data-klien-id="{{ $klien->id }}">
                            <option value="0" {{ $klien->status == 0 ? 'selected' : '' }}>Belum Diresponse</option>
                            <option value="1" {{ $klien->status == 1 ? 'selected' : '' }}>Sudah Diresponse</option>
                            <option value="2" {{ $klien->status == 2 ? 'selected' : '' }}>Sudah Ada Kesepakatan</option>
                            <option value="3" {{ $klien->status == 3 ? 'selected' : '' }}>Dalam Proses Persidangan</option>
                            <option value="4" {{ $klien->status == 4 ? 'selected' : '' }}>Selesai</option>
                            <option value="5" {{ $klien->status == 5 ? 'selected' : '' }}>Batal/Tidak Ada Kelanjutan</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check budget-checkbox" id="budgetCheckContainer_{{ $klien->id }}" style="display: none;">
                        <input type="checkbox" class="form-check-input" id="budgetCheck_{{ $klien->id }}" name="budget_check">
                        <label class="form-check-label" for="budgetCheck_{{ $klien->id }}">Apakah Budget Sudah Ditentukan?</label>
                    </div>
                    <div class="mb-3 budget-input" id="budgetInputContainer_{{ $klien->id }}" style="display: none;">
                        <label for="budget_{{ $klien->id }}" class="form-label">Budget</label>
                        <input type="text" class="form-control budget-input-field" id="budget_{{ $klien->id }}" name="budget">
                    </div>
                    <div class="mb-3 perkara-input" id="perkaraInputContainer_{{ $klien->id }}" style="display: none;">
                        <label for="perkara_{{ $klien->id }}" class="form-label">Nomor Perkara</label>
                        <input type="text" class="form-control" id="perkara_{{ $klien->id }}" name="nomor_perkara">
                    </div>
                    <div class="mb-3 form-check budget-compare-checkbox" id="budgetCompareCheckContainer_{{ $klien->id }}" style="display: none;">
                        <input type="checkbox" class="form-check-input" id="budgetCompareCheck_{{ $klien->id }}" name="budget_compare_check" checked>
                        <label class="form-check-label" for="budgetCompareCheck_{{ $klien->id }}">Apakah Budget yang Ditetapkan Sama dengan Budget Saat Selesai?</label>
                    </div>
                    <div class="mb-3 new-budget-input" id="newBudgetInputContainer_{{ $klien->id }}" style="display: none;">
                        <label for="newBudget_{{ $klien->id }}" class="form-label">Budget Baru</label>
                        <input type="text" class="form-control new-budget-input-field" id="newBudget_{{ $klien->id }}" name="new_budget">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


@endsection

@push('footer-script')   
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#klien-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('getDataKlien') !!}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'keperluan', name: 'keperluan' },            
                { data: 'budget', name: 'budget' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var contactLink = '<a href="/hubungi/?id=' + row.id + '" class="text-body" title="Hubungi Klien">' +
                                          '<i class="bx bxs-phone mx-1"></i>' +
                                          '</a>';
                        var statusUpdateLink = '<a href="#" class="text-body" title="Update Status" data-bs-toggle="modal" data-id="' + row.id + '">' +
                                               '<i class="bx bxs-edit mx-1"></i>' +
                                               '</a>';
                        return '<div class="d-flex align-items-center">' +
                               contactLink +
                               statusUpdateLink +
                               '</div>';
                    }
                }
            ]
        });

        // Handle the status update modal trigger
        $('body').on('click', '[data-bs-toggle="modal"]', function(event) {
            var button = $(event.currentTarget);
            var id = button.data('id');
            $('#updateStatusModal_' + id).modal('show');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to reset input fields
        function resetInputs(klienId) {
            // Reset budget related fields
            document.getElementById('budgetCheckContainer_' + klienId).style.display = 'none';
            var budgetCheck = document.getElementById('budgetCheck_' + klienId);
            budgetCheck.checked = false;
            var budgetInputContainer = document.getElementById('budgetInputContainer_' + klienId);
            budgetInputContainer.style.display = 'none';
            document.getElementById('budget_' + klienId).value = '';

            // Reset perkara related fields
            var perkaraInputContainer = document.getElementById('perkaraInputContainer_' + klienId);
            perkaraInputContainer.style.display = 'none';
            document.getElementById('perkara_' + klienId).value = '';

            // Reset budget compare related fields
            var budgetCompareCheckContainer = document.getElementById('budgetCompareCheckContainer_' + klienId);
            budgetCompareCheckContainer.style.display = 'none';
            var budgetCompareCheck = document.getElementById('budgetCompareCheck_' + klienId);
            budgetCompareCheck.checked = true; // Set default to checked
            var newBudgetInputContainer = document.getElementById('newBudgetInputContainer_' + klienId);
            newBudgetInputContainer.style.display = 'none';
            document.getElementById('newBudget_' + klienId).value = '';
        }

        // Show or hide budget, perkara, and budget compare inputs based on status selection
        document.querySelectorAll('.status-select').forEach(function (select) {
            select.addEventListener('change', function () {
                var klienId = this.getAttribute('data-klien-id');

                // Reset all inputs first
                resetInputs(klienId);

                // Display relevant inputs based on the selected status
                if (this.value == '2') { // Sudah Ada Kesepakatan
                    document.getElementById('budgetCheckContainer_' + klienId).style.display = 'block';
                } else if (this.value == '3') { // Dalam Proses Persidangan
                    document.getElementById('perkaraInputContainer_' + klienId).style.display = 'block';
                } else if (this.value == '4') { // Selesai
                    document.getElementById('budgetCompareCheckContainer_' + klienId).style.display = 'block';
                }
            });
        });

        // Show budget input if budget checkbox is checked
        document.querySelectorAll('.budget-checkbox input').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var klienId = this.id.split('_')[1];
                var budgetInputContainer = document.getElementById('budgetInputContainer_' + klienId);

                if (this.checked) {
                    budgetInputContainer.style.display = 'block';
                } else {
                    budgetInputContainer.style.display = 'none';
                    document.getElementById('budget_' + klienId).value = '';
                }
            });
        });

        // Show new budget input if budget compare checkbox is unchecked
        document.querySelectorAll('.budget-compare-checkbox input').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var klienId = this.id.split('_')[1];
                var newBudgetInputContainer = document.getElementById('newBudgetInputContainer_' + klienId);

                if (this.checked) {
                    newBudgetInputContainer.style.display = 'none';
                    document.getElementById('newBudget_' + klienId).value = '';
                } else {
                    newBudgetInputContainer.style.display = 'block';
                }
            });
        });

        // Format budget input to number format
        document.querySelectorAll('.budget-input-field, .new-budget-input-field').forEach(function (input) {
            input.addEventListener('input', function () {
                var value = this.value.replace(/,/g, '');
                if (!isNaN(value) && value.length > 0) {
                    this.value = parseInt(value).toLocaleString('en-US');
                } else {
                    this.value = '';
                }
            });
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