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
          <table id="office-table" class="table border-top">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Office</th>
                    <th>Alamat</th>
                    <th>Since</th>
                    <th>klien</th>
                    <th>Profit</th>
                    <th>INVOICE STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
          </table>
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
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
@endpush

@push('footer-Sec-script')
    <script src="{{ asset('assets') }}/js/app-user-list.js"></script>
    <script>
        $(document).ready(function() {
          var table = $('#office-table').DataTable({
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
                      text: '<i class="bx bx-plus me-md-1"></i><span class="d-md-inline-block d-none">Create Invoice</span>',
                      className: 'btn btn-primary',
                      action: function (e, dt, button, config) {
                          // Tampilkan Modal
                          $('#createInvoiceModal').modal('show');
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
      </script>
@endpush
