<!DOCTYPE html>

<html lang="en">



<head>

	<title>SiMETRO KABUPATEN MAGELANG</title>

  <meta charset="UTF-8">

  <meta name="description" content="Industry.INC HTML Template">

  <meta name="keywords" content="industry, html">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">



  <!-- Favicon -->

  <link href="<?=base_url()?>assets/assets/images/logo/logo-metro.png" rel="shortcut icon" />



  <!-- Google font -->

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap" rel="stylesheet">



  <!-- Stylesheets -->

  <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/bootstrap.min.css" />

  <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/font-awesome.min.css" />

  <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/slicknav.min.css" />

  <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/owl.carousel.min.css" />



  <!-- Main Stylesheets -->

  <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/style.css" />





  <!--[if lt IE 9]>

		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<![endif]-->

  <style type="text/css">
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

	<header class="header-section clearfix bg-light">

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

					<li class="<?=$active=='beranda'?'active':'';?>"><a href="<?=base_url();?>Home#beranda">Beranda</a></li>

					<li class="<?=$active=='profile'?'active':'';?>"><a href="<?=base_url();?>Home#profil">Profil</a></li>

					<li class="<?=$active=='berita'?'active':'';?>"><a href="<?=base_url();?>Home#berita">Berita</a></li>

					<li class="<?=$active=='pengumuman'?'active':'';?>"><a href="<?=base_url();?>Home#pengumuman">Pengumuman</a></li>

					<li class="<?=$active=='agenda'?'active':'';?>"><a href="<?=base_url();?>Home#agenda">Agenda</a></li>

					<li class="<?=$active=='maklumat'?'active':'';?>"><a href="<?=base_url();?>Home#maklumat">Maklumat</a></li>

          <!-- <li><a href="<?= base_url('Auth') ?>">Login</a></li> -->

				</ul>

			</nav>



		</div>

	</header>

  <!-- Header section end  -->



  <!-- CONTENT -->

    <?php $this->load->view($content);?>

  <!-- END CONTENT -->

  



  <!-- FOOTER -->

  <?php $this->load->view('v_footer');?>

  <!-- END FOOTER -->



  <!-- Search model -->

  <!-- <div class="search-model">

    <div class="h-100 d-flex align-items-center justify-content-center">

      <div class="search-close-switch">+</div>

      <form class="search-model-form">

        <input type="text" id="search-input" placeholder="Search here.....">

      </form>

    </div>

  </div> -->

  <!-- Search model end -->



  <!--====== Javascripts & Jquery ======-->

  <script src="<?= base_url(); ?>assets/frontend/js/jquery-3.2.1.min.js"></script>

  <script src="<?= base_url(); ?>assets/frontend/js/bootstrap.min.js"></script>

  <script src="<?= base_url(); ?>assets/frontend/js/jquery.slicknav.min.js"></script>

  <script src="<?= base_url(); ?>assets/frontend/js/owl.carousel.min.js"></script>

  <script src="<?= base_url(); ?>assets/frontend/js/circle-progress.min.js"></script>

  <script src="<?= base_url(); ?>assets/frontend/js/jquery.magnific-popup.min.js"></script>

  <script src="<?= base_url(); ?>assets/frontend/js/main.js"></script>



</body>



</html>