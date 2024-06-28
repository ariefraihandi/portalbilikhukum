@extends('Portal.Index.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/@form-validation/umd/styles/index.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
                <span>Session</span>
                <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">21,459</h4>
                <small class="text-success">(+29%)</small>
                </div>
                <p class="mb-0">Total Users</p>
            </div>
            <div class="avatar">
                <span class="avatar-initial rounded bg-label-primary">
                <i class="bx bx-user bx-sm"></i>
                </span>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
                <span>Paid Users</span>
                <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">4,567</h4>
                <small class="text-success">(+18%)</small>
                </div>
                <p class="mb-0">Last week analytics</p>
            </div>
            <div class="avatar">
                <span class="avatar-initial rounded bg-label-danger">
                <i class="bx bx-user-check bx-sm"></i>
                </span>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
                <span>Active Users</span>
                <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">19,860</h4>
                <small class="text-danger">(-14%)</small>
                </div>
                <p class="mb-0">Last week analytics</p>
            </div>
            <div class="avatar">
                <span class="avatar-initial rounded bg-label-success">
                <i class="bx bx-group bx-sm"></i>
                </span>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
                <span>Pending Users</span>
                <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">237</h4>
                <small class="text-success">(+42%)</small>
                </div>
                <p class="mb-0">Last week analytics</p>
            </div>
            <div class="avatar">
                <span class="avatar-initial rounded bg-label-warning">
                <i class="bx bx-user-voice bx-sm"></i>
                </span>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4">
                  <label class="form-label">Type:</label>
                  <select class="form-select dt-input dt-type-filter" data-column="4" data-column-index="2">
                      <option value="">All</option>
                      <option value="1">PENGACARA</option>
                      <option value="2">NOTARIS</option>                      
                      <option value="3">MEDIATOR</option>                      
                  </select>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                  <label class="form-label">Status:</label>
                  <select class="form-select dt-input dt-status-filter" data-column="4" data-column-index="2">
                      <option value="">All</option>
                      <option value="LUNAS">LUNAS</option>
                      <option value="PANJAR">PANJAR</option>
                      <option value="BELUM BAYAR">BELUM BAYAR</option>
                      <option value="JATUH TEMPO">JATUH TEMPO</option>                      
                      <option value="DRAFT">DRAFT</option>                      
                  </select>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                  <label class="form-label">Date:</label>
                  <div class="mb-0">
                      <input
                          type="text"
                          class="form-control dt-date flatpickr-range dt-input"
                          data-column="6"
                          placeholder="StartDate to EndDate"
                          data-column-index="6"
                          name="dt_date" />
                      <input
                          type="hidden"
                          class="form-control dt-date start_date dt-input"
                          data-column="6"
                          data-column-index="6"
                          name="value_from_start_date" />
                      <input
                          type="hidden"
                          class="form-control dt-date end_date dt-input"
                          name="value_from_end_date"
                          data-column="6"
                          data-column-index="6" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>        
        <div class="card-datatable table-responsive">
          <table id="rule-table" class="table border-top">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Type ID</th>
                    <th>Name</th>
                    <th>Nomor</th>
                    <th>Tahun</th>
                    <th>Tentang</th>
                    <th>Bab</th>
                    <th>Tanggal Penetapan</th>
                    <th>Tanggal Pengundangan</th>
                    <th>Tanggal Berlaku</th>                   
                    <th>actions</th>                   
                </tr>
            </thead>
          </table>
        </div>
      </div>
</div>

<div class="modal fade" id="modalAddRuleBUndang" tabindex="-1" aria-labelledby="modalAddRuleBUndangLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddRuleBUndangLabel">Add Rule B Undang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addRuleBUndangForm" action="{{ route('store.rule') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="hidden" class="form-label">Select Type</label>
                        <select class="select2 form-select" id="type" name="type_id" data-allow-clear="true" required>
                            <option value="">Select a type</option>
                            @foreach($ruleATypes as $type)
                                <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor" class="form-label">Nomor</label>
                        <input type="text" class="form-control" id="nomor" name="nomor" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="tahun" name="tahun" required>
                    </div>
                    <div class="mb-3">
                        <label for="persetujuan" class="form-label">Persetujuan</label>
                        <input type="text" class="form-control" id="persetujuan" name="persetujuan" required>
                    </div>
                    <div class="mb-3">
                        <label for="tentang" class="form-label">Tentang</label>
                        <input type="text" class="form-control" id="tentang" name="tentang" required>
                    </div>
                    <div class="mb-3">
                        <label for="materi_pokok" class="form-label">Materi Pokok</label>
                        <textarea class="form-control" id="materi_pokok" name="materi_pokok" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="menimbang" class="form-label">Menimbang</label>
                        <textarea class="form-control" id="menimbang" name="menimbang" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="mengingat" class="form-label">Mengingat</label>
                        <textarea class="form-control" id="mengingat" name="mengingat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="mencabut" class="form-label">Mencabut</label>
                        <textarea class="form-control" id="mencabut" name="mencabut" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="menetapkan" class="form-label">Menetapkan</label>
                        <textarea class="form-control" id="menetapkan" name="menetapkan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="bab" class="form-label">Bab</label>
                        <input type="checkbox" class="form-check-input" id="bab" name="bab" value="1">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_penetapan" class="form-label">Tanggal Penetapan</label>
                        <input type="date" class="form-control" id="tanggal_penetapan" name="tanggal_penetapan" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pengundangan" class="form-label">Tanggal Pengundangan</label>
                        <input type="date" class="form-control" id="tanggal_pengundangan" name="tanggal_pengundangan" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_berlaku" class="form-label">Tanggal Berlaku</label>
                        <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal_berlaku" required>
                    </div>
                    <div class="mb-3">
                        <label for="sumber" class="form-label">Sumber</label>
                        <input type="text" class="form-control" id="sumber" name="sumber" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Rule</button>
                </form>
            </div>
        </div>            
    </div>
</div>


<!-- Modal for Add Bab -->
<div class="modal fade" id="addBabModal" tabindex="-1" aria-labelledby="addBabModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBabModalLabel">Tambah Bab Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBabForm" action="{{ route('storeBab') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="rule_b_undang_id" id="addBabRuleId">

                    <div class="mb-3">
                        <label for="babKe" class="form-label">Bab Ke</label>
                        <input type="text" class="form-control" id="babKe" name="bab_ke" required>
                    </div>

                    <div class="mb-3">
                        <label for="babName" class="form-label">Nama Bab</label>
                        <input type="text" class="form-control" id="babName" name="bab_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="addPasalModal" tabindex="-1" aria-labelledby="addPasalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPasalModalLabel">Tambah Pasal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPasalForm" action="{{ route('store.pasal') }}" method="POST">
                @csrf
                <input type="hidden" name="rule_b_undang_id" id="addPasalRuleId" value="">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="rule_c_bab_id">Pilih Bab</label>
                        <select class="form-control" name="rule_c_bab_id" id="rule_c_bab_id" required>
                            <option value="">Pilih Bab</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3" id="bagianSection" style="display: none;">
                        <label for="rule_ca_bagian_id">Pilih Bagian</label>
                        <select class="form-control" name="rule_ca_bagian_id" id="rule_ca_bagian_id">
                            <option value="">Pilih Bagian</option>
                        </select>
                    </div>

                    <!-- Input untuk Nomor Pasal -->
                    <div class="form-group mb-3">
                        <label for="pasal_number">Nomor Pasal</label>
                        <input type="text" class="form-control" id="pasal_number" name="pasal_number" placeholder="Masukkan Nomor Pasal" required>
                    </div>

                    <!-- Form untuk menambah pasal atau ayat -->
                    <div class="form-group mb-3">
                        <label for="pasal_content">Isi Pasal</label>
                        <textarea class="form-control" id="pasal_content" name="pasal_content" rows="4" required></textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="checkAyat">
                        <label class="form-check-label" for="checkAyat">Memiliki Ayat</label>
                    </div>

                    <!-- Bagian untuk ayat -->
                    <div id="ayatSection" style="display: none;">
                        <hr>
                        <label for="ayat_content">Ayat</label>
                        <div id="ayatInputs">
                            <div class="form-group mb-3 ayat-group" id="ayatGroup0">
                                <textarea class="form-control" name="ayat_content[0][]" rows="2" placeholder="Isi Ayat"></textarea>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="checkHuruf0" onchange="toggleHuruf(0)">
                                    <label class="form-check-label" for="checkHuruf0">Memiliki Huruf</label>
                                </div>
                                <div id="hurufSection0" class="hurufSection" style="display: none;">
                                    <hr>
                                    <label for="huruf_content">Huruf</label>
                                    <div id="hurufInputs0" class="hurufInputs">
                                        <div class="form-group mb-3">
                                            <textarea class="form-control" name="huruf_content[0][]" rows="2" placeholder="Isi Huruf"></textarea>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="checkAngka0_0" onchange="toggleAngka(0, 0)">
                                                <label class="form-check-label" for="checkAngka0_0">Memiliki Angka</label>
                                            </div>
                                            <div id="angkaSection0_0" class="angkaSection" style="display: none;">
                                                <hr>
                                                <label for="angka_content">Angka</label>
                                                <div class="angkaInputs" id="angkaInputs0_0">
                                                    <!-- Placeholder for angka inputs -->
                                                </div>
                                                <button type="button" class="btn btn-success btn-sm mb-2" onclick="addAngka(0, 0)">Tambah Angka</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="addHuruf(0)">Tambah Huruf</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm mb-2" onclick="addAyat()">Tambah Ayat</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Pasal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addBagianModal" tabindex="-1" aria-labelledby="addBagianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBagianModalLabel">Tambah Bagian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBagianForm" action="{{ route('store.bagian') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="rule_b_undang_id" id="addBagianRuleId"> <!-- Gunakan input hidden untuk rule_b_undang_id -->
                    <div class="mb-3">
                        <label for="rule_c_bab_id_bagian" class="form-label">Pilih Bab</label>
                        <select class="form-select" id="rule_c_bab_id_bagian" name="id_bab" required>
                            <option value="">Pilih Bab</option>
                            <!-- Options akan ditambahkan secara dinamis melalui JavaScript -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bagian_ke" class="form-label">Bagian Ke</label>
                        <input type="text" class="form-control" id="bagian_ke" name="bagian_ke" required>
                    </div>
                    <div class="mb-3">
                        <label for="bagian_name" class="form-label">Nama Bagian</label>
                        <input type="text" class="form-control" id="bagian_name" name="bagian_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Bagian</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('footer-script')   
    <script src="{{ asset('assets') }}/vendor/libs/moment/moment.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/cleavejs/cleave.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
    <script src="{{ asset('assets') }}/js/app-user-list.js"></script>

    <script>
        $(document).ready(function() {
            $('#rule-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('getRuleData') }}",
                columns: [
                    { data: 'no', name: 'no' },
                    { data: 'type_id', name: 'type_id' },
                    { data: 'name', name: 'name' },
                    { data: 'nomor', name: 'nomor' },
                    { data: 'tahun', name: 'tahun' },
                    { data: 'tentang', name: 'tentang' },
                    { data: 'bab', name: 'bab' },
                    { data: 'tanggal_penetapan', name: 'tanggal_penetapan' },
                    { data: 'tanggal_pengundangan', name: 'tanggal_pengundangan' },
                    { data: 'tanggal_berlaku', name: 'tanggal_berlaku' },
                    { data: 'actions', name: 'actions' }
                ],
                dom: '<"row mx-1"' +
                     '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-3"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
                     '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_type_filter mb-3 mb-md-0"><"invoice_status">>' +
                     '>t' +
                     '<"row mx-2"' +
                     '<"col-sm-12 col-md-6"i>' +
                     '<"col-sm-12 col-md-6"p>' +
                     '>',
                language: {
                    sLengthMenu: '_MENU_',
                    search: '',
                    searchPlaceholder: 'Search Rule'
                },
                buttons: [
                    {
                        text: '<i class="bx bx-plus me-md-1"></i><span class="d-md-inline-block d-none">Tambahkan Peraturan</span>',
                        className: 'btn btn-primary',
                        action: function (e, dt, button, config) {
                            // Tampilkan Modal
                            $('#modalAddRuleBUndang').modal('show');
                        }
                    }
                ]
            });
        });
    </script>
    
    

<script>
    // Open Add Bab Modal
    $(document).on('click', '.add-bab-button', function() {
        var id = $(this).data('id');
        $('#addBabRuleId').val(id); // Set rule_b_undang_id for form submission
        $('#addBabModal').modal('show'); // Show modal
    });

    // Open Edit Modal
    $(document).on('click', '.add-bagian-button', function() {
    var id = $(this).data('id');
    $('#addBagianRuleId').val(id); // Set rule_b_undang_id untuk pengiriman formulir

    // Fetch babs berdasarkan rule_b_undang_id
    $.ajax({
        url: `/babs/${id}`, // Sesuaikan dengan endpoint sesuai dengan rute aplikasi Anda
        method: 'GET',
        success: function(data) {
            $('#rule_c_bab_id_bagian').empty().append('<option value="">Pilih Bab</option>');
            data.forEach(function(bab) {
                $('#rule_c_bab_id_bagian').append(`<option value="${bab.id}">${bab.bab_name}-${bab.bab_ke}</option>`);
            });
            $('#addBagianModal').modal('show'); // Tampilkan modal setelah data diambil
        },
        error: function(xhr, status, error) {
            console.error('Error fetching babs:', error);
            // Tangani kesalahan jika diperlukan
        }
    });
});

</script>

<script>
    $(document).ready(function() {
        let ayatCounter = 1; // Counter for unique IDs

        // Handle modal show event to populate rule_b_undang_id and fetch babs
        $('#addPasalModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const ruleId = button.data('id');
            $('#addPasalRuleId').val(ruleId);

            // Fetch babs based on rule_b_undang_id
            $.ajax({
                url: `/babs/${ruleId}`,
                method: 'GET',
                success: function(data) {
                    $('#rule_c_bab_id').empty().append('<option value="">Pilih Bab</option>');
                    data.forEach(function(bab) {
                        $('#rule_c_bab_id').append(`<option value="${bab.id}">${bab.bab_name}-${bab.bab_ke}</option>`);
                    });
                }
            });
        });

        // Handle change event on rule_c_bab_id to fetch bagian if exists
        $('#rule_c_bab_id').change(function() {
            const babId = $(this).val();

            if (babId) {
                $.ajax({
                    url: `/bagian/${babId}`,
                    method: 'GET',
                    success: function(data) {
                        if (data.length > 0) {
                            $('#bagianSection').show();
                            $('#rule_ca_bagian_id').empty().append('<option value="">Pilih Bagian</option>');
                            data.forEach(function(bagian) {
                                $('#rule_ca_bagian_id').append(`<option value="${bagian.id}">${bagian.bagian_name}-${bagian.bagian_ke}</option>`);
                            });
                        } else {
                            $('#bagianSection').hide();
                        }
                    }
                });
            } else {
                $('#bagianSection').hide();
            }
        });

        // Toggle Ayat section
        $('#checkAyat').change(function() {
            if ($(this).is(':checked')) {
                $('#ayatSection').show();
            } else {
                $('#ayatSection').hide();
            }
        });

        // Function to add Ayat
        window.addAyat = function() {
            const ayatId = ayatCounter++;
            $('#ayatInputs').append(
                `<div class="form-group mb-3 ayat-group" id="ayatGroup${ayatId}">
                    <textarea class="form-control" name="ayat_content[${ayatId}][]" rows="2" placeholder="Isi Ayat Baru"></textarea>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="checkHuruf${ayatId}" onchange="toggleHuruf(${ayatId})">
                        <label class="form-check-label" for="checkHuruf${ayatId}">Memiliki Huruf</label>
                    </div>
                    <div id="hurufSection${ayatId}" class="hurufSection" style="display: none;">
                        <hr>
                        <label for="huruf_content">Huruf</label>
                        <div id="hurufInputs${ayatId}" class="hurufInputs">
                            <div class="form-group mb-3">
                                <textarea class="form-control" name="huruf_content[${ayatId}][]" rows="2" placeholder="Isi Huruf"></textarea>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="checkAngka${ayatId}_0" onchange="toggleAngka(${ayatId}, 0)">
                                    <label class="form-check-label" for="checkAngka${ayatId}_0">Memiliki Angka</label>
                                </div>
                                <div id="angkaSection${ayatId}_0" class="angkaSection" style="display: none;">
                                    <hr>
                                    <label for="angka_content">Angka</label>
                                    <div class="angkaInputs" id="angkaInputs${ayatId}_0">
                                        <!-- Placeholder for angka inputs -->
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="addAngka(${ayatId}, 0)">Tambah Angka</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm mb-2" onclick="addHuruf(${ayatId})">Tambah Huruf</button>
                    </div>
                </div>`
            );
        };

        // Function to toggle Huruf section
        window.toggleHuruf = function(counter) {
            $(`#hurufSection${counter}`).toggle();
        };

        // Function to toggle Angka section
        window.toggleAngka = function(ayatCounter, hurufCounter) {
            $(`#angkaSection${ayatCounter}_${hurufCounter}`).toggle();
        };

        // Function to add Huruf
        window.addHuruf = function(counter) {
    const hurufCounter = $(`#hurufInputs${counter} .form-group`).length;
    $(`#hurufInputs${counter}`).append(
        `<div class="form-group mb-3">
            <textarea class="form-control" name="huruf_content[${counter}][]" rows="2" placeholder="Isi Huruf Baru"></textarea>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="checkAngka${counter}_${hurufCounter}" onchange="toggleAngka(${counter}, ${hurufCounter})">
                <label class="form-check-label" for="checkAngka${counter}_${hurufCounter}">Memiliki Angka</label>
            </div>
            <div id="angkaSection${counter}_${hurufCounter}" class="angkaSection" style="display: none;">
                <hr>
                <label for="angka_content">Angka</label>
                <div class="angkaInputs" id="angkaInputs${counter}_${hurufCounter}">
                    <!-- Placeholder for angka inputs -->
                </div>
                <button type="button" class="btn btn-success btn-sm mb-2" onclick="addAngka(${counter}, ${hurufCounter})">Tambah Angka</button>
            </div>
        </div>`
    );
};

// Function to add Angka
window.addAngka = function(ayatCounter, hurufCounter) {
    const angkaIndex = $(`#angkaInputs${ayatCounter}_${hurufCounter} .form-group`).length;
    $(`#angkaInputs${ayatCounter}_${hurufCounter}`).append(
        `<div class="form-group mb-3">
            <textarea class="form-control" name="angka_content[${ayatCounter}][${hurufCounter}][]" rows="2" placeholder="Isi Angka Baru"></textarea>
        </div>`
    );
};
    });
</script>



    {{-- <script>
        $(document).ready(function() {
          var table = $('#rule-table').DataTable({
              processing: true,
              serverSide: true,
              searching: true,
              ajax: {
                  url: '{{ route("getAllOffice") }}',
                  type: 'GET',
                  data: function (d) {
                      // Ambil nilai filter dari elemen select
                      var typeFilter = $('.dt-type-filter').val();
                      var statusFilter = $('.dt-status-filter').val();
                      var startDate = $('.start_date').val();
                      var endDate = $('.end_date').val();
      
                      // Periksa apakah ada perubahan pada filter tipe atau status
                      var typeChanged = d.Type !== typeFilter;
                      var statusChanged = d.Status !== statusFilter;
                      var dateChanged = d.start_date !== startDate || d.end_date !== endDate;
      
                      // Hanya tambahkan filter ke permintaan jika nilai filter tidak kosong
                      if (typeFilter && (typeChanged || statusChanged || dateChanged)) {
                          d.Type = typeFilter;
                      }
                      if (statusFilter && (typeChanged || statusChanged || dateChanged)) {
                          d.Status = statusFilter;
                      }
                      if ((startDate || endDate) && (typeChanged || statusChanged || dateChanged)) {
                          d.start_date = startDate;
                          d.end_date = endDate;
                      }
                  }
              },
              columns: [
                  { data: 'no', name: 'no' },
                  { data: 'nama_kantor', name: 'nama_kantor' },
                  { data: 'alamat', name: 'alamat' },
                  { data: 'since', name: 'since' },
                  { data: 'klien', name: 'klien' },
                  { data: 'profit', name: 'profit' },
                  { data: 'status', name: 'status' },
                  { data: 'action', name: 'action' },
              ],
              dom: '<"row mx-1"' +
                    '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-3"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
                    '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_type_filter mb-3 mb-md-0"><"invoice_status">>' +
                    '>t' +
                    '<"row mx-2"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
              language: {
                  sLengthMenu: '_MENU_',
                  search: '',
                  searchPlaceholder: 'Search Office'
              },
              buttons: [
                  {
                      text: '<i class="bx bx-plus me-md-1"></i><span class="d-md-inline-block d-none">Tambahkan Peraturan</span>',
                      className: 'btn btn-primary',
                      action: function (e, dt, button, config) {
                          // Tampilkan Modal
                          $('#modalAddRuleBUndang').modal('show');
                      }
                  }
              ],
          });
      
          function filterTableByDate() {
              table.ajax.reload();
          }
      
          // Tangani perubahan pada filter tanggal
          $('.flatpickr-range').flatpickr({
              mode: 'range',
              dateFormat: 'Y-m-d',
              onClose: function (selectedDates) {
                  var startDate = '';
                  var endDate = '';
                  if (selectedDates.length > 1) {
                      startDate = moment(selectedDates[0]).format('YYYY-MM-DD');
                      endDate = moment(selectedDates[1]).format('YYYY-MM-DD');
                      startDate += ' 00:00:00';
                      endDate += ' 23:59:59';
                  }
                  $('.start_date').val(startDate);
                  $('.end_date').val(endDate);
                  filterTableByDate(); // Memanggil fungsi filter setelah rentang tanggal dipilih
      
                  console.log('Start Date:', startDate);
                  console.log('End Date:', endDate);
              }
          });
      
          $('.dt-type-filter, .dt-status-filter').on('change', function() {
              table.ajax.reload();
          });
        });
    </script> --}}

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
