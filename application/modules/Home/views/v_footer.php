	<!-- Footer section -->

	<footer class="footer-section spad" id="contact">

	  <div class="container">

	    <div class="row">

	      <div class="col-lg-4 col-md-6 col-sm-6">

	        <div class="footer-widget">

						<h2 class="fw-title">Maps Location</h2>

						<iframe width="300" height="300" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1175.7858345250995!2d110.21928740109502!3d-7.590607257826367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a8c6f179564b5%3A0x1955cc321e023c4d!2sDinas%20Perdagangan%20Koperasi%20%26%20UKM%20Kabupaten%20Magelang!5e0!3m2!1sen!2sid!4v1573441675858!5m2!1sen!2sid" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>

	        </div>

	      </div>

	      <div class="col-lg-4 col-md-6 col-sm-6">

	        <div class="footer-widget">

						<h2 class="fw-title">Statistik</h2>

						<?php

							$hari_ini = $this->db->query(

								"SELECT count(*)as JML from tbl_pengunjung 

									where year(tanggal)=? and month(tanggal)=? and day(tanggal)=?",

								array(date('Y'), date('m'), date('d'))

							);

							$bulan_ini = $this->db->query(

								"SELECT count(*)as JML from tbl_pengunjung 

									where year(tanggal)=? and month(tanggal)=?",

								array(date('Y'), date('m'))

							);

							$tahun_ini = $this->db->query(

								"SELECT count(*)as JML from tbl_pengunjung 

									where year(tanggal)=?",

								array(date('Y'))

							);

						?>

						<table>

							<tr>

								<td style="color: #718090"><img src="<?= base_url() ?>assets/frontend/img/icons/worker.png" alt="" width="20" class=""> Pengunjung Hari Ini</td>

								<td style="color: #718090">:</td>

								<td style="color: #718090"><?= number_format($hari_ini->row()->JML, 0, ",", "."); ?></td>

							</tr>

							<tr>

								<td style="color: #718090"><img src="<?= base_url() ?>assets/frontend/img/icons/worker.png" alt="" width="20" class=""> Pengunjung Bulan Ini</td>

								<td style="color: #718090">:</td>

								<td style="color: #718090"><?= number_format($bulan_ini->row()->JML, 0, ",", "."); ?></td>

							</tr>

							<tr>

								<td style="color: #718090"><img src="<?= base_url() ?>assets/frontend/img/icons/worker.png" alt="" width="20" class=""> Pengunjung Tahun Ini</td>

								<td style="color: #718090">:</td>

								<td style="color: #718090"><?= number_format($tahun_ini->row()->JML, 0, ",", "."); ?></td>

							</tr>

						</table>

	        </div>

	      </div>

	      <div class="col-lg-4 col-md-6 col-sm-7">

	        <div class="footer-widget">

	          <h2 class="fw-title">Contact Us</h2>

	          <div class="footer-info-box">

	            <div class="fib-icon">

	              <img src="<?= base_url() ?>assets/frontend/img/icons/map-marker.png" alt="" class="">

	            </div>

	            <div class="fib-text">

	              <p>Jalan Soekarno-Hatta No. 24-26<br>Kota Mungkid 56511</p>

	            </div>

	          </div>

	          <div class="footer-info-box">

	            <div class="fib-icon">

	              <img src="<?= base_url() ?>assets/frontend/img/icons/phone.png" alt="" class="">

	            </div>

	            <div class="fib-text">

	              <p>(0293) 788227<br>simetro_magelang@gmail.com</p>

	            </div>

	          </div>

	          <!-- <form class="footer-search">

	            <input type="text" placeholder="Search">

	            <button><i class="fa fa-search"></i></button>

	          </form> -->

	        </div>

	      </div>

	    </div>

	  </div>

	  <div class="footer-buttom">

	    <div class="container">

	      <div class="row">

	        <div class="col-lg-4 order-2 order-lg-1 p-0">

	          <div class="copyright">

	            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

							Copyright &copy; 2019

							All rights reserved | DISKOMINFO

	            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

	          </div>

	        </div>

	        <div class="col-lg-7 order-1 order-lg-2 p-0">

	          <ul class="footer-menu">

	            <li><a href="<?=base_url();?>Home#beranda">Beranda</a></li>

	            <li><a href="<?=base_url();?>Home#profil">Profil</a></li>

	            <li><a href="<?=base_url();?>Home#berita">Berita</a></li>

	            <li><a href="<?=base_url();?>Home#pengumuman">Pengumuman</a></li>

	            <li><a href="<?=base_url();?>Home#agenda">Agenda</a></li>

	            <li><a href="<?=base_url();?>Home#maklumat">Maklumat</a></li>

	            <!-- <li><a href="<?= base_url('Auth') ?>">Login</a></li> -->

	          </ul>

	        </div>

	      </div>

	    </div>

	  </div>

	</footer>

	<!-- Footer section end -->