<!-- Start of header section
	============================================= -->
	<header id="header_id" class="main_header header_style_one">
		<div class="header_top">
			<div class="row">
				<div class="col-md-6">
					<div class="header_contact_info float-left ul-li">
						<ul>
							<li><i class="far fa-envelope"></i> admin@bilikhukum.com</li>
							<li><i class="fas fa-phone"></i> +62822 7662 4504</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6">
					<div class="header_follow_social float-right ul-li">
						<ul>
							<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#"><i class="fab fa-behance"></i></a></li>
							<li><a href="#"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#"><i class="fab fa-youtube"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- /header_top -->
		<div class="header_main_menu">
			<div class="site_logo">
				<a href="!#"><img src="{{ asset('assets/index/assets-index') }}/img/logo/logo-1.png" alt=""></a>
			</div>
			<nav class="main_navigation ul-li">
				<ul>
					<li class="dropdown">
						<a href="!#">Home</a>
						<ul class="dropdown-menu clearfix">
							<li><a href="index.html">Home Page 1</a></li>
							<li><a href="index-2.html">Home Page 2</a></li>
							<li><a href="index-3.html">Home Page 3</a></li>
						</ul>
					</li>
					<li><a href="#about">Tentang Kami</a></li>

					<li class="dropdown">
						<a href="#service">Layanan</a>
						<ul class="dropdown-menu clearfix">
							<li><a href="service.html">Service Page 1</a></li>
							<li><a href="practice.html">service Page 2</a></li>
							<li><a href="practice-single.html">service Details</a></li>
						</ul>
					</li>				
					{{-- <li class="dropdown">
						<a href="!#">Pages</a>
						<ul class="dropdown-menu clearfix">
							<li><a href="pricing.html">Pricing PAge</a></li>
							<li><a href="team.html">Team PAge</a></li>
							<li><a href="faq.html">Faq PAge</a></li>
						</ul>
					</li> --}}
					<li><a href="https://article.bilikhukum.com/">Article</a></li>
					<li><a href="contact.html">contact</a></li>
				</ul>
			</nav>
			<!-- /nav Menu -->
			<div class="wide_side_bar open_side_area clearfix">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div class="wide_side_inner">
				<div class="side_overlay open_side_area"></div>
				<div class="side_inner_content text-center">
					<div class="close_btn open_side_area">Back <i class="fas fa-arrow-right"></i></div>
					<div class="side_inner_logo">
						<a href="!#"><img src="{{ asset('assets/index/assets-index') }}/img/logo/logo-1.png" alt=""></a>
					</div>
					<p>
						Bilik Hukum adalah layanan yang memberikan edukasi hukum dan bantuan hukum. Kami didirikan pada bulan Desember 2023 dan sejak itu telah memberikan kontribusi signifikan dalam membantu mahasiswa dalam memahami bidang hukum, serta memberikan berbagai bentuk bantuan hukum kepada masyarakat secara luas.
					</p>
					<div class="side_contact">
						<div class="social_widget ul-li headline relative-position">
							<h3> Sign In:</h3>
							<ul>
								<li class="h-fb"><a href="{{route('login')}}"><i class="fa-solid fa-right-to-bracket"></i></a></li>								
							</ul>
						</div>
					</div>
					<div class="side_copywright">
						Copyright By @ BilikHukum.com
					</div>
				</div>
			</div>
			
			<!-- side bar Inner -->
			<div class="call_to_quote float-right">
				<div class="call_icon float-left">
					<i class="flaticon-call"></i>
				</div>
				<span>Free consultation</span>
				<span class="call_number">082276624504</span>
				<div class="icon_bg">
					<i class="flaticon-call"></i>
				</div>
			</div>
			<!-- /call to action -->
		</div>
		<!-- /desktop version -->
		<div class="mobile_menu">
			<div class="mobile_menu_button open_mobile_menu">
				<i class="fas fa-bars"></i>
			</div>
			<div class="mobile_menu_wrap">
				<div class="mobile_menu_overlay open_mobile_menu"></div>
				<div class="mobile_menu_content">
					<div class="mobile_menu_close open_mobile_menu">
						<i class="fas fa-window-close"></i>
					</div>
					<div class="m-brand-logo text-center">
						<img src="{{ asset('assets/index/assets-index') }}/img/logo/logo-1.png" alt="">
					</div>
					<nav class="main-navigation  clearfix ul-li">
						<ul id="main-nav" class="navbar-nav text-capitalize clearfix">
							<li class="dropdown">
								<a  href="#">
									Home
								</a>
								<ul class="dropdown-menu">
									<li><a href="index.html">Home Page 1</a></li>
									<li><a href="index-2.html">Home Page 2</a></li>
									<li><a href="index-3.html">Home Page 3</a></li>
								</ul>
							</li>
							<li><a href="#about">Tentang Kami</a></li>
							<li class="dropdown">
								<a  href="#">
									Case
								</a>
								<ul class="dropdown-menu">
									<li><a href="case.html">Case Page 1</a></li>
									<li><a href="case-2.html">Case Page 2</a></li>
									<li><a href="case-single.html">Case Details</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a  href="#">
									Practice
								</a>
								<ul class="dropdown-menu">
									<li><a href="practice.html">Practice Page 1</a></li>
									<li><a href="service.html">Practice Page 2</a></li>
									<li><a href="practice-single.html">Practice Details</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a  href="#">
									Team
								</a>
								<ul class="dropdown-menu">
									<li><a href="team.html">Team Page</a></li>
									<li><a href="team-single.html">Team Details</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a  href="#">
									Blog
								</a>
								<ul class="dropdown-menu">
									<li><a href="blog.html">Blog Page</a></li>
									<li><a href="blog-single.html">Blog Details</a></li>
								</ul>
							</li>
							{{-- <li class="dropdown">
								<a  href="#">
									Pages
								</a>
								<ul class="dropdown-menu">
									<li><a href="contact.html">Contact Page</a></li>
									<li><a href="faq.html">FAQ Page</a></li>
									<li><a href="pricing.html">Pricing Page</a></li>
								</ul>
							</li> --}}
						</ul>
					</nav>
					<div class="free_call_nm">
						<div class="m_call_icon text-center">
							<i class="flaticon-call"></i>
						</div>
						<div class="m_call_text">
							<span>FREE CONSULTATION</span>
							<strong>+62822 7662 4504</strong>
						</div>
					</div>
					<div class="m_social_area text-center ul-li">
						<h3> Follow Us On:</h3>
						<ul>
							<li class="m_fb"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li class="m_tw"><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li class="m_lk"><a href="#"><i class="fab fa-linkedin"></i></a></li>
							<li class="m_yb"><a href="#"><i class="fab fa-youtube"></i></a></li>
						</ul>
					</div>
					<div class="m_get_quote">
						<a href="#">Get A Quote</a>
					</div>
				</div>
			</div>
		</div>
		<!-- /mobile menu -->
	</header>
<!-- End of header section
	============================================= -->

<!-- Start of Slider section
	============================================= -->
	<section id="slider_area" class="slider_section relative-position">
        <div id="slider_id" class="slider_style_one owl-carousel relative-position">
            <div class="slider_priview" data-background="{{ asset('assets/index/assets-index') }}/img/slider/slider1.webp">
                <div class="background_overlay"></div>
                <div class="slider_contect_box text-center">
                    <div class="slider_icon">
                        <img src="{{ asset('assets/index/assets-index') }}/img/slider/s-icon.png" alt="">
                    </div>
                    <div class="slider_text headline pera-content">
                        <p>Tim Profesional yang Solid</p>
                        <h1>Penyelesaian Kasus Efektif.</h1>
                        <p>Percayakan masalah hukum Anda kepada tim ahli kami.</p>
                    </div>
                </div>
            </div>
            <div class="slider_priview" data-background="{{ asset('assets/index/assets-index') }}/img/slider/slider2.webp">
                <div class="background_overlay"></div>
                <div class="slider_contect_box text-center">
                    <div class="slider_icon">
                        <img src="{{ asset('assets/index/assets-index') }}/img/slider/s-icon.png" alt="">
                    </div>
                    <div class="slider_text headline pera-content">
                        <p>Solusi Hukum Terpercaya</p>
                        <h1>Menghadirkan Hasil Terbaik.</h1>
                        <p>Layanan hukum terbaik untuk perlindungan hak-hak Anda.</p>
                    </div>
                </div>
            </div>
            <div class="slider_priview" data-background="{{ asset('assets/index/assets-index') }}/img/slider/slider3.webp">
                <div class="background_overlay"></div>
                <div class="slider_contect_box text-center">
                    <div class="slider_icon">
                        <img src="{{ asset('assets/index/assets-index') }}/img/slider/s-icon.png" alt="">
                    </div>
                    <div class="slider_text headline pera-content">
                        <p>Pendekatan Hukum yang Inovatif</p>
                        <h1>Solusi Masalah Anda.</h1>
                        <p>Kami menggunakan strategi hukum terbaru untuk memastikan kemenangan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider_side_btn">
            <a class="block-display" href="#"><i class="fas fa-th"></i>Free Case Study</a>
        </div>
    </section>
    
<!-- ENd of Slider section
	============================================= -->