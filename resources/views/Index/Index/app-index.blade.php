@include('Index.Index.head-index')

    <body>
        {{-- <div id="preloader"></div>
        <div class="up">
            <a href="#" class="scrollup text-center"><i class="fas fa-chevron-up"></i></a>
        </div> --}}

        @include('Index.Index.navbar-index')
            @yield('content')
        @include('Index.Index.footer-index')
                    
        @include('Index.Index.script-index')
    </body>
</html>