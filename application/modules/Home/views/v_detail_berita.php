<!-- Page top section  -->

<section class="page-top-section set-bg" data-setbg="<?= base_url(); ?>assets/frontend/img/page-top-bg/1.jpg">

  <div class="container">

    <div class="row">

      <div class="col-lg-7">

        <h2><?=ucwords($berita->judul);?></h2>

        <label class="site-btn"><?=date('d M Y', strtotime($berita->tanggal));?></label>

      </div>

    </div>

  </div>

</section>

<!-- Page top section end  -->





<!-- About section -->

<section class="about-section spad">

  <div class="container">

    <div class="row">

      <!-- <div class="col-lg-4">

      </div> -->

      <div class="col-lg-12">

        <!-- <div class="row">  -->
          <div class="col-md-4">
            <img src="<?= base_url(); ?>assets/frontend/berita_image/<?= $berita->image; ?>" style="float:left; margin-right:10px;margin-bottom:5px;" alt="">
          </div>
        <!-- </div> -->

        <div class="about-text">

          <?= $berita->berita; ?>

        </div>

      </div>

    </div>

  </div>

</section>

<!-- About section end