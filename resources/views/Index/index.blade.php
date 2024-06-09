@extends('Index/Index/app-index')
@section('content')
    <section id="call_action" class="call_action_Section">
        <div class="call_action_list clearfix ul-li">
            <ul>
                <li>
                    <div class="call_action_icon">
                        <i class="flaticon-employee"></i>
                    </div>
                    <div class="call_action_text headline pera-content">
                        <p>Temui</p>
                        <h3>Ahli Kami</h3>
                    </div>
                    <div class="c-icon_bg text-center">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </li>
                <!-- /call-action -->
                <li>
                    <div class="call_action_icon">
                        <i class="flaticon-save-money"></i>
                    </div>
                    <div class="call_action_text headline pera-content">
                        <p>Hemat Biaya</p>
                        <h3>Biaya Rendah</h3>
                    </div>
                    <div class="c-icon_bg text-center">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </li>
                <!-- /call-action -->
                <li>
                    <div class="call_action_icon">
                        <i class="flaticon-quote"></i>
                    </div>
                    <div class="call_action_text headline pera-content">
                        <p>Konsultasi Gratis</p>
                        <h3>Evaluasi</h3>
                    </div>
                    <div class="c-icon_bg text-center">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </li>
                <!-- /call-action -->
                <li>
                    <div class="call_action_icon">
                        <i class="flaticon-bargain"></i>
                    </div>
                    <div class="call_action_text headline pera-content">
                        <p>Harga & Paket</p>
                        <h3>Penawaran</h3>
                    </div>
                    <div class="c-icon_bg text-center">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </li>
                <!-- /call-action -->
                <li>
                    <div class="call_action_icon">
                        <i class="flaticon-schedule"></i>
                    </div>
                    <div class="call_action_text headline pera-content">
                        <p>Buat</p>
                        <h3>Janji</h3>
                    </div>
                    <div class="c-icon_bg text-center">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </li>
            </ul>
        </div>
    </section>

	<section id="about" class="about_us_section">
		<div class="container">
			<div class="about_area_content">
				<div class="row">
					<div class="col-lg-6 col-md-12">
						<div class="about_left_content">
							<div class="section_title_area headline pera-content">
								<p>
									<span class="title_shape_left"></span>
									tentang kami
								</p>
								<h2>
									Kenapa harus
									BilikHukum.com
								</h2>
							</div>
							<div class="about_area_text">
								<div class="about_top_text">Memiliki relasi dengan Pengacara, Notaris dan Mediator terbaik di seluruh <strong>Indonesia</strong> yang terkoneksi dalam satu sistem <span>Satu Pintu.</span></div>
								<div class="about_details_text">
									"Bilik Hukum adalah layanan yang memberikan edukasi hukum dan bantuan hukum. Kami didirikan pada bulan Desember 2023 dan sejak itu telah memberikan kontribusi signifikan dalam membantu mahasiswa dalam memahami bidang hukum, serta memberikan berbagai bentuk bantuan hukum kepada masyarakat secara luas.
								</div>
								<div class="about_listitem clearfix ul-li">								
                                    <ul>
                                        <li><i class="fas fa-check"></i> Mudah digunakan</li>
                                        <li><i class="fas fa-check"></i> Terkoneksi dengan banyak pengacara, notaris, dan mediator di seluruh Indonesia</li>
                                        <li><i class="fas fa-check"></i> Dukungan 24/7</li>
                                        <li><i class="fas fa-check"></i> Pendekatan yang ramah dan profesional</li>
                                        <li><i class="fas fa-check"></i> Konsultasi gratis</li>
                                        <li><i class="fas fa-check"></i> Teknologi terkini untuk kemudahan akses</li>
                                    </ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="about_right_content relative-position">
							<div class="about_right_img">
								<img src="{{ asset('assets/index/assets-index') }}/img/about/abr.webp" alt="">
							</div>
							<div class="about_progress" data-tilt data-tilt-max="20">
								<div class="first progress_area float-left"><strong><span>%</span></strong></div>
								<div class="progress_text headline">
									<h3>Konsultasi Gratis</h3>
									<p>Persentase kami meresponse.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="service" class="service_section">
        <div class="container">
            <div class="section_title_area text-center headline pera-content">
                <p>
                    <span class="title_shape_left"></span>
                    Layanan
                    <span class="title_shape_right"></span>
                </p>
                <h2>
                    Area Praktik Kami
                </h2>
            </div>
            <div class="service_area">
                <div id="service_slide" class="service_slider owl-carousel">
                    <div class="service_img_text wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="service_img relative-position">
                            <img src="{{ asset('assets/index/assets-index') }}/img/service/sr2.jpg" alt="">
                        </div>
                        <div class="service_text relative-position">
                            <div class="service_icon float-left">                                
                                <i class="flaticon-budget"></i>
                            </div>
                            <div class="service_check text-center float-right">
                                <a class="block-display" href="!#"><i class="fas fa-check"></i></a>
                            </div>
                            <div class="service_content headline pera-content">
                                <h3><a href="!#">Notaris</a></h3>
                                <p>Notaris menyediakan layanan pembuatan akta autentik untuk perjanjian, surat kuasa, wasiat, serta dokumen penting lainnya.</p>
                                <a class="btn btn-secondary" href="notaris.html">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>
                    <div class="service_img_text wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                        <div class="service_img relative-position">
                            <img src="{{ asset('assets/index/assets-index') }}/img/service/sr3.jpg" alt="">
                        </div>
                        <div class="service_text relative-position">
                            <div class="service_icon float-left">
                                <i class="flaticon-mace"></i>
                            </div>
                            <div class="service_check text-center float-right">
                                <a class="block-display" href="{{ route('showPengacara') }}"><i class="fas fa-check"></i></a>
                            </div>
                            <div class="service_content headline pera-content">
                                <h3><a href="{{ route('showPengacara') }}">Pengacara</a></h3>
                                <p>Firma hukum layanan penuh di London yang telah diakui secara internasional dengan spesialisasi dalam bidang Komersial.</p>
                                <a class="btn btn-secondary" href="{{ route('showPengacara') }}">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>
                    <div class="service_img_text wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
                        <div class="service_img relative-position">
                            <img src="{{ asset('assets/index/assets-index') }}/img/service/sr1.jpg" alt="">
                        </div>
                        <div class="service_text relative-position">
                            <div class="service_icon float-left">
                                <i class="flaticon-employee"></i>
                            </div>
                            <div class="service_check text-center float-right">
                                <a class="block-display" href="!#"><i class="fas fa-check"></i></a>
                            </div>
                            <div class="service_content headline pera-content">
                                <h3><a href="!#">Mediator</a></h3>
                                <p>Firma hukum layanan penuh di London yang telah diakui secara internasional dengan spesialisasi dalam bidang Komersial.</p>
                                <a class="btn btn-secondary" href="injury_with_vehicles.html">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="why_choose" class="why_choose_section relative-position">
        <div class="container">
            <div class="choose_us_content">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="why_choose_left wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="section_title_area headline pera-content">
                                <p>
                                    <span class="title_shape_left"></span>
                                    Kinerja Kami
                                </p>
                                <h2>
                                    Bergabung
                                    Dengan Kami
                                </h2>
                            </div>
                            <div class="choose_us_list clearfix ul-li-block">
                                <ul>
                                    <li>
                                        <div class="choose_icon float-left relative-position">
                                            <i class="flaticon-budget"></i>
                                            <span class="choose_num">01</span>
                                        </div>
                                        <div class="choose_text headline pera-content">
                                            <h3>Bergabung Sebagai Notaris</h3>
                                            <p>Lebih mudah ditemukan oleh klien terdekat dengan fasilitas kami.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="choose_icon float-left relative-position">
                                            <i class="flaticon-mace"></i>
                                            <span class="choose_num">02</span>
                                        </div>
                                        <div class="choose_text headline pera-content">
                                            <h3>Bergabung Sebagai Pengacara</h3>
                                            <p>Dapatkan lebih banyak klien dan dukungan profesional dari tim kami.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="choose_icon float-left relative-position">
                                            <i class="flaticon-employee"></i>
                                            <span class="choose_num">03</span>
                                        </div>
                                        <div class="choose_text headline pera-content">
                                            <h3>Bergabung Sebagai Mediator</h3>
                                            <p>Bantu menyelesaikan konflik dengan metode yang cepat dan efektif.</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="choose_form wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="section_title_area headline pera-content">
                                <p>
                                    <span class="title_shape_left"></span>
                                    Bergabung Sekarang
                                </p>
                                <h2>
                                    Dapatkan Informasi Terbaru.
                                </h2>
                            </div>
                            <div class="choose_form_area">                   
                                <form id="contact_form" action="{{ route('join.post') }}" method="POST">
                                    @csrf
                                    <div class="contact-info">
                                        <label>Nama Lengkap Anda</label>
                                        <input class="email" name="name" id="name" type="text" placeholder="Masukkan nama lengkap Anda" required value="{{ old('name') }}">
                                        <div class="icon-bg">
                                            <i class="far fa-user"></i>
                                        </div>
                                    </div>
                                
                                    <div class="contact-info">
                                        <label>Email Anda</label>
                                        <input class="email" name="email" id="email" type="email" placeholder="Masukkan alamat email Anda" required value="{{ old('email') }}">
                                        <div class="icon-bg">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                    </div>
                                                          
                                    <div class="contact-info">
                                        <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required /><br>                                        
                                        <label for="terms">Saya setuju dengan <a href="#">syarat dan ketentuan</a></label>
                                    </div>
                               
                                    <div class="sub-button text-uppercase">
                                        <button type="submit" value="Submit">Daftar Sekarang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

	<section id="call_to_action2" class="call_action_two">
		<div class="container"> 
			<div class="call_action_logo text-center">
                <img src="{{ asset('assets/index/assets-index') }}/img/logo/call-logo.png" alt="" style="width: 200px;">
            </div>
            
			<div class="section_title_area text-center headline pera-content">
				<p>
					<span class="title_shape_left"></span>
					Ditangani Oleh Tim Profesional
					<span class="title_shape_right"></span>
				</p>
				<h2>
					Dapatkan Advice Hukum Terbaik
				</h2>
			</div>
			<div class="call_action_number text-center">
				+62822 7662 4504
			</div>
			<div class="call_action_btn ul-li text-center">
				<ul>
					<li><a class="block-display" href="!#">Get a Quote</a></li>
					<li><a class="block-display" href="!#">Learn More</a></li>
				</ul>
			</div>
		</div>
	</section>

	{{-- <section id="portfolio" class="portfolio_section">
		<div class="background_parallax background_position relative-position">
			<div class="background_overlay"></div>
			<div class="section_title_area headline pera-content">
				<p>
					<span class="title_shape_left"></span>
					our portfolio
				</p>
				<h2>
					Case Solved
				</h2>
			</div>
			<div id="portfolio_slideid" class="portfolio_slide owl-carousel">
				<div class="portfolio_img_text wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
					<div class="portfolio_img">
						<img src="{{ asset('assets/index/assets-index') }}/img/portfolio/prt1.jpg" alt="">
					</div>
					<div class="portfolio_text relative-position headline">
						<div class="port_icon text-center">
							<a href="!#"> <i class='fas fa-arrow-right'></i></a>
						</div>
						<span class="text-uppercase">criminal case</span>
						<h3>Donald Pakura Car Case</h3>
					</div>
				</div>
				<div class="portfolio_img_text wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="1500ms">
					<div class="portfolio_img">
						<img src="{{ asset('assets/index/assets-index') }}/img/portfolio/prt2.jpg" alt="">
					</div>
					<div class="portfolio_text relative-position headline">
						<div class="port_icon text-center">
							<a href="!#"> <i class='fas fa-arrow-right'></i></a>
						</div>
						<span class="text-uppercase">land business</span>
						<h3>Troma Land Mafia Case</h3>
					</div>
				</div>
				<div class="portfolio_img_text wow fadeInLeft" data-wow-delay="600ms" data-wow-duration="1500ms">
					<div class="portfolio_img">
						<img src="{{ asset('assets/index/assets-index') }}/img/portfolio/prt3.jpg" alt="">
					</div>
					<div class="portfolio_text relative-position headline">
						<div class="port_icon text-center">
							<a href="!#"> <i class='fas fa-arrow-right'></i></a>
						</div>
						<span class="text-uppercase">accident</span>
						<h3>Miran Accident Case</h3>
					</div>
				</div>
				<div class="portfolio_img_text wow fadeInLeft" data-wow-delay="900ms" data-wow-duration="1500ms">
					<div class="portfolio_img">
						<img src="{{ asset('assets/index/assets-index') }}/img/portfolio/prt4.jpg" alt="">
					</div>
					<div class="portfolio_text relative-position headline">
						<div class="port_icon text-center">
							<a href="!#"> <i class='fas fa-arrow-right'></i></a>
						</div>
						<span class="text-uppercase">advice</span>
						<h3>Mirax Divorce Case</h3>
					</div>
				</div>
				<div class="portfolio_img_text">
					<div class="portfolio_img">
						<img src="{{ asset('assets/index/assets-index') }}/img/portfolio/prt1.jpg" alt="">
					</div>
					<div class="portfolio_text relative-position headline">
						<div class="port_icon text-center">
							<a href="!#"> <i class='fas fa-arrow-right'></i></a>
						</div>
						<span class="text-uppercase">criminal case</span>
						<h3>Donald Pakura Car Case</h3>
					</div>
				</div>
				<div class="portfolio_img_text">
					<div class="portfolio_img">
						<img src="{{ asset('assets/index/assets-index') }}/img/portfolio/prt2.jpg" alt="">
					</div>
					<div class="portfolio_text relative-position headline">
						<div class="port_icon text-center">
							<a href="!#"> <i class='fas fa-arrow-right'></i></a>
						</div>
						<span class="text-uppercase">criminal case</span>
						<h3>Troma Land Mafia Case</h3>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="achivement" class="achivement_section">
		<div class="container">
			<div class="achivement_content">
				<div class="row">
					<div class="col-lg-6 col-md-12">
						<div class="certificate_img" data-tilt data-tilt-max="5">
							<img src="{{ asset('assets/index/assets-index') }}/img/achive/cer1.png" alt="">
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="achivement_text">
							<div class="section_title_area headline pera-content">
								<p>
									<span class="title_shape_left"></span>
									rewards
								</p>
								<h2>
									Our Archivement
								</h2>
							</div>
							<div class="achivement_img_list clearfix ul-li">
								<ul>
									<li><img src="{{ asset('assets/index/assets-index') }}/img/achive/aw1.png" alt=""></li>
									<li><img src="{{ asset('assets/index/assets-index') }}/img/achive/aw2.png" alt=""></li>
									<li><img src="{{ asset('assets/index/assets-index') }}/img/achive/aw3.png" alt=""></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="team" class="team_section">
		<div class="container">
			<div class="section_title_area text-center headline pera-content">
				<p>
					<span class="title_shape_left"></span>
					team
					<span class="title_shape_right"></span>
				</p>
				<h2>
					Our Advisors
				</h2>
			</div>
			<div class="team_member_content">
				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="team_img_text wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="team_img_link relative-position">
								<div class="team_img">
									<img src="{{ asset('assets/index/assets-index') }}/img/team/tm1.jpg" alt="">
								</div>
								<div class="team_link text-center">
									<i class="fas fa-plus"></i>
									<div class="social_link">
										<a class="mem_fb" href="!#"><i class="fab fa-facebook-f"></i></a>
										<a class="mem_tw" href="!#"><i class="fab fa-twitter"></i></a>
										<a class="mem_ld" href="!#"><i class="fab fa-linkedin"></i></a>
										<a class="mem_yo" href="!#"><i class="fab fa-youtube"></i></a>
									</div>
								</div>
							</div>
							<div class="team_text_details text-center headline pera-content">
								<h3>Rosalina D. Willm</h3>
								<span class="designation">founder</span>
								<p>The Companies Act 1994 is the enabling act in Bangladesh which deals with entire companies affairs; whether it is private, public.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="team_img_text wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="1500ms">
							<div class="team_img_link relative-position">
								<div class="team_img">
									<img src="{{ asset('assets/index/assets-index') }}/img/team/tm2.jpg" alt="">
								</div>
								<div class="team_link text-center">
									<i class="fas fa-plus"></i>
									<div class="social_link">
										<a class="mem_fb" href="!#"><i class="fab fa-facebook-f"></i></a>
										<a class="mem_tw" href="!#"><i class="fab fa-twitter"></i></a>
										<a class="mem_ld" href="!#"><i class="fab fa-linkedin"></i></a>
										<a class="mem_yo" href="!#"><i class="fab fa-youtube"></i></a>
									</div>
								</div>
							</div>
							<div class="team_text_details text-center headline pera-content">
								<h3>Hilix B. Browni</h3>
								<span class="designation">Crime Attorneyeo</span>
								<p>The Companies Act 1994 is the enabling act in Bangladesh which deals with entire companies affairs; whether it is private, public.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="team_img_text wow fadeInLeft" data-wow-delay="600ms" data-wow-duration="1500ms">
							<div class="team_img_link relative-position">
								<div class="team_img">
									<img src="{{ asset('assets/index/assets-index') }}/img/team/tm3.jpg" alt="">
								</div>
								<div class="team_link text-center">
									<i class="fas fa-plus"></i>
									<div class="social_link">
										<a class="mem_fb" href="!#"><i class="fab fa-facebook-f"></i></a>
										<a class="mem_tw" href="!#"><i class="fab fa-twitter"></i></a>
										<a class="mem_ld" href="!#"><i class="fab fa-linkedin"></i></a>
										<a class="mem_yo" href="!#"><i class="fab fa-youtube"></i></a>
									</div>
								</div>
							</div>
							<div class="team_text_details text-center headline pera-content">
								<h3>Kimix H. Harlamu</h3>
								<span class="designation">Attorney</span>
								<p>The Companies Act 1994 is the enabling act in Bangladesh which deals with entire companies affairs; whether it is private, public.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="team_img_text wow fadeInLeft" data-wow-delay="900ms" data-wow-duration="1500ms">
							<div class="team_img_link relative-position">
								<div class="team_img">
									<img src="{{ asset('assets/index/assets-index') }}/img/team/tm4.jpg" alt="">
								</div>
								<div class="team_link text-center">
									<i class="fas fa-plus"></i>
									<div class="social_link">
										<a class="mem_fb" href="!#"><i class="fab fa-facebook-f"></i></a>
										<a class="mem_tw" href="!#"><i class="fab fa-twitter"></i></a>
										<a class="mem_ld" href="!#"><i class="fab fa-linkedin"></i></a>
										<a class="mem_yo" href="!#"><i class="fab fa-youtube"></i></a>
									</div>
								</div>
							</div>
							<div class="team_text_details text-center headline pera-content">
								<h3>Rosalina D. Willm</h3>
								<span class="designation">head Attorney</span>
								<p>The Companies Act 1994 is the enabling act in Bangladesh which deals with entire companies affairs; whether it is private, public.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="testimonial_subscribe" class="testimonial_subscribe_section">
		<div class="testimonial_subscribe_content row-flex">
			<div class="testimonial_content">
				<div class="section_title_area headline pera-content">
					<p>
						<span class="title_shape_left"></span>
						testimonials
					</p>
					<h2>
						See What Out Happy
						Clients Says
					</h2>
				</div>
				<div id="testimonial_slide" class="testimonial_slide_area owl-carousel">
					<div class="testimonial_pictext">
						<div class="testimonial_text relative-position">
							“ Kilixer Monger has an outstanding reputation for delivering premium solution which is economic in commercial terms.  The same is made possible by utilizing its resources i.e. experienced, specialised and highly educated senior lawyers, talented junior lawyers graduated from top law schools, excellent operational model, prestigious and valuable
							physical and online.
							<div class="t-icon-bg"><i class="flaticon-quotation"></i></div>
						</div>
						<div class="testimonial_imgname">
							<div class="testi_img float-left">
								<img src="{{ asset('assets/index/assets-index') }}/img/testimonial/testi1.jpg" alt="">
							</div>
							<div class="testi_text headline">
								<h3>Rosalina D. William</h3>
								<span class="designation">Founder</span>
							</div>
						</div>
					</div>
					<div class="testimonial_pictext">
						<div class="testimonial_text relative-position">
							“ Kilixer Monger has an outstanding reputation for delivering premium solution which is economic in commercial terms.  The same is made possible by utilizing its resources i.e. experienced, specialised and highly educated senior lawyers, talented junior lawyers graduated from top law schools, excellent operational model, prestigious and valuable
							physical and online.
							<div class="t-icon-bg"><i class="flaticon-quotation"></i></div>
						</div>
						<div class="testimonial_imgname">
							<div class="testi_img float-left">
								<img src="{{ asset('assets/index/assets-index') }}/img/testimonial/testi1.jpg" alt="">
							</div>
							<div class="testi_text headline">
								<h3>Rosalina D. William</h3>
								<span class="designation">Founder</span>
							</div>
						</div>
					</div>
					<div class="testimonial_pictext">
						<div class="testimonial_text relative-position">
							“ Kilixer Monger has an outstanding reputation for delivering premium solution which is economic in commercial terms.  The same is made possible by utilizing its resources i.e. experienced, specialised and highly educated senior lawyers, talented junior lawyers graduated from top law schools, excellent operational model, prestigious and valuable
							physical and online.
							<div class="t-icon-bg"><i class="flaticon-quotation"></i></div>
						</div>
						<div class="testimonial_imgname">
							<div class="testi_img float-left">
								<img src="{{ asset('assets/index/assets-index') }}/img/testimonial/testi1.jpg" alt="">
							</div>
							<div class="testi_text headline">
								<h3>Rosalina D. William</h3>
								<span class="designation">Founder</span>
							</div>
						</div>
					</div>
					<div class="testimonial_pictext">
						<div class="testimonial_text relative-position">
							“ Kilixer Monger has an outstanding reputation for delivering premium solution which is economic in commercial terms.  The same is made possible by utilizing its resources i.e. experienced, specialised and highly educated senior lawyers, talented junior lawyers graduated from top law schools, excellent operational model, prestigious and valuable
							physical and online.
							<div class="t-icon-bg"><i class="flaticon-quotation"></i></div>
						</div>
						<div class="testimonial_imgname">
							<div class="testi_img float-left">
								<img src="{{ asset('assets/index/assets-index') }}/img/testimonial/testi1.jpg" alt="">
							</div>
							<div class="testi_text headline">
								<h3>Rosalina D. William</h3>
								<span class="designation">Founder</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /testimonial content -->
			<div class="subscribe_content">
				<div class="section_title_area headline pera-content">
					<p>
						<span class="title_shape_left"></span>
						get offers
					</p>
					<h2>
						Subscribe Now & Get
						Every 75% Offer.
					</h2>
				</div>
				<div class="subscribe_text">
					Reputation for delivering premium solution which is economic in commercial terms.  The same is made possible by utilizing its resources i.e. experienced, specialised and highly educated senior lawyers, talented junior lawyers graduated from top law schools, excellent operational model, prestigious and valuable physical and online law report and journal, strong network and geographical locations etc. The firm has been consistently ranked by world’s leading and highly reputed global directory Chambers and Partners.
				</div>
				<div class="subscribe_form">
					<form id="sub_form" action="#" method="POST" enctype="multipart/form-data">
						<div class="contact-info">
							<input class="email" name="name" type="text" placeholder="Enter your full name">
							<div class="icon-bg">
								<i class="far fa-user"></i>
							</div>
						</div>
						<div class="contact-info">
							<input class="name" name="Email" type="email" placeholder="Enter your email address">
							<div class="icon-bg">
								<i class="far fa-envelope"></i>
							</div>
						</div>
						<div class="sub-button  text-capitalize pera-content relative-position">
							<button type="submit" value="Submit">Subscribe Now</button>
							<div class="icon-bg">
								<i class="far fa-paper-plane"></i>
							</div>
							<p>*** GDPR Certified we are. So Don’t worry about your email.</p> 
						</div> 
					</form>
				</div>
			</div>
		</div>
	</section>

	<div class="client_area">
		<div class="client_list ul-li clearfix">
			<ul>
				<li><img src="{{ asset('assets/index/assets-index') }}/img/client/c1.png" alt=""></li>
				<li><img src="{{ asset('assets/index/assets-index') }}/img/client/c2.png" alt=""></li>
				<li><img src="{{ asset('assets/index/assets-index') }}/img/client/c3.png" alt=""></li>
				<li><img src="{{ asset('assets/index/assets-index') }}/img/client/c4.png" alt=""></li>
				<li><img src="{{ asset('assets/index/assets-index') }}/img/client/c5.png" alt=""></li>
			</ul>
		</div>
	</div>

	<section id="blog_area" class="blog_section">
		<div class="container">
			<div class="section_title_area text-center headline pera-content">
				<p>
					<span class="title_shape_left"></span>
					blog
					<span class="title_shape_right"></span>
				</p>
				<h2>
					News Feeds
				</h2>
			</div>
			<div class="blog_content">
				<div class="row">
					<div class="col-lg-4 col-md-6">
						<div class="blog_img_text wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="blog_img relative-position">
								<img src="{{ asset('assets/index/assets-index') }}/img/blog/b1.jpg" alt="">
								<div class="blog_meta">
									<div class="blog_author float-left">
										<img src="{{ asset('assets/index/assets-index') }}/img/blog/bam1.jpg" alt="">
									</div>
									<div class="author_meta">
										<span class="author_name">Rosalina D. William</span>
										<span class="post_date"><i class="fas fa-calendar-alt"></i> 12th may 2020</span>
									</div>
								</div>
							</div>
							<div class="blog_text headline">
								<h3><a href="!#">Main practice areas of the firm
								include Admiralty.</a></h3>
								<span>
									The Companies Act 1994 is the enabling act in Bangladesh which deals with entire companies affairs; whether it is private, public & officially decoration.
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="blog_img_text  wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
							<div class="blog_img relative-position">
								<img src="{{ asset('assets/index/assets-index') }}/img/blog/b2.jpg" alt="">
								<div class="blog_meta">
									<div class="blog_author float-left">
										<img src="{{ asset('assets/index/assets-index') }}/img/blog/bam2.jpg" alt="">
									</div>
									<div class="author_meta">
										<span class="author_name">Murax H. Hilixer</span>
										<span class="post_date"><i class="fas fa-calendar-alt"></i> 12th may 2020</span>
									</div>
								</div>
							</div>
							<div class="blog_text headline">
								<h3><a href="!#">Main practice areas of the firm
								include Admiralty.</a></h3>
								<span>
									The Companies Act 1994 is the enabling act in Bangladesh which deals with entire companies affairs; whether it is private, public & officially decoration.
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="blog_img_text  wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
							<div class="blog_img relative-position">
								<img src="{{ asset('assets/index/assets-index') }}/img/blog/b3.jpg" alt="">
								<div class="blog_meta">
									<div class="blog_author float-left">
										<img src="{{ asset('assets/index/assets-index') }}/img/blog/bam3.jpg" alt="">
									</div>
									<div class="author_meta">
										<span class="author_name">Miranda M. Halim</span>
										<span class="post_date"><i class="fas fa-calendar-alt"></i> 12th may 2020</span>
									</div>
								</div>
							</div>
							<div class="blog_text headline">
								<h3><a href="!#">Main practice areas of the firm
								include Admiralty.</a></h3>
								<span>
									The Companies Act 1994 is the enabling act in Bangladesh which deals with entire companies affairs; whether it is private, public & officially decoration.
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}

@endsection
