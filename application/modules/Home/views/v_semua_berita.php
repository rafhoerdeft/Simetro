<section class="features-section team-section spad set-bg" id="berita">
  <div class="container">
    <div class="row">
      <?php foreach($beritas->result() as $berita) { ?>
        <div class="col-lg-4 col-md-6">
          <style>
            .team-member:after{
              /* position: relative !important; */
            }
          </style>
          <div class="blog-post team-member" style="background-color: white;">
            <div class="blog-thumb set-bg" data-setbg="<?=base_url()?>assets/frontend/berita_image/<?=$berita->image;?>">
              <div class="blog-date"><?=date('d M Y', strtotime($berita->tanggal));?></div>
              <!-- <div class="blog-date float-right"><i class="fa fa-eye"></i> 8</div> -->
            </div>
            <div class="pl-3 pb-1 pr-3" style="position:relative;z-index:10;">
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
    </div>
  </div>
</section>