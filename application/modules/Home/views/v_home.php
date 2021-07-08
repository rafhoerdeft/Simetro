<!DOCTYPE html>

<html lang="en">

<head>

	<title>SiMETRO KABUPATEN MAGELANG</title>

	<meta charset="UTF-8">

	<meta name="description" content="Industry.INC HTML Template">

	<meta name="keywords" content="industry, html">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	

	<!-- Favicon -->

	<link href="<?=base_url()?>assets/assets/images/logo/logo-metro.png" rel="shortcut icon"/>



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

		.search-switch-warp {

		   display: none;

		}

	</style>



</head>

<body>

	<!-- Page Preloder -->

	<div id="preloder" style="background: white">

		<div class="loader"></div>

	</div>



	<!-- Header section  -->

	<header class="header-section clearfix fixed-top bg-light">

		<div class="site-navbar ">

			<!-- Logo -->

			<a href="#!" class="site-logo">

		        <img src="<?=base_url()?>assets/assets/images/logo/logo-metro.png" width="55" alt="">

			</a>

			<div class="header-right">

				<div class="header-info-box">

					<div class="hib-icon">

						<img src="<?=base_url()?>assets/frontend/img/icons/phone.png" alt="" class="">

					</div>

					<div class="hib-text">

						<h6>(0293) 788227</h6>

						<p>simetro_magelang@gmail.com</p>

					</div>

				</div>

				<div class="header-info-box">

					<div class="hib-icon">

						<img src="<?=base_url()?>assets/frontend/img/icons/map-marker.png" alt="" class="">

					</div>

					<div class="hib-text">

						<h6>Jalan Soekarno-Hatta No. 24-26</h6>

						<p>Kota Mungkid 56511</p>

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

					<li><a href="#maklumat">Maklumat</a></li>

					<li><a href="<?= base_url('Auth') ?>">Login</a></li>

				</ul>

			</nav>



		</div>

	</header>

	<!-- Header section end  -->

	

	<!-- Hero section  -->

	<section class="hero-section" id="beranda">

		<div class="hero-slider owl-carousel">

			<?php foreach($carousels->result() as $carousel) { ?>

				<div class="hero-item set-bg" data-setbg="<?=base_url()?>assets/frontend/carousel_image/<?=$carousel->image;?>">

					<div class="container">

						<div class="row">

							<div class="col-xl-8">

								<h2>

									<?php

										$text_explode = explode(' ', $carousel->title);

										foreach($text_explode as $text_carousel)

										{

											echo '<span>'.$text_carousel.'</span>';

										}

									?>

								</h2>

								<!-- <a href="#!" class="site-btn sb-white mr-4 mb-3">Read More</a>

								<a href="#!" class="site-btn sb-dark">our Services</a> -->

							</div>

						</div>

					</div>

				</div>

			<?php } ?>

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

				                <?=$profile->profile;?>

							</div>

						</div>

					</div>

				</div>

				<div class="row">

					<div class="col-lg-12 col-md-12">

						<div class="service-item">

							<div class="si-head">

								<div class="si-icon">

									<img src="<?=base_url()?>assets/frontend/img/icons/cogwheel.png" alt="">

								</div>

								<h5>Visi</h5>

							</div>

							<p><?=$profile->visi;?></p>

						</div>

					</div>

					<div class="col-lg-12 col-md-12">

						<div class="service-item">

							<div class="si-head">

								<div class="si-icon">

									<img src="<?=base_url()?>assets/frontend/img/icons/helmet.png" alt="">

								</div>

								<h5>Misi</h5>

							</div>

							<p><?=$profile->misi;?></p>

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

        <?php foreach($beritas->result() as $berita) { ?>

          <div class="col-lg-4 col-md-6">

            <div class="blog-post" style="background-color: white;">

              <div class="blog-thumb set-bg" data-setbg="<?=base_url()?>assets/frontend/berita_image/<?=$berita->image;?>">

                <div class="blog-date"><?=date('d M Y', strtotime($berita->tanggal));?></div>

                <!-- <div class="blog-date float-right"><i class="fa fa-eye"></i> 8</div> -->

              </div>

              <div class="pl-3 pb-1 pr-3">

                <h5 class="mb-1"><?=ucwords($berita->judul);?></h5>

                <hr>

                <p style="font-size: 10pt">

                  <!-- <?php

                    if (strlen($berita->berita) > 200) 

                    {

                      echo substr(ucfirst($berita->berita), 0, 200) . '[...]';

                    }

                    else

                    {

                      echo $berita->berita;

                    }

                  ?> -->

                  <a href="Home/detail_berita/<?=$berita->id_berita;?>" class="btn btn-sm" style="background-color:#ffc000; color: white">Selengkapnya...</a>

                </p>

              </div>

            </div>

          </div>

        <?php } ?>

				<div class="col-md-12">

					<center><a href="<?=base_url();?>Home/semua_berita" class="btn btn-lg text-white p-3" style="background-color:#ffc000; font-size: 12pt">Baca Semua Berita</a></center>

				</div>

			</div>

		</div>

	</section>

	<!-- Features section end  -->



	<!-- Call to action section  -->

	<!-- <section class="cta-section" style="background-color: white;">

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

	</section> -->

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

                <?php foreach($pengumumans->result() as $pengumuman) { ?>

                  <div class="testimonial" style="color:#718090">

                    <?php

                      if (strlen($pengumuman->pengumuman) > 300) 

                      {

                        echo substr(ucfirst($pengumuman->pengumuman), 0, 300) . '[...]';

                      }

                      else

                      {

                        echo $pengumuman->pengumuman;

                      }

                    ?>

                    <div class="testi-info">

                      <span><?=date('d M Y', strtotime($pengumuman->tanggal));?></span>

                    </div>

                  </div>

                <?php } ?>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</section>

	<!-- Testimonial section end  -->



	<!-- Call to action section  -->

	<!-- <section class="cta-section">

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

	</section> -->

	<!-- Call to action section end  -->



	<section class="mt-2 p-5" id="agenda">

		<div class="container">

			<div class="row">

				<!-- <div class="col-lg-5 align-self-center">

					<label class="p-2 text-white" style="background-color: #ffc000; width: 100%">Pilih Bulan</label>

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

				</div> -->

				<div class="col-lg-7 d-flex">

					<div class="sb-widget">

						<h2 class="sb-title">Agenda</h2>

						<ul id="listAgenda">

							<?php foreach ($agenda as $key) {?>

								<li><a href="#!"><?=formatTanggalOnly($key->tgl_inspeksi).', '.$key->layanan.' '.$key->nama_usaha.' '.$key->nama_user;?></a></li>

							<?php } ?>

						</ul>

					</div>

				</div>		

			</div>

		</div>

	</section>



	<!-- maklumat -->

	<section class="reserch-section spad" id="maklumat">

		<div class="container">

			<div class="row">

				<div class="col-lg-12">

					<div class="tab-content reserch-tab">

						<div class="tab-pane fade show active">

							<h2 class="text-warning text-center">Maklumat</h2>

							<div class="text-white">

								<?=$maklumat->maklumat;?>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</section>

	<!-- Reserch section end  -->



	<!-- Call to action section  -->

	<section class="cta-section">

		<div class="container">

			<div class="row">

				<div class="col-lg-9 d-flex align-items-center">

					<h2>Sistem Informasi Metrologi Kab. Magelang</h2>

				</div>

				<div class="col-lg-3 text-lg-right" >

					<a href="#contact" class="site-btn sb-dark">contact us</a>

				</div>

			</div>

		</div>

	</section>



  <!-- FOOTER -->

    <?php $this->load->view('v_footer');?>

  <!-- END FOOTER -->



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

