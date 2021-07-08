	<style type="text/css">
		.bigdrop {
		    width: 300px !important;
		}
	</style>

        <div style="z-index: 20; top: 40%; left: 47%; position: fixed; display:none;" id="loading-show">
            <img src="<?= base_url().'assets/loading/loading3.gif' ?>" width="100">
        </div>  

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-6 align-self-center">
                    <h3 class="text-themecolor">Laporan Perlengkapan Jalan</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <select id="jenisPj" class="selectpicker" data-style="form-control btn-secondary float-right" onchange="changeJenisPj();">
                            <!-- <option disabled=''>Pilih Jenis Perlengkapan</option> -->
                            <?php foreach ($jenisPj as $pj) { ?>
                                <option value="<?= encode($pj->id_jenis) ?>" <?= ($pj->id_jenis == $idSelectPj?'selected':'') ?>><?= $pj->nama_jenis ?></option>
                            <?php } ?> 
                        </select>
                    </ol>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <?= $this->session->flashdata('alert') ?>

                <div class="row">
                    <div id="loading" class="col-md-12" style="margin-bottom: -25px; margin-top: -50px; text-align: center; display:none;">
                        <img src="<?= base_url().'assets/loading/loading1.gif' ?>" width="100" >
                    </div>
                </div>

                 <div class="card">
                    <div class="card-body">
                    	<div class="row">
	                    	<div class="col-md-2 m-b-5">
		                    	<select class="form-control" id="select_thn_pj">
		                    		<option value="<?= encode('all') ?>">Tahun</option>
		                    		<?php foreach ($thn_pj as $key) {?>
		                    			<option value="<?=encode($key->thn_pj);?>" <?= ($select_thn_pj==$key->thn_pj?'selected':'') ?>><?=$key->thn_pj?></option>
		                    		<?php } ?>
		                    	</select>
		                    </div>

	                    	<div class="col-md-2 m-b-5">
		                    	<select class="select2 form-control custom-select" id="select_kode_kecamatan" style="width: 100%;">
		                    		<option value="<?= encode('all') ?>">Kecamatan</option>
		                    		<?php foreach ($kode_kecamatan as $key) {?>
		                    			<option value="<?=encode($key->kode_kecamatan)?>" <?= ($select_kode_kecamatan==$key->kode_kecamatan?'selected':'') ?>><?=$key->nama_kecamatan?></option>
		                    		<?php } ?>
		                    	</select>
		                    </div>

	                    	<div class="col-md-2 m-b-5">
		                    	<select class="select2 form-control custom-select" id="select_ruas_jalan" style="width: 100%;">
		                    		<option value="<?= encode('all') ?>">Ruas Jalan</option>
		                    		<?php foreach ($ruas_jalan as $key) {?>
		                    			<option value="<?=encode($key->id_jalan)?>" <?= ($select_id_jalan==$key->id_jalan?'selected':'') ?>><?=$key->nama_jalan?></option>
		                    		<?php } ?>
		                    	</select>
		                    </div>

		                    <div class="col-md-2 m-b-5">
			                    <select class="form-control" id="select_kondisi">
		                    		<option value="<?= encode('all') ?>" >Kondisi</option>
		                    		<option value="<?= encode('Baik')?>" <?= ($select_kondisi_pj=='Baik'?'selected':'') ?>>Baik</option>
		                    		<option value="<?= encode('Rusak')?>" <?= ($select_kondisi_pj=='Rusak'?'selected':'') ?>>Rusak</option>
		                    	</select>     
		                    </div>

		                    <?php if ($idSelectPj=='1') {?>
	                    		<div class="col-md-2 m-b-5">
		                    		<select class="form-control" id="select_jenis">
			                    		<option value="<?= encode('all') ?>">Jenis Lampu</option>
			                    		<?php foreach ($jenis_lampu as $key) {?>
			                    			<option value="<?=encode($key->id_jenis_lampu)?>" <?= ($select_jenis==$key->id_jenis_lampu?'selected':'') ?>><?=$key->jenis_lampu?></option>
			                    		<?php } ?>
			                    	</select>
			                    </div>
	                    	<?php } else if ($idSelectPj=='3'){?>
	                    		<div class="col-md-2 m-b-5">
		                    		<select class="form-control" id="select_jenis">
			                    		<option value="<?= encode('all') ?>">Jenis Rambu</option>
			                    		<?php foreach ($jenis_rambu as $key) {?>
			                    			<option value="<?=encode($key->id_jenis_rambu) ?>" <?= ($select_jenis==$key->id_jenis_rambu?'selected':'') ?>><?=$key->jenis_rambu?></option>
			                    		<?php } ?>    	
			                    	</select>
			                    </div>
		                    <?php } else {?>
		                    	<div class='col-md-2 m-b-5'></div>
		                    <?php } ?>	   

	                    	<div class="col-md-2 d-block d-sm-block d-md-block d-lg-none m-b-5">
		                    	<button type="button" class="btn btn-block btn-info waves-effect" data-toggle="tooltip" data-placement="top" data-original-title="View" onclick="viewPJ()"><i class="fa fa-eye"></i> View</button>
		                    	<button type="button" class="btn btn-block btn-success waves-effect" data-toggle="tooltip" data-placement="top" data-original-title="Cetak Excel" onclick="exportPj()"><i class="mdi mdi-file-excel"></i> Export</button>                  	
		                    </div>

		                    <div class="col-md-2 d-none d-sm-none d-md-none d-lg-block text-center m-b-5">
		                    	<button type="button" class="btn btn-info waves-effect" data-toggle="tooltip" data-placement="top" data-original-title="View" onclick="viewPJ()"><i class="fa fa-eye"></i></button>
		                    	<button type="button" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" data-original-title="Cetak Excel" onclick="exportPj()"><i class="mdi mdi-file-excel"></i></button>
		                    </div>

	                    	<!-- <button type="button" class="btn btn-info waves-effect" data-toggle="tooltip" data-placement="top" data-original-title="View" onclick="viewPJ()"><i class="fa fa-eye"></i></button> -->
	                    	<!-- &nbsp; -->
	                    	<!-- <button type="button" class="btn btn-success waves-effect" data-toggle="tooltip" data-placement="top" data-original-title="Cetak Excel"><i class="mdi mdi-file-excel"></i></button> -->
	                    </div>
	                </div>
                </div>

                <div class="card">
                    <div class="card-body p-b-20">
                        <!-- <button type="button" onclick="showModalAdd()" class="btn waves-effect waves-light btn-primary float-right" data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fa fa-plus"></i> Tambah User</button> -->

                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped table-hover">

                                <thead>
                                    <tr style="font-size: 11pt">
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Tahun</th>
                                        <th>Kecamatan</th>
                                        <th>Ruas Jalan</th>
                                        <?php if ($idSelectPj == '1') { ?>
                                            <th>Jenis Lampu</th>
                                        <?php } else if ($idSelectPj == '3') {?>
                                            <th>Jenis Rambu</th>
                                        <?php } else if ($idSelectPj == '4') {?>
                                            <th>Panjang (M)</th>
                                        <?php } else if ($idSelectPj == '5') {?>
                                            <th>Lebar Jalan (M)</th>
                                        <?php } else if ($idSelectPj == '7') {?>
                                            <th>KWH Meter</th>
                                            <th>Abonemen</th>
                                        <?php } ?>
                                        <th>Kondisi</th>
                                        <!-- <th>Foto</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($dataPj as $pj) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 10pt">
                                                <td align="center"><?= $no ?></td>
                                                <td><?= $pj->nama_pj ?></td>
                                                <td align="center"><?= $pj->thn_pj ?></td>
                                                <td align="center"><?= $pj->kecamatan ?></td>
                                                <td><?= $pj->nama_jalan ?></td>

                                                <?php if ($idSelectPj == '1') { ?>
                                                    <td align="center"><?= $pj->jenis_lampu ?></td>
                                                <?php } else if ($idSelectPj == '3') {?>
                                                    <td align="center"><?= $pj->jenis_rambu ?></td>
                                                <?php } else if ($idSelectPj == '4') {?>
                                                    <td align="center"><?= $pj->pjg_guardrail ?></td>
                                                <?php } else if ($idSelectPj == '5') {?>
                                                    <td align="center"><?= $pj->lebar_jalan ?></td>
                                                <?php } else if ($idSelectPj == '7') {?>
                                                    <td align="center"><?= $pj->kwh_meter ?></td>
                                                    <td align="center"><?= $pj->abonemen ?></td>
                                                <?php } ?>
                                                
                                                <td align="center"><?= $pj->kondisi_pj ?></td>
                                                <!-- <td align="center">
                                                    <?php  
                                                        // $photo = explode(';', $pj->foto_pj);
                                                        // $i = 0;
                                                        // foreach ($photo as $x) { 
                                                        //     $i++;
                                                    ?>
                                                            <a href="<?//= base_url().'assets/path_foto/'.$x ?>" data-lightbox="<?= $pj->id_pj ?>" data-toggle="lightbox" data-gallery="gallery"><button style="width: 60px;" type="button" class="btn btn-sm waves-effect waves-light btn-primary m-b-5" data-toggle="tooltip" data-placement="top" title="Foto <?= $i; ?>"><i class="fa fa-picture-o"></i> Pic <?= $i; ?></button></a>
                                                            <br>
                                                    <?php //} ?>
                                                </td> -->
                                            </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Modal Simpan -->
            <div id="modal-simpan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="tambahDataUser" method="POST" action="<?= base_url().'Admin/tambahDataUser' ?>" novalidate>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="nama_user" class="control-label">Nama User :</label>
                                    <div class="controls">
                                        <input required data-validation-required-message="Nama user harus diisi" type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Isi nama user">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jk_user" class="control-label">Jenis Kelamin :</label>
                                    <div class="controls">
                                        <select id="jk_user" name="jk_user" class="form-control">
                                            <option id="Laki-Laki" value="Laki-Laki">Laki-Laki</option>
                                            <option id="Perempuan" value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="username" class="control-label">Username :</label>
                                    <div class="controls">
                                        <input required data-validation-required-message="Username harus diisi" type="text" class="form-control" name="username" id="username" placeholder="Isi username untuk login">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label">Password :</label>
                                    <div class="controls">
                                        <input required data-validation-required-message="Nama user harus diisi" type="text" class="form-control" name="password" id="password" placeholder="Isi password untuk login">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="role" class="control-label">Role :</label>
                                    <div class="controls">
                                        <select id="role" name="id_role" class="form-control">
                                            <?php foreach ($data_role as $role) { ?>
                                                <option id="<?= $role->id_role ?>" value="<?=$role->id_role ?>"><?=$role->role ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="pjg_jln" class="control-label">Username:</label><br>
                                    <div class="controls">
                                        <input required data-validation-required-message="Username harus diisi" type="text"  onkeypress="return inputAngka(event);" class="form-control" name="pjg_jln" id="pjg_jln" style="width: 150px"> Km
                                    </div>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label for="message-text" class="control-label">Message:</label>
                                    <textarea class="form-control" id="message-text"></textarea>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabels" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Data User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateDataUser" method="POST" action="<?= base_url().'Admin/updateDataUser' ?>" novalidate>
                            <div class="modal-body">

                                <input type="hidden" name="id_user" id="id_user">

                                <div class="form-group">
                                    <label for="nama_user" class="control-label">Nama User :</label>
                                    <div class="controls">
                                        <input required data-validation-required-message="Nama user harus diisi" type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Isi nama user">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jk_user" class="control-label">Jenis Kelamin :</label>
                                    <div class="controls">
                                        <select id="jk_user" name="jk_user" class="form-control">
                                            <option id="Laki-Laki" value="Laki-Laki">Laki-Laki</option>
                                            <option id="Perempuan" value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="username" class="control-label">Username :</label>
                                    <div class="controls">
                                        <input required data-validation-required-message="Username harus diisi" type="text" class="form-control" name="username" id="username" placeholder="Isi username untuk login">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label">Password :</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="password" id="password" placeholder="Isi password jika ingin rubah password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="role" class="control-label">Role :</label>
                                    <div class="controls">
                                        <select id="role" name="id_role" class="form-control">
                                            <?php foreach ($data_role as $role) { ?>
                                                <option id="<?= $role->id_role ?>" value="<?=$role->id_role ?>"><?=$role->role ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="pjg_jln" class="control-label">Username:</label><br>
                                    <div class="controls">
                                        <input required data-validation-required-message="Username harus diisi" type="text"  onkeypress="return inputAngka(event);" class="form-control" name="pjg_jln" id="pjg_jln" style="width: 150px"> Km
                                    </div>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label for="message-text" class="control-label">Message:</label>
                                    <textarea class="form-control" id="message-text"></textarea>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

            <script type="text/javascript">
                function changeJenisPj() {
                    var id = $('#jenisPj option:selected').attr('value');
                    window.location = "<?= base_url().'Admin/laporan/' ?>" + id;
                }
            </script>

            <script type="text/javascript">
            	function viewPJ(){
            		var id = '<?= encode($idSelectPj) ?>';
            		var thn = $('#select_thn_pj').val() ;
            		var kec = $('#select_kode_kecamatan').val();
            		var ruas = $('#select_ruas_jalan').val(); 
            		var kondisi = $('#select_kondisi').val();
            		// var jenis = $('#select_jenis').val();
            		var jns = document.getElementById("select_jenis");

            		if (jns) {
            			var jenis = jns.value;
            		} else {
            			var jenis = '<?=encode('all')?>';
            		}
            		// alert(jenis);

            		a="<?=base_url('Admin/laporan/')?>"+id+"/"+thn+"/"+kec+"/"+ruas+"/"+kondisi+"/"+jenis;
            		// alert(a);
            		location.href=a;
            		
            	}
                
                function exportPj(){
                    var id = '<?= encode($idSelectPj) ?>';
                    var thn = $('#select_thn_pj').val() ;
                    var kec = $('#select_kode_kecamatan').val();
                    var ruas = $('#select_ruas_jalan').val(); 
                    var kondisi = $('#select_kondisi').val();
                    // var jenis = $('#select_jenis').val();
                    var jns = document.getElementById("select_jenis");

                    if (jns) {
                        var jenis = jns.value;
                    } else {
                        var jenis = '<?=encode('all')?>';
                    }
                    // alert(jenis);

                    a="<?=base_url('Admin/printLaporan/')?>"+id+"/"+thn+"/"+kec+"/"+ruas+"/"+kondisi+"/"+jenis;
                    // alert(a);
                    location.href=a;                    
                }
            </script>


        <!-- Fungsi Dialog -->
        <script type="text/javascript">
            //These codes takes from http://t4t5.github.io/sweetalert/
            function showBasicMessage() {
                swal("Here's a message!");
            }

            function showWithTitleMessage() {
                swal("Here's a message!", "It's pretty, isn't it?");
            }

            function validasiMessage(text){
                swal({
                    title: "Dilarang!",
                    text: text,
                    type: "error",
                    timer: 1000,
                    showConfirmButton: false
                });
            }

            function showSuccessMessage(input) {
                swal({
                    title: input+"!",
                    text: "Data Berhasil "+input+"!",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
            }

            function showFailedMessage(input) {
                swal({
                    title: "Gagal!",
                    text: input,
                    type: "error",
                    timer: 1000,
                    showConfirmButton: false
                });
            }

            function showCancelMessage() {
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    } else {
                        swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
            }
        </script>


        <!-- SIMPAN USER =========================================== -->
        <script type="text/javascript">
            function showModalAdd(argument) {
                $('#modal-simpan #tambahDataUser').trigger("reset");
                $('#modal-simpan').modal('show');
            }
        </script>
        <!-- ======================================================= -->

        <!-- UPDATE USER =========================================== -->
        <script type="text/javascript">

            function showModalEdit(data) {
                var id_user = $(data).attr('data-id');
                var nama_user = $(data).attr('data-nama');
                var jk_user = $(data).attr('data-jk');
                var username = $(data).attr('data-username');
                var role = $(data).attr('data-role');

                $('#modal-edit #id_user').val(id_user);
                $('#modal-edit #nama_user').val(nama_user);
                $('#modal-edit #jk_user').val(jk_user).prop('selected',true);
                $('#modal-edit #username').val(username);
                $('#modal-edit #role').val(role).prop('selected',true);
                $('#modal-edit').modal('show');
            }

        </script>
        <!-- ======================================================= -->

        <!-- HAPUS USER ================================= -->
        <script type="text/javascript">
            function showConfirmMessage(id) {
                swal({
                    title: "Anda yakin data akan dihapus?",
                    text: "Data tidak akan dapat di kembalikan lagi!!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type : "POST",
                        url  : "<?php echo base_url('Admin/deleteDataUser')?>",
                        dataType : "html",
                        data : {id:id},
                        success: function(data){
                            // alert(data);
                            // $('#myTable').DataTable().destroy();
                            // $('#myTable').DataTable().draw();

                            if(data=='Success'){
                                location.reload();
                            }else{
                                location.reload();
                            } 
                        }
                    });
                    return false;
                    // swal("Hapus!", "Data telah berhasil dihapus.", "success");
                });
            }
        </script>
            