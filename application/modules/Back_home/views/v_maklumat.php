<div class="page-wrapper">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Maklumat</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        Maklumat
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
              Data maklumat
              <a href="<?=base_url();?>Back_home/edit_maklumat/<?=$maklumats->id_maklumat;?>" class="btn btn-warning fa fa-edit float-right" title="Edit Maklumat"></a>
            </h4>
            <div class="table-responsive m-t-40">
              <?=$maklumats->maklumat;?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>