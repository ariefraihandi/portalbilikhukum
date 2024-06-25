<!-- Start footer section
	============================================= -->
	<footer id="footer_area" class="footer_section relative-position">
		<div class="background_overlay"></div>
		<div class="container">
			<div class="footer_content">
				<div class="row">
					<div class="col-lg-4 col-md-12">
						<div class="footer_widget headline">
							<h3 class="widget_title" style="color: black;">
								<span class="title_shape_left"></span>
								About Us
							</h3>
							<div class="widget_footer_text">
								Bilik Hukum adalah layanan yang memberikan edukasi hukum dan bantuan hukum. Kami didirikan pada bulan Desember 2023 dan sejak itu telah memberikan kontribusi signifikan dalam membantu mahasiswa dalam memahami bidang hukum, serta memberikan berbagai bentuk bantuan hukum kepada masyarakat secara luas
							</div>
							<div class="footer_app_btn">
								<a href="https://bilikhukum.com/join?token=3wnY0chj">Bergabung Bersama Kami</a>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12">
						<div class="footer_widget headline">
							<h3 class="widget_title" style="color: black;">
								<span class="title_shape_left"></span>
								Useful Link
							</h3>
							
							<div class="practice_list ul-li-block clearfix">
								<ul>
									<li><a href="https://article.bilikhukum.com/category/hukum-pidana/" target="_blank">Hukum Pidana</a></li>
									<li><a href="!#">Family Matters</a></li>
									<li><a href="!#">Arbitration & ADR</a></li>
									<li><a href="!#">Social Issue</a></li>
									<li><a href="!#">Accounting & Finance</a></li>
									<li><a href="!#">Life Insurance</a></li>
									<li><a href="!#">Finance & Investment</a></li>
									<li><a href="!#">Business Manage</a></li>
									<li><a href="!#">Criminal Prosecution </a></li>
									<li><a href="!#">Cheating</a></li>
									<li><a href="!#">Land & Property</a></li>
									<li><a href="!#">Fruad Matters</a></li>
									<li><a href="!#">Auditing Problem</a></li>
									<li><a href="!#">High Court Matters</a></li>
									<li><a href="!#">Case Solution</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12">
						<div class="footer_widget headline">
							<h3 class="widget_title" style="color: black;">
								<span class="title_shape_left"></span>
								News Feeds
							</h3>
							<div class="latest-blog-widget">
								@foreach($posts->take(4) as $post)
									<div class="blog-img-content">
									
										<div class="blog-text headline">
											<span class="blog-meta"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($post->post_date)->format('jS F Y') }}</span>
											<h4 style="color: grey;"> 
												<a href="{{ $post->guid }}" target="_blank">{{ $post->post_title }}</a>
											</h4>
										</div>
									</div>
								@endforeach
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<div class="footer_copyright">
		<div class="container">
			<div class="footer_copyright_content">
				<div class="row">
					<div class="col-lg-4 col-md-12">
						<div class="footer_social ul-li clearfix">
							<ul>
								<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="#"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#"><i class="fab fa-behance"></i></a></li>
								<li><a href="#"><i class="fab fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fab fa-youtube"></i></a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-12">
						<div class="footer_logo text-center">
							<a href="index.html"><img src="{{ asset('assets/index/assets-index') }}/img/logo/flogo-1.png" alt=""></a>
						</div>
					</div>
					<div class="col-lg-4 col-md-12">
						<div class="copyright_text text-right">
							Copyright By @ <a href="https://bilikhukum.com/">BilikHukum.com</a> - 2024
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- End  footer section
	============================================= -->		