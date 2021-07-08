<div class="page-wrapper">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Edit Berita</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        Edit Berita
      </ol>
    </div>
  </div>
  <div class="container-fluid">
    <?php echo $this->session->flashdata('alert'); ?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-judul">
              Edit berita
            </h4>
            <div class="table-responsive m-t-40">
              <form action="<?=base_url();?>Back_home/save_edit_berita" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_berita" value="<?=$berita->id_berita;?>">
                <div class="form-group">
                  <label for="judul" class="control-label">Judul:</label>
                  <input type="text" name="judul" value="<?=$berita->judul;?>" class="form-control" id="judul" placeholder="Ex: Rekor Muri Tari Soreng Kab. Magelang" required>
                </div>
                <div class="form-group">
                  <label for="tanggal">Tanggal:</label>
                  <input type="text" name="tanggal" class="form-control" placeholder="<?=date('Y-m-d');?>" value="<?=$berita->tanggal;?>" id="mdate" required>
                </div>
                <div class="form-group">
                  <label for="image" class="control-label">Image:</label>
                  <input type="hidden" name="old_image" value="<?=$berita->image;?>">
                  <input type="file" name="image" class="dropify" data-default-file="<?=base_url('assets/frontend/berita_image/'.$berita->image);?>" data-allowed-file-extensions="jpg png jpeg" data-height="120" />
                </div>
                <div class="form-group">
                  <label for="berita" class="control-label">Berita:</label>
                  <textarea name="berita" class="form-control summernote" cols="30" rows="30" required><?=$berita->berita;?></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>