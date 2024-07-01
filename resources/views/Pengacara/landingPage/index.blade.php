<!DOCTYPE html>
<html lang="zxx">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>{{$nama_kantor}} - {{$slogan}} || Bilik Hukum</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/office') }}/site/{{$icon_image}}" type="image/x-icon">
    
    <!-- Flaticon -->
    <link rel="stylesheet" href="{{ asset('assets/index/landingPage') }}/index/landingPage') }}/css/flaticon.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/index/landingPage') }}/css/fontawesome-5.14.0.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/index/landingPage') }}/css/bootstrap.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('assets/index/landingPage') }}/css/magnific-popup.min.css">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('assets/index/landingPage') }}/css/nice-select.min.css">
    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('assets/index/landingPage') }}/css/animate.min.css">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('assets/index/landingPage') }}/css/slick.min.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('assets/index/landingPage') }}/css/style.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.css" /> 
</head>
<body class="home-one">
    <div class="page-wrapper">

        <!-- Preloader -->
        <div class="preloader"></div>

        <!-- main header -->
        <header class="main-header menu-absolute">
            <!--Header-Upper-->
            <div class="header-upper">
                <div class="container container-1620 clearfix">

                    <div class="header-inner rel d-flex align-items-center">
                        <div class="logo-outer">
                            <img src="{{ asset('assets/img/office/site/' . $logo_image) }}" alt="Logo" title="Logo" style="max-height: 120px;">
                        </div>

                        <div class="nav-outer clearfix mx-auto">
                            <!-- Main Menu -->
                            <nav class="main-menu navbar-expand-lg">
                                <div class="navbar-header">
                                   <div class="mobile-logo my-15">
                                       <a href="{{ url('/pengacara') }}{{ $website }}">
                                            <img src="{{ asset('assets/img/office') }}/site/{{$logo_image}}" alt="Logo" title="Logo">
                                       </a>
                                   </div>
                                   
                                    <!-- Toggle Button -->
                                    <button type="button" class="navbar-toggle me-4" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>

                                <div class="navbar-collapse collapse clearfix">
                                    <ul class="navigation onepage clearfix">
                                        <li><a href="#home">Home</a></li>
                                        <li><a href="#about">Tentang kami</a></li>                                 
                                        <li><a href="#perkara">Perkara Kami</a></li>
                                    
                                        @if($officeGalleries->isNotEmpty())
                                            <li><a href="#gallery">Gallery</a></li>
                                        @endif
                                        <li><a href="#member">Member</a></li>
                                        
                                    </ul>
                                </div>

                            </nav>
                            <!-- Main Menu End-->
                        </div>
                        
                        <!-- Menu Button -->
                        <div class="menu-btns">
                            <!-- menu sidbar -->
                            <div class="menu-sidebar">
                                <button>
                                    <img src="{{ asset('assets/index/landingPage') }}/images/shape/sidebar-tottler.svg" alt="Toggler">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Header Upper-->
        </header>
       
       
        <!--Form Back Drop-->
        <div class="form-back-drop"></div>
        
        <!-- Hidden Sidebar -->
        <section class="hidden-bar" id="hidden-bar">
            <div class="inner-box text-center">
                <div class="cross-icon"><span class="fa fa-times" id="close-sidebar"></span></div>
                <div class="title">
                    <p class="mb-0">Hubungi Kantor Pengacara</p>
                    <h4>{{$nama_kantor}}</h4>
                </div>

                <!-- Appointment Form -->
                <div class="appointment-form">
                    <form action="{{ route('klienchat.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name"  placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" value="" placeholder="Alamat Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="whatsapp"  placeholder="Whatsapp" required>
                        </div>
                        <div class="form-group">
                            <textarea name="keperluan" rows="3"  placeholder="Keperluan"></textarea>
                        </div>
                        <div class="form-group">
                            {!! htmlFormSnippet() !!}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="theme-btn">Hubungi Kami</button>
                        </div>

                        <input type="hidden" name="office_id"  value="{{$id}}" required>
                    </form>
                </div>
                <!-- Social Icons -->
                <div class="social-style-one">
                    <a href="https://www.facebook.com/profile.php?id=61558597477236"><i class="fab fa-twitter"></i></a>
                    <a href="https://x.com/bilikhukum"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/bilik.hukum/"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/in/bilik-hukum-772554315/"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </section>
       
        
        <!-- Hero Section Start -->
        <section id="home" class="main-hero-area pt-150 pb-80 rel z-1">
            <div class="container container-1620">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-sm-7">
                        <div class="hero-content rmb-55 wow fadeInUp delay-0-2s">
                            <span class="h2">
                                @if($type == 1)
                                    Pengacara
                                @elseif($type == 2)
                                    Notaris
                                @elseif($type == 3)
                                    Mediator
                                @else
                                    Unknown
                                @endif
                            </span>
                            <h1><b>{{$nama_kantor}}</b></h1>
                            <p>{{$slogan}}</p>
                            <div class="hero-btns">
                                <a href="#" class="theme-btn hire-me-btn">Hubungi Kami <i class="far fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-5 order-lg-3">
                        <div class="hero-counter-wrap ms-lg-auto rmb-55 wow fadeInUp delay-0-4s">
                            <div class="counter-item counter-text-wrap">
                                <span class="count-text plus" data-speed="3000" data-stop="{{$yearsOfExperience}}">0</span>
                                <span class="counter-title">Tahun Berpengalaman</span>
                            </div>
                            <div class="counter-item counter-text-wrap">
                                <span class="count-text plus" data-speed="3000" data-stop="{{ $klien_chat_count }}">0</span>
                                <span class="counter-title">Klien Yang Ditangani</span>
                            </div>                            
                            <div class="counter-item counter-text-wrap">
                                <span class="count-text percent" data-speed="3000" data-stop="99">0</span>
                                <span class="counter-title">Kepuasan Klien</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="author-image-part wow fadeIn delay-0-3s">
                            <div class="bg-circle"></div>
                            <img src="{{ asset('assets/img/office') }}/site/{{$owner_image}}" alt="Author" style="width: 500px;">
                            <div class="progress-shape">
                                <img src="{{ asset('assets/index/landingPage') }}/images/hero/progress-shape.png" alt="Progress">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-lines">
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
            </div>
        </section>
        <!-- Hero Section End -->
        
        
        <!-- About Area start -->
        <section id="about" class="about-area rel z-1">
            <div class="for-bgc-black py-130 rpy-100">
                <div class="container">
                    <div class="row gap-100 align-items-center">
                        <div class="col-lg-7">
                            <div class="about-content-part rel z-2 rmb-55">
                                <div class="section-title mb-25 wow fadeInUp delay-0-2s">
                                    <span class="sub-title mb-15">Tentang Kami</span>
                                    <h2><span>{{$aboutMe_title}}</span></h2>
                                    <p>{{$aboutMe_description}}</p>
                                </div>
                                <ul class="list-style-one two-column wow fadeInUp delay-0-2s mb-35">
                                    @foreach($legalCasesRandomized as $case)
                                        <li>{{ $case->kategori }}</li>
                                    @endforeach
                                </ul>
                                <div class="content">               
                                    <a href="#" class="theme-btn hire-me-btn">Hubungi Kami <i class="far fa-angle-right"></i></a>                                                                 
                                </div>                              
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="about-image-part wow fadeInUp delay-0-3s">
                                <img src="{{ asset('assets/img/office/site/') }}/{{$owner_sec_image}}" alt="About Me">
                                <div class="about-btn btn-one wow fadeInRight delay-0-4s">
                                    <img src="{{ asset('assets/index/landingPage') }}/images/about/btn-image1.png" alt="Image">
                                    <h6>{{$tagline}}</h6>
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div class="about-btn btn-two wow fadeInRight delay-0-5s">
                                    <img src="{{ asset('assets/img/office/site/') }}/{{$icon_image}}" alt="Image" width="40" height="40">
                                    <h6>{{$nama_kantor}}</h6>
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div class="dot-shape">
                                    <img src="{{ asset('assets/index/landingPage') }}/images/shape/about-dot.png" alt="Shape">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-lines">
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
            </div>
        </section>
        <!-- About Area end -->     
        
        
        <!-- Services Area start -->
        <section id="perkara" class="services-area pt-130 rpt-100 pb-100 rpb-70 rel z-1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="section-title text-center mb-60 wow fadeInUp delay-0-2s">
                            <span class="sub-title mb-15">Keahlian Kami</span>
                            <h2>Beberapa <span>Perkara </span>Yang Kami Tangani</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($services as $index => $service)
                        <div class="col-lg-6">
                            <div class="service-item wow fadeInUp delay-0-2s">
                                <div class="number">{{ sprintf('%02d', $index + 1) }}.</div>
                                <div class="content">
                                    <h4>{{ $service->name }}</h4>
                                    <p>{{ Str::limit($service->kategori, 100) }}</p>
                                </div>
                                <a href="#" class="details-btn hire-me-btn"><i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-lines">
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
            </div>
        </section>
        <!-- Services Area end -->
        
        
       
        
        
        <!-- Projects Area start -->
        @if($officeGalleries->isNotEmpty())
        <section id="gallery" class="projects-area pt-130 rpt-100 pb-100 rpb-70 rel z-1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="section-title text-center mb-60 wow fadeInUp delay-0-2s">
                            <span class="sub-title mb-15">Gallery</span>
                            <h2>Jelajahi <span>Gallery</span> Kami</h2>
                        </div>
                    </div>
                </div>
        
                @foreach($officeGalleries->chunk(2) as $chunk)
                <div class="row align-items-center pb-25">
                    @foreach($chunk as $key => $gallery)
                    <div class="col-lg-6 {{ $key % 2 == 1 ? 'order-lg-2' : '' }}">
                        <div class="project-image wow fadeInLeft delay-0-2s">
                            <img src="{{ asset('assets/img/office/site') . '/' . $gallery->image_file }}" alt="Project">
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 {{ $key % 2 == 1 ? 'ms-auto' : '' }}">
                        <div class="project-content wow fadeInRight delay-0-2s">
                            <span class="sub-title">{{ $gallery->short_title }}</span>
                            <h2><a href="#" class="hire-me-btn">{{ $gallery->title }}</a></h2>
                            <p>{{ $gallery->description }}</p>
                            <a href="#" class="details-btn hire-me-btn"><i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
        
            </div>
        </section>
        @endif
        
        <!-- Projects Area end -->
        
        
        <!-- Testimonial Area start -->
        {{-- <section class="testimonials-area rel z-1">
            <div class="for-bgc-black py-130 rpy-100">
                <div class="container">
                    <div class="row gap-90">
                        <div class="col-lg-4">
                            <div class="testimonials-content-part rel z-2 rmb-55 wow fadeInUp delay-0-2s">
                                <div class="section-title mb-40">
                                    <span class="sub-title mb-15">Clients Testimonials</span>
                                    <h2>I’ve 1253+ Clients <span>Feedback</span></h2>
                                    <p>Sed ut perspiciatis unde omnin natus totam rem aperiam eaque inventore veritatis</p>
                                </div>
                                <div class="slider-arrows">
                                    <button class="testimonial-prev"><i class="fal fa-arrow-left"></i></button>
                                    <button class="testimonial-next"><i class="fal fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="testimonials-wrap">
                                <div class="testimonial-item wow fadeInUp delay-0-3s">
                                    <div class="author">
                                        <img src="{{ asset('assets/index/landingPage') }}/images/testimonials/author1.png" alt="Author">
                                    </div>
                                    <div class="text">At vero eoset accusamus et iusto odio dignissimos ducimus quie blanditiis praesentium voluptatum deleniti atque corrupti dolores</div>
                                    <div class="testi-des">
                                        <h5>Rodolfo E. Shannon</h5>
                                        <span>CEO & Founder</span>
                                    </div>
                                </div>
                                <div class="testimonial-item wow fadeInUp delay-0-4s">
                                    <div class="author">
                                        <img src="{{ asset('assets/index/landingPage') }}/images/testimonials/author2.png" alt="Author">
                                    </div>
                                    <div class="text">Nam libero tempore cumsoluta nobise est eligendi optio cumque nihil impedit quominus idquod maxime placeat facere possimus</div>
                                    <div class="testi-des">
                                        <h5>Kenneth J. Dutton</h5>
                                        <span>Web Developer</span>
                                    </div>
                                </div>
                                <div class="testimonial-item wow fadeInUp delay-0-2s">
                                    <div class="author">
                                        <img src="{{ asset('assets/index/landingPage') }}/images/testimonials/author1.png" alt="Author">
                                    </div>
                                    <div class="text">At vero eoset accusamus et iusto odio dignissimos ducimus quie blanditiis praesentium voluptatum deleniti atque corrupti dolores</div>
                                    <div class="testi-des">
                                        <h5>Rodolfo E. Shannon</h5>
                                        <span>CEO & Founder</span>
                                    </div>
                                </div>
                                <div class="testimonial-item wow fadeInUp delay-0-2s">
                                    <div class="author">
                                        <img src="{{ asset('assets/index/landingPage') }}/images/testimonials/author2.png" alt="Author">
                                    </div>
                                    <div class="text">Nam libero tempore cumsoluta nobise est eligendi optio cumque nihil impedit quominus idquod maxime placeat facere possimus</div>
                                    <div class="testi-des">
                                        <h5>Kenneth J. Dutton</h5>
                                        <span>Web Developer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-lines">
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
            </div>
        </section> --}}
        <!-- Testimonial Area end -->        
        
        <!-- Blog Area start -->
        <section id="member" class="blog-area rel z-1">
            <div class="for-bgc-black pt-130 pb-100 rpt-100 rpb-70">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="section-title text-center mb-60 wow fadeInUp delay-0-2s">
                                <span class="sub-title mb-15">Anggota</span>
                                <h2>Tim Kami yang Andal dan Kompak di <span>{{$nama_kantor}}</span></h2>
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($officeMembers as $member)
                        <div class="col-lg-6">
                            <div class="blog-item wow fadeInUp delay-0-2s">
                                <div class="image">
                                    <img src="{{ asset('assets/img/member/' . $member->user->image) }}" alt="User Image" title="User Image" style="max-width: 290px; max-height: 330px;">
                                </div>
                                <div class="content">
                                    <div class="blog-meta mb-35">
                                        <a class="tag" href="#" class="hire-me-btn">{{ $member->level }}</a>
                                    </div>
                                    <h5><a href="#" class="hire-me-btn">{{ $member->user->name }}</a></h5>
                                    <hr>
                                    <div class="blog-meta mt-35">
                                        <a class="date hire-me-btn" href="#"><i class="fas fa-user-alt"></i> {{ $nama_kantor }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="bg-lines">
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
               <span></span><span></span>
            </div>
        </section>
        <!-- Blog Area end -->
        
        <!-- footer area start -->
        <footer class="main-footer rel z-1">
            <div class="footer-top-wrap bgc-black pt-100 pb-75">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-md-12">
                            <div class="footer-widget widget_logo wow fadeInUp delay-0-2s">
                                <div class="footer-logo">
                                    <a href="{{ url('/pengacara') }}{{ $website }}"><img src="{{ asset('assets/img/office') }}/site/{{$logo_image}}" alt="Logo" style="max-height: 83px;"></a>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7">
                            <div class="footer-widget widget_nav_menu wow fadeInUp delay-0-4s">
                                <h6 class="footer-title">Quick Link</h6>
                                <ul>                                  
                                    <li><a href="#home">Home</a></li>
                                    <li><a href="#about">Tentang kami</a></li>                                 
                                    <li><a href="#perkara">Perkara Kami</a></li>
                                
                                    @if($officeGalleries->isNotEmpty())
                                        <li><a href="#gallery">Gallery</a></li>
                                    @endif
                                    <li><a href="#member">Member</a></li>
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5">
                            <div class="footer-widget widget_contact_info wow fadeInUp delay-0-6s">
                                <h6 class="footer-title">Alamat</h6>
                                <ul>
                                    <li><i class="far fa-map-marker-alt"></i> {{$alamat}}, {{$desa}}, {{$kecamatan}}, {{$kabupaten_kota}} {{$provinsi}}, {{$kode_pos}}</li>                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom pt-20 pb-5 rpt-25">
                <div class="container">
                   <div class="row">
                       <div class="col-lg-6">
                        <div class="copyright-text">
                            <p>Copyright &copy; 2023 - {{ date('Y') }}, <a href="https://bilikhukum.com">Bilik Hukum</a> All Rights Reserved</p>
                        </div>
                        
                       </div>
                       <div class="col-lg-6 text-lg-end">
                           <ul class="footer-bottom-nav">
                               <li><a href="https://www.facebook.com/profile.php?id=61558597477236">Facebook</a></li>
                               <li><a href="https://x.com/bilikhukum">Twitter</a></li>
                               <li><a href="https://www.instagram.com/bilik.hukum/">Instagram</a></li>
                               <li><a href="https://www.linkedin.com/in/bilik-hukum-772554315/">LinkedIn</a></li>
                           </ul>
                       </div>
                   </div>
                   <!-- Scroll Top Button -->
                    <button class="scroll-top scroll-to-target" data-target="html"><span class="fas fa-angle-double-up"></span></button>
                </div>
                <div class="bg-lines">
                   <span></span><span></span>
                   <span></span><span></span>
                   <span></span><span></span>
                   <span></span><span></span>
                   <span></span><span></span>
                </div>
            </div>
        </footer>
        <!-- footer area end -->

    </div>
    <!--End pagewrapper-->    
    <!-- Jquery -->
    <script src="{{ asset('assets/index/landingPage') }}/js/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/index/landingPage') }}/js/bootstrap.min.js"></script>
    <!-- Appear Js -->
    <script src="{{ asset('assets/index/landingPage') }}/js/appear.min.js"></script>
    <!-- Slick -->
    <script src="{{ asset('assets/index/landingPage') }}/js/slick.min.js"></script>
    <!-- Nice Select -->
    <script src="{{ asset('assets/index/landingPage') }}/js/jquery.nice-select.min.js"></script>
    <!-- Image Loader -->
    <script src="{{ asset('assets/index/landingPage') }}/js/imagesloaded.pkgd.min.js"></script>
    <!-- Isotope -->
    <script src="{{ asset('assets/index/landingPage') }}/js/isotope.pkgd.min.js"></script>
    <!--  WOW Animation -->
    <script src="{{ asset('assets/index/landingPage') }}/js/wow.min.js"></script>
    <!-- Custom script -->
    <script src="{{ asset('assets/index/landingPage') }}/js/script.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/sweetalert2/sweetalert2.js"></script>
    
    <!-- For Contact Form -->
    <script src="{{ asset('assets/index/landingPage') }}/js/jquery.ajaxchimp.min.js"></script>
    <script src="{{ asset('assets/index/landingPage') }}/js/form-validator.min.js"></script>
    <script src="{{ asset('assets/index/landingPage') }}/js/contact-form-script.js"></script>
   
    <script>
        $(document).ready(function(){
            $('.hire-me-btn').on('click', function(e){
                e.preventDefault();
                $('body').toggleClass('side-content-visible');
            });
            
            $('#close-sidebar').on('click', function(){
                $('body').removeClass('side-content-visible');
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
</body>
</html>