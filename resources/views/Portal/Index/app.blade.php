<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets') }}/"
  data-template="vertical-menu-template">
 
@include('Portal.Index.head')

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('Portal.Index.sidebar')
            <div class="layout-page">
                @include('Portal.Index.navbar')
                <div class="content-wrapper">
                    @yield('content')
                    @include('Portal.Index.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
     
        <div class="layout-overlay layout-menu-toggle"></div>

        <div class="drag-target"></div>
    </div>
    @include('Portal.Index.script')
</body>

</html>
