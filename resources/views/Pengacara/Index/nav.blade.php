<nav class="site-nav">
    <div class="container">
      <div class="menu-bg-wrap">
        <div class="site-navigation">
          <a href="index.html" class="logo m-0 float-start">{{$data['title'];}}</a>

          <ul
            class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end"
          >
            <li class="active"><a href="{{ route('index.index') }}">Home</a></li>
            <li><a href="{{ route('index.index') }}#about">Tentang Kami</a></li>
            <li class="has-children">
              <a href="#">Layanan</a>
              <ul class="dropdown">
                <li><a href="/pengacara">Cari Pengacara</a></li>
                <li><a href="#">Cari Notaris</a></li>                
                <li><a href="#">Cari Mediator</a></li>                
              </ul>
            </li>            
            <li><a href="contact.html">Hubungi Kami</a></li>
            <li><a href="{{ route('join') }}/?token=3wnY0chj" class="btn btn-primary">Bergabung Bersama Kami</a></li>
          </ul>

          <a
            href="#"
            class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none"
            data-toggle="collapse"
            data-target="#main-navbar"
          >
            <span></span>
          </a>
        </div>
      </div>
    </div>
  </nav>