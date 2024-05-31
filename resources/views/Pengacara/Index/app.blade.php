@include('Pengacara.Index.head')

<body>
    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
          <span class="icofont-close js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>

    @include('Pengacara.Index.nav')
        @yield('content')
        @include('Pengacara.Index.footer')
                 
    @include('Pengacara.Index.script')
</body>

</html>
