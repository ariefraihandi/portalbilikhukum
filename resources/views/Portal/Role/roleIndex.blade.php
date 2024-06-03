@extends('Portal.Index.app')

@push('head-script')
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/@form-validation/umd/styles/index.min.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Role / {{$title}}</h4>       
  <!-- Role cards -->
  <div class="row g-4">
    @foreach($roles as $role)
    <div class="col-xl-4 col-lg-6 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between mb-2">
            <h6 class="fw-normal">Total {{ $role->users->count() }} users</h6>
            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
              @foreach($role->users as $user)
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="{{ $user->name }}" class="avatar avatar-sm pull-up">
                  <img class="rounded-circle" src="{{ asset('assets/img/member/' . $user->image) }}" alt="Avatar" />
                </li>
              @endforeach
            </ul>
          </div>
          <div class="d-flex justify-content-between align-items-end">
            <div class="role-heading">
              <h4 class="mb-1">{{ $role->name }}</h4>
              <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal" class="role-edit-modal">
                  <small>Edit Role</small>
              </a>
            </div>                    
          </div>
        </div>
      </div>
    </div>
    @endforeach
    <div class="col-xl-4 col-lg-6 col-md-6">
      <div class="card h-100">
        <div class="row h-100">
          <div class="col-sm-5">
            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
              <img src="{{ asset('assets') }}/img/illustrations/sitting-girl-with-laptop-light.png" class="img-fluid" alt="Image" width="120" data-app-light-img="illustrations/sitting-girl-with-laptop-light.png" data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png" />
            </div>
          </div>
          <div class="col-sm-7">
            <div class="card-body text-sm-end text-center ps-sm-0">
              <button data-bs-target="#addRoleModal" data-bs-toggle="modal" class="btn btn-primary mb-3 text-nowrap add-new-role">
                  Tambah Role
              </button>
              <p class="mb-0">Add role, if it does not exist</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <!-- Role Table -->
      <div class="card">
        <div class="card-datatable table-responsive">
          <table class="datatables-users table border-top">
            <thead>
              <tr>
                <th></th>
                <th>User</th>
                <th>Role</th>
                <th>Plan</th>
                <th>Billing</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <!--/ Role Table -->
    </div>
  </div>
</div>
     
<!-- Add Role Modal -->
  <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-simple modal-dialog-centered">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3>Tambahkan Role Baru</h3>
          <br>
        </div>
        <!-- Add role form -->
        <form id="addRoleForm" class="row g-3" action="{{ route('roles.store') }}" method="POST">
          @csrf
          <div class="col-12 mb-4">
              <label class="form-label" for="modalRoleName">Role Name</label>
              <input
                  type="text"
                  id="modalRoleName"
                  name="modalRoleName"
                  class="form-control"
                  placeholder="Enter a role name"
                  tabindex="-1" />
          </div>
      
          <div class="col-12 text-center">
              <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
              <button
                  type="reset"
                  class="btn btn-label-secondary"
                  data-bs-dismiss="modal"
                  aria-label="Close">
                  Cancel
              </button>
          </div>
      </form>
      
        <!--/ Add role form -->
      </div>
    </div>
  </div>
  </div>
<!-- Add Role Modal -->
   
@endsection

@push('footer-script')            
<script src="{{ asset('assets') }}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endpush

@push('footer-Sec-script')
<script src="{{ asset('assets') }}/js/app-access-roles.js"></script>
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