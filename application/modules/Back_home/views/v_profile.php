<div class="page-wrapper">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Profile</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        Profile
      </ol>
    </div>
  </div>
  <div class="container-fluid">
    <?php echo $this->session->flashdata('alert'); ?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">
              Data Profile
              <a href="<?=base_url();?>Back_home/edit_profile/<?=$profiles->id_profile;?>" class="btn btn-warning fa fa-edit float-right" title="Edit Profile"></a>
            </h4>
            <div class="table-responsive m-t-40">
              <?=$profiles->profile;?>
              <hr>
              <b><u>Visi:</u></b><br>
              <?=$profiles->visi;?>
              <hr>
              <b><u>Misi:</u></b><br>
              <?=$profiles->misi;?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>