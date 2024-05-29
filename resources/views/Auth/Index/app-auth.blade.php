<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets') }}/"
  data-template="vertical-menu-template">
  
    @include('Auth.Index.head')
    <body>
      @yield('content')
    </body>
    @include('Auth.Index.script')
</html>
