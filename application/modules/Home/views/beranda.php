<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>SiMETRO KABUPATEN MAGELANG</title>
	<meta charset="UTF-8">
	<meta name="description" content="Industry.INC HTML Template">
	<meta name="keywords" content="industry, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Favicon -->
	<link href="<?=base_url()?>assets/frontend/img/favicon.ico" rel="shortcut icon"/>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?=base_url()?>assets/frontend/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="<?=base_url()?>assets/frontend/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="<?=base_url()?>assets/frontend/css/magnific-popup.css"/>
	<link rel="stylesheet" href="<?=base_url()?>assets/frontend/css/slicknav.min.css"/>
	<link rel="stylesheet" href="<?=base_url()?>assets/frontend/css/owl.carousel.min.css"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="<?=base_url()?>assets/frontend/css/style.css"/>


	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style type="text/css">
		html {
			scroll-behavior: smooth;
		}
	</style>

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header section  -->
	<header class="header-section clearfix">
		<div class="site-navbar fixed-top bg-light">
			<!-- Logo -->
			<a href="index.html" class="site-logo">
				<img src="<?=base_url()?>assets/frontend/img/logo.png" alt="">
			</a>
			<div class="header-right">
				<div class="header-info-box">
					<div class="hib-icon">
						<img src="<?=base_url()?>assets/frontend/img/icons/phone.png" alt="" class="">
					</div>
					<div class="hib-text">
						<h6>+546 990221 123</h6>
						<p>contact@industryalinc.com</p>
					</div>
				</div>
				<div class="header-info-box">
					<div class="hib-icon">
						<img src="<?=base_url()?>assets/frontend/img/icons/map-marker.png" alt="" class="">
					</div>
					<div class="hib-text">
						<h6>Main Str, no 23</h6>
						<p>NY, New York PK 23589</p>
					</div>
				</div>
			</div>
			<!-- Menu -->
			<nav class="site-nav-menu">
				<ul>
					<li><a href="#beranda">Beranda</a></li>
					<li><a href="#profil">Profil</a></li>
					<li><a href="#berita">Berita</a></li>
					<li><a href="#pengumuman">Pengumuman</a></li>
					<li><a href="#agenda">Agenda</a></li>
				</ul>
			</nav>

		</div>
	</header>
	<!-- Header section end  -->
	
	<!-- Hero section  -->
	<section class="hero-section" id="beranda">
		<div class="hero-slider owl-carousel">
			<div class="hero-item set-bg" data-setbg="<?=base_url()?>assets/frontend/img/hero-slider/1.jpg">
				<div class="container">
					<div class="row">
						<div class="col-xl-8">
							<h2><span>Power</span><span>& Energy</span><span>Industry</span></h2>
							<a href="#" class="site-btn sb-white mr-4 mb-3">Read More</a>
							<a href="#" class="site-btn sb-dark">our Services</a>
						</div>
					</div>
				</div>
			</div>
			<div class="hero-item set-bg" data-setbg="<?=base_url()?>assets/frontend/img/hero-slider/2.jpg">
				<div class="container">
					<div class="row">
						<div class="col-xl-8">
							<h2><span>Power</span><span>& Energy</span><span>Industry</span></h2>
							<a href="#" class="site-btn sb-white mr-4 mb-3">Selengkapnya</a>
							<!-- <a href="#" class="site-btn sb-dark">our Services</a> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Hero section end  -->

	<!-- Services section  -->
	<section class="services-section" id="profil">
		<div class="services-warp">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="service-item">
							<div class="si-head">
								<h5>Mechanical Engineering</h5>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. </p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-6">
						<div class="service-item">
							<div class="si-head">
								<div class="si-icon">
									<img src="<?=base_url()?>assets/frontend/img/icons/cogwheel.png" alt="">
								</div>
								<h5>Mechanical Engineering</h5>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. </p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="service-item">
							<div class="si-head">
								<div class="si-icon">
									<img src="<?=base_url()?>assets/frontend/img/icons/helmet.png" alt="">
								</div>
								<h5>Profesional Workers</h5>
							</div>
							<p>Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="service-item">
							<div class="si-head">
								<div class="si-icon">
									<img src="<?=base_url()?>assets/frontend/img/icons/wind-engine.png" alt="">
								</div>
								<h5>Green Energy</h5>
							</div>
							<p>Sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec con-sequat arcu et commodo interdum. </p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="service-item">
							<div class="si-head">
								<div class="si-icon">
									<img src="<?=base_url()?>assets/frontend/img/icons/pollution.png" alt="">
								</div>
								<h5>Power Engineering</h5>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. </p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="service-item">
							<div class="si-head">
								<div class="si-icon">
									<img src="<?=base_url()?>assets/frontend/img/icons/pumpjack.png" alt="">
								</div>
								<h5>Oil & Lubricants</h5>
							</div>
							<p>Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu.</p>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="service-item">
							<div class="si-head">
								<div class="si-icon">
									<img src="<?=base_url()?>assets/frontend/img/icons/light-bulb.png" alt="">
								</div>
								<h5>Power & Energy</h5>
							</div>
							<p>Sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec con-sequat arcu et commodo interdum. </p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Services section end  -->

	<!-- Features section   -->
	<section class="features-section spad set-bg" data-setbg="<?=base_url()?>assets/frontend/img/features-bg.jpg" id="berita">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="blog-post" style="background-color: white;">
						<div class="blog-thumb set-bg" data-setbg="<?=base_url()?>assets/frontend/img/features/1.jpg">
							<div class="blog-date">08 Feb, 2019</div>
							<div class="blog-date float-right"><i class="fa fa-eye"></i> 8</div>
						</div>
						<div class="pl-3 pb-1 pr-3">
							<h5 class="mb-1">All you need to know about Engineering</h5>
							<hr>
							<p style="font-size: 10pt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin estst quis, blandit sollicitudi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin ... <a href="#" class="btn btn-sm" style="background-color:#ffc000; color: white">Selengkapnya</a></p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="blog-post" style="background-color: white;">
						<div class="blog-thumb set-bg" data-setbg="<?=base_url()?>assets/frontend/img/features/2.jpg">
							<div class="blog-date">08 Feb, 2019</div>
							<div class="blog-date float-right"><i class="fa fa-eye"></i> 8</div>
						</div>
						<div class="pl-3 pb-1 pr-3">
							<h5 class="mb-1">All you need to know about Engineering</h5>
							<hr>
							<p style="font-size: 10pt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin estst quis, blandit sollicitudi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin ... <a href="#" class="btn btn-sm" style="background-color:#ffc000; color: white">Selengkapnya</a></p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="blog-post" style="background-color: white;">
						<div class="blog-thumb set-bg" data-setbg="<?=base_url()?>assets/frontend/img/features/3.jpg">
							<div class="blog-date">08 Feb, 2019</div>
							<div class="blog-date float-right"><i class="fa fa-eye"></i> 8</div>
						</div>
						<div class="pl-3 pb-1 pr-3">
							<h5 class="mb-1">All you need to know about Engineering</h5>
							<hr>
							<p style="font-size: 10pt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin estst quis, blandit sollicitudi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin ... <a href="#" class="btn btn-sm" style="background-color:#ffc000; color: white">Selengkapnya</a></p>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<center><a href="#" class="btn btn-lg text-white p-3" style="background-color:#ffc000; font-size: 12pt">Baca Semua Berita</a></center>
				</div>
			</div>
		</div>
	</section>
	<!-- Features section end  -->

	<!-- Call to action section  -->
	<section class="cta-section" style="background-color: white;">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 d-flex align-items-center">
					<h2 style="color: #ffc000">SiMETRO Kabupaten Magelang</h2>
				</div>
				<div class="col-lg-3 text-lg-right" >
					<a href="#" class="site-btn">Profil</a>
				</div>
			</div>
		</div>
	</section>
	<!-- Call to action section end  -->

	<!-- Testimonial section -->
	<section class="testimonial-section" id="pengumuman">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6 p-0">
					<div class="testimonial-bg set-bg" data-setbg="<?=base_url()?>assets/frontend/img/mic.jpg"></div>
				</div>
				<div class="col-lg-6 p-0">
					<div class="testimonial-box">
						<div class="testi-box-warp">
							<h2><i class="fa fa-bullhorn"></i> Pengumuman</h2>
							<div class="testimonial-slider owl-carousel">
								<div class="testimonial">
									<p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. Vivamus posuere lorem lacus.Lorem ipsum dolor sit amet, consecte-tur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est.</p>
									<img src="<?=base_url()?>assets/frontend/img/testimonial-thumb.jpg" alt="" class="testi-thumb">
									<div class="testi-info">
										<h5>Michael Smith</h5>
										<span>24 Okt 2019</span>
									</div>
								</div>
								<div class="testimonial">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. Vivamus posuere lorem lacus.Lorem ipsum dolor sit amet, consecte-tur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est.</p>
									<img src="<?=base_url()?>assets/frontend/img/testimonial-thumb.jpg" alt="" class="testi-thumb">
									<div class="testi-info">
										<h5>Michael Smith</h5>
										<span>24 Okt 2019</span>
									</div>
								</div>
								<div class="testimonial">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. Vivamus posuere lorem lacus.Lorem ipsum dolor sit amet, consecte-tur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est.</p>
									<img src="<?=base_url()?>assets/frontend/img/testimonial-thumb.jpg" alt="" class="testi-thumb">
									<div class="testi-info">
										<h5>Michael Smith</h5>
										<span>CEO Industrial INC</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Testimonial section end  -->

	<!-- Call to action section  -->
	<section class="cta-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 d-flex align-self-center">
					<h2 class="text-center">SiMETRO Kabupaten Magelang</h2>
				</div>
				<div class="col-lg-3 text-lg-right" >
					<a href="#" class="site-btn sb-dark">Semua Pengumuman</a>
				</div>
			</div>
		</div>
	</section>
	<!-- Call to action section end  -->

	<section class="mt-2 p-5" id="agenda">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 align-self-center">
					<label class="p-2 text-white" style="background-color: #ffc000; width: 100%">Bulan</label>
					<select class="form-control" id="bulanAgenda" onchange="changeBulanAgenda()">
						<option value="1">Januari</option>
						<option value="2">Februari</option>
						<option value="3">Maret</option>
						<option value="4">April</option>
						<option value="5">Mei</option>
						<option value="6">Juni</option>
						<option value="7">Juli</option>
						<option value="8">Agustus</option>
						<option value="9">September</option>
						<option value="10">Oktober</option>
						<option value="11">November</option>
						<option value="12">Desember</option>
					</select>
				</div>
				<div class="col-lg-7 d-flex">
					<div class="sb-widget">
						<h2 class="sb-title">Agenda</h2>
						<ul id="listAgenda">
							<?php 
							foreach ($agenda as $key) {?>
								<li><a href=""><?=formatTanggalOnly($key->tgl_inspeksi).', '.$key->layanan.' '.$key->nama_usaha.' '.$key->nama_user;?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>		
			</div>
		</div>
	</section>

	<!-- Footer section -->
	<footer class="footer-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-widget about-widget">
						<img src="<?=base_url()?>assets/frontend/img/logo-light.png" alt="">
						<p>Lorem ipsum dolor sit amet, consec-tetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. </p>
						<div class="footer-social">
							<a href=""><i class="fa fa-facebook"></i></a>
							<a href=""><i class="fa fa-twitter"></i></a>
							<a href=""><i class="fa fa-dribbble"></i></a>
							<a href=""><i class="fa fa-behance"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="footer-widget">
						<h2 class="fw-title">Useful Resources</h2>
						<ul>
							<li><a href="">Jobs Vacancies</a></li>
							<li><a href="">Client Testimonials</a></li>
							<li><a href="">Green  Energy</a></li>
							<li><a href="">Chemical Research</a></li>
							<li><a href="">Oil Extractions</a></li>
							<li><a href="">About our Work</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="footer-widget">
						<h2 class="fw-title">Our Solutions</h2>
						<ul>
							<li><a href="">Metal Industry</a></li>
							<li><a href="">Agricultural Engineering</a></li>
							<li><a href="">Green  Energy</a></li>
							<li><a href="">Chemical Research</a></li>
							<li><a href="">Oil Extractions</a></li>
							<li><a href="">Manufactoring</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-7">
					<div class="footer-widget">
						<h2 class="fw-title">Contact Us</h2>
						<div class="footer-info-box">
							<div class="fib-icon">
								<img src="<?=base_url()?>assets/frontend/img/icons/map-marker.png" alt="" class="">
							</div>
							<div class="fib-text">
								<p>Main Str, no 23 NY,<br>New York PK 23589</p>
							</div>
						</div>
						<div class="footer-info-box">
							<div class="fib-icon">
								<img src="<?=base_url()?>assets/frontend/img/icons/phone.png" alt="" class="">
							</div>
							<div class="fib-text">
								<p>+546 990221 123<br>contact@industryalinc.com</p>
							</div>
						</div>
						<form class="footer-search">
							<input type="text" placeholder="Search">
							<button><i class="fa fa-search"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-buttom">
			<div class="container">
			<div class="row">
				<div class="col-lg-4 order-2 order-lg-1 p-0">
					<div class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
				</div>
				<div class="col-lg-7 order-1 order-lg-2 p-0">
					<ul class="footer-menu">
						<li><a href="#beranda">Beranda</a></li>
						<li><a href="#profil">Profil</a></li>
						<li><a href="#berita">Berita</a></li>
						<li><a href="#pengumuman">Pengumuman</a></li>
						<li><a href="#agenda">Agenda</a></li>
					</ul>
				</div>
			</div>
		</div>
		</div>
	</footer>
	<!-- Footer section end -->

	<script type="text/javascript">
		function changeBulanAgenda(){
			var a = $('#bulanAgenda option:selected').attr('value');
		}
	</script>
	
	<!--====== Javascripts & Jquery ======-->
	<script src="<?=base_url()?>assets/frontend/js/jquery-3.2.1.min.js"></script>
	<script src="<?=base_url()?>assets/frontend/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/frontend/js/jquery.slicknav.min.js"></script>
	<script src="<?=base_url()?>assets/frontend/js/owl.carousel.min.js"></script>
	<script src="<?=base_url()?>assets/frontend/js/circle-progress.min.js"></script>
	<script src="<?=base_url()?>assets/frontend/js/jquery.magnific-popup.min.js"></script>
	<script src="<?=base_url()?>assets/frontend/js/main.js"></script>

	</body>
</html>
