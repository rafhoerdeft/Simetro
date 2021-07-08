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
        <h3 class="text-themecolor">Form Pengajuan Tera/Tera Ulang (<?= $nama_pasar ?>)</h3>
    </div>
    <div class="col-md-6 align-self-center">
        <ol class="breadcrumb">
            <!-- <label>Jenis Perlengkapan</label> -->
            <li class="breadcrumb-item"><a href="<?= base_url().'Admin/dataListSidang' ?>" class="text-danger">Daftar Sidang Tera</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url().'Admin/dataSidangTera/x/'.encode($id_sidang) ?>" class="text-danger">Daftar Pengajuan Tera</a></li>
            <li class="breadcrumb-item active">Pengajuan Tera</li>
        </ol>
    </div>
    <!-- <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
    </div> -->
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
        <div class="card-body p-b-20">
            <form id="pengajuanSidangTera" method="POST" action="<?= base_url().'Admin/pengajuanSidangTeraNew' ?>">
                <div class="modal-body">
                    

                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="nama_user" class="control-label">Nomor Order :</label>
                            <span class="text-danger" style="font-weight: bold"><?= $no_order ?></span>
                            <input type="hidden" name="no_order" id="no_order" value="<?= $no_order ?>">
                            <input type="hidden" name="id_sidang" id="id_sidang" value="<?= $id_sidang ?>">
                            <input type="hidden" name="id_pasar" id="id_pasar" value="<?= $id_pasar ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- <label for="layanan_order" class="control-label">Tanggal :</label> -->
                                </div>

                                <div class="col-md-8">
                                    <input type="hidden" name="tgl_daftar" required id="tgl_daftar" class="datepicker form-control" value="<?= date('d-m-Y', strtotime($tgl_sidang)) ?>">
                                </div>
                            </div>
                            <!-- <div> -->
                                <!-- <span class="text-danger float-right" style="font-weight: bold"><?= formatTanggal(date('d-m-Y')) ?></span> -->
                            <!-- </div> -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="layanan_order" class="control-label">Layanan :</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input name="layanan" value="tera ulang" type="radio" id="tera_ulang" class="with-gap radio-col-red" checked />
                                <label for="tera_ulang">Tera Ulang</label>
                            </div>
                            <div class="col-md-4">
                                <input name="layanan" value="tera" type="radio" id="tera" class="with-gap radio-col-indigo" />
                                <label for="tera">Tera</label>
                            </div>
                        </div>
                    </div>

                    

                    <!-- <?php 
                        foreach ($tempat_tera as $tmp) {
                            if ($tmp->tempat_tera == 'Pasar') { 
                    ?>
                                <input type="hidden" name="tempat" value="<?= $tmp->id_tempat_tera ?>" data-grup="<?= $tmp->grup ?>">
                    <?php }} ?> -->

                    <input type="hidden" name="id_user_pasar" id="id_user_pasar">

                    <label for="nama_user" class="control-label">Nama</label>
                    <div class="row">
                        <div class="form-group col-md-10">
                            <input required type="text" name="nama_user" id="nama_user" class="form-control" autocomplete="off" placeholder="">
                        </div>

                        <div class="col-md-2">
                            <button style="vertical-align: bottom;" type="button" class="btn btn-inverse btn-block" data-toggle="modal" data-target="#modal-cari"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat_user" class="control-label">Alamat</label>
                        <textarea required name="alamat_user" id="alamat_user" class="form-control"></textarea>
                    </div>
                    

                    <div id="timbangan" class="accordion m-b-30" role="tablist" aria-multiselectable="true">
                        <div class="card">
                            <a data-toggle="collapse" data-parent="#timbangan" href="#select_timbang" aria-expanded="true" aria-controls="collapseOne">
                                <div class="card-header bg-info" role="tab" id="headingOne">
                                    <h5 class="mb-0 text-white">
                                         Timbangan
                                    </h5>
                                </div>
                            </a>
                            <div id="select_timbang" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-body" id="jns_timbangan">

                                    <div id="row_timbang">

                                        <div class="jns_timbangan" id="timbang_1">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="id_jenis_alat" class="control-label">Jenis :</label>
                                                    <div class="controls">
                                                        <select required id="id_jenis_alat" name="id_jenis_alat[]" class="form-control" style="width: 100%; height:36px;" onchange="selectUttp(this)">
                                                            <option selected value="" disabled style="color: #d6d6d6">Pilih jenis alat</option>
                                                            <?php foreach ($dataJenisAlat as $key) { ?>
                                                                <option value="<?= $key->id_jenis_alat ?>"><?= $key->nama_jenis_alat ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="kapasitas" class="control-label">Kapasitas :</label>
                                                    <input required type="text" class="form-control" name="kapasitas[]" id="kapasitas">
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="jml_timbang" class="control-label">Jumlah :</label>
                                                    <input required type="text" class="form-control" name="jml_timbang[]" id="jml_timbang" onkeypress="return inputAngka(event);" style="text-align: center;" maxlength="4">
                                                </div>
                                            </div>
                                            
                                            <div id="trf_timbang"> </div>
                                        </div>

                                    </div>
                                    <!-- <hr>
                                    <button onclick="addTimbang()" class="btn bg-megna waves-effect waves-light text-white" type="button"><i class="fa fa-plus"></i> Tambah</button> -->

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="anak_timbang" class="accordion m-b-30" role="tablist" aria-multiselectable="true">
                        <div class="card">
                            <a data-toggle="collapse" data-parent="#anak_timbang" href="#select_anak_timbang" aria-expanded="true" aria-controls="collapseOne">
                                <div class="card-header bg-info" role="tab" id="headingOne">
                                    <h5 class="mb-0 text-white">
                                         Anak Timbangan
                                    </h5>
                                </div>
                            </a>
                            <div id="select_anak_timbang" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-body" id="jns_anak_timbangan">

                                    <div id="row_anak_timbang">
                                        <div class="jns_anak_timbangan" id="anak_timbang_1">

                                            <div class="row">
                                                <div class="form-group col-md-10">
                                                    <label for="id_tarif_anak_timbang" class="control-label">Jenis :</label>
                                                    <div class="controls">
                                                        <select id="id_tarif_anak_timbang" name="id_tarif_anak_timbang[]" class="form-control" style="width: 100%; height:36px;" onchange="activeJml(this)">
                                                            <option selected value="" style="color: #d6d6d6">Pilih jenis Anak Timbang</option>
                                                            <?php 
                                                                foreach ($ank_tbg['head'] as $head) { 
                                                            ?>
                                                                    <optgroup label="<?= $head ?>">
                                                                <?php
                                                                    foreach ($ank_tbg['data'] as $key) { 
                                                                        if ($key['head'] == $head) { 
                                                                ?>
                                                                            <option value="<?= $key['id_tarif'] ?>"><?= $key['jenis_tarif'] ?></option>
                                                                <?php }} ?>
                                                                    </optgroup>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- <div class="form-group col-md-4">
                                                    <label for="kapasitas" class="control-label">Kapasitas :</label>
                                                    <input required type="text" class="form-control" name="kapasitas" id="kapasitas">
                                                </div> -->

                                                <div class="form-group col-md-2">
                                                    <label for="jml_anak_timbang" class="control-label">Jumlah :</label>
                                                    <input required disabled="true" type="text" class="form-control" name="jml_anak_timbang[]" id="jml_anak_timbang" onkeypress="return inputAngka(event);" style="text-align: center;" maxlength="4">
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <hr>
                                    <button onclick="addAnakTimbang()" class="btn bg-megna waves-effect waves-light text-white" type="button"><i class="fa fa-plus"></i> Tambah</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="id_usaha" class="control-label">Pilih Usaha :</label>
                        <select required id="id_usaha" name="id_usaha" class="form-control" onchange="changeUsaha(this)">
                            <option selected value="" disabled style="color: #d6d6d6">Pilih usaha Anda yang tersedia</option>
                        </select>
                    </div> -->

                    <style type="text/css">
                        #tbl_tarif tbody tr:nth-child(even) {
                            background-color: #f2f2f2
                        }
                    </style>

                    <!-- <div id="data_uttp">
                        <input type="hidden" name="select_id_uttp" id="select_id_uttp">
                    </div> -->

                    <div id="total_tarif" class="m-t-30"> </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="kondisi" class="control-label">Kondisi :</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input name="kondisi" value="baik" type="radio" id="baik" class="with-gap radio-col-teal" checked />
                                    <label for="baik">Baik</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="kondisi" value="rusak" type="radio" id="rusak" class="with-gap radio-col-pink" />
                                    <label for="rusak">Rusak</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="tindakan" class="control-label">Tindakan :</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input name="tindakan" value="ditera" type="radio" id="ditera" class="with-gap radio-col-purple" checked />
                                    <label for="ditera">Ditera</label>
                                </div>
                                <div class="col-md-4">
                                    <input name="tindakan" value="diganti" type="radio" id="diganti" class="with-gap radio-col-orange" />
                                    <label for="diganti">Diganti</label>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group col-md-4">
                            <label for="berlaku" class="control-label">Berlaku s/d :</label>
                            <div>
                                <label class="text-danger" style="font-weight: bold;"><?= date('M Y', strtotime('+1 year')) ?></label>
                            </div>
                        </div> -->
                    </div>

                </div>

                <hr class="m-l-20 m-r-20">

                <!-- <div class="row p-20">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6"> </div>
                            <div class="col-md-6" style="text-align: right;">
                                <button type="button" onclick="cekTarif()" class="btn bg-megna btn-block waves-effect waves-light text-white float-right">
                                    <i class="fa">(Rp)</i> 
                                    Cek Total Bayar
                                </button>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="row p-20 float-right d-block d-sm-block d-md-none d-lg-none">
                    <div class="col-md-6">
                        <button type="button" onclick="batalSimpan()" class="btn btn-danger waves-effect m-r-5"><i class="fa fa-close"></i></button>
                        <button type="reset" onclick="resetAll()" class="btn btn-warning waves-effect m-r-5"><i class="fa fa-undo"></i></button>
                        <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan"><i class="fa fa-save"></i></button>
                    </div>
                </div>

                <div class="row p-20">                             
                    <!-- <input type="hidden" id="jml_group_uttp" name="jml_group_uttp" value="0"> -->
                    <div class="col-md-6 m-b-5">
                        <!-- <button type="button" onclick="cekTarif()" class="btn bg-megna waves-effect waves-light text-white"><i class="fa">(Rp)</i>  <span class="d-none d-sm-none d-md-block d-lg-block float-right m-l-5">Cek Total Bayar</span></button> -->
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4 m-b-5" style="text-align: right;">
                                <button type="button" onclick="batalSimpan()" class="btn btn-danger waves-effect waves-light btn-block d-none d-sm-none d-md-block d-lg-block"><i class="fa fa-close"></i> Batal</button>
                            </div>
                            <div class="col-md-4 m-b-5" style="text-align: right;">
                                <button type="reset" onclick="resetAll()" class="btn btn-warning waves-effect waves-light btn-block d-none d-sm-none d-md-block d-lg-block"><i class="fa fa-undo"></i> Reset</button>
                            </div>
                            <div class="col-md-4 m-b-5" style="text-align: right;">
                                <button type="submit" class="btn btn-info waves-effect waves-light btn-block d-none d-sm-none d-md-block d-lg-block" id="simpan_jalan"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

<div id="modal-cari" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <style type="text/css">
            ul.ui-autocomplete {
                z-index: 1100;
            }

        </style>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cari User Terdaftar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

                <div class="modal-body">
                    <div class="form-group">
                        <!-- <label for="users" class="control-label">Cari User Terdaftar :</label> -->
                        <input type="text" name="users" onchange="changeDataUser(this)" id="users" class="form-control autocomplete" autocomplete="off" placeholder="Ketik nama user yang terdaftar">
                        <div id="counter_found" style="font-size: 10pt; color: red"></div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
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

<script type="text/javascript">

    function resetAll(argument) {
        // removeAllUttp(0);
        var count = $(".jns_timbangan").length;
        for (var i = 2; i <= count; i++) {
            $("#row_timbang #timbang_"+i).remove();
        }

        $('#jns_timbangan #row_timbang #timbang_1 #trf_timbang').html('');

        var countx = $(".jns_anak_timbangan").length;
        for (var x = 2; x <= countx; x++) {
            $("#row_anak_timbang #anak_timbang_"+x).remove();
        }
        $('#row_anak_timbang #anak_timbang_1 #jml_anak_timbang').attr('disabled',true);
        
    }

    function changeUsaha(argument) {
        removeAllUttp(0);
        addUttp();
    }

    function addAnakTimbang(argument) {
        var count = $(".jns_anak_timbangan").length;
        var numb = count+1;
        var row =   '<div class="jns_anak_timbangan" id="anak_timbang_'+numb+'">'+
                        '<hr>'+
                        '<div style="margin-top: -15px; margin-bottom: 60px;">'+
                            '<button onclick="removeRowTimbang(this)" type="button" class="btn btn-sm btn-danger float-right" style="width: 50px; border-radius: 5px 5px 5px 50px;"><i class="fa fa-close"></i></button>'+
                        '</div>'+
                    '</div>';
        $('#jns_anak_timbangan #row_anak_timbang').append(row);
        $("#row_anak_timbang #anak_timbang_1 .row").clone().appendTo("#row_anak_timbang #anak_timbang_"+numb);
        $('#row_anak_timbang #anak_timbang_'+numb+' #jml_anak_timbang').attr('disabled',true);
        $('#row_anak_timbang #anak_timbang_'+numb+' #jml_anak_timbang').val('');
        // $("#row_timbang #timbang_1 #trf_timbang").clone().appendTo("#row_timbang #timbang_"+numb);
    }

    function removeRowTimbang(data) {
        var idTimbang = $(data).parent().parent().remove();
    }

    function addTimbang(argument) {
        var count = $(".jns_timbangan").length;
        var numb = count+1;
        var row =   '<div class="jns_timbangan" id="timbang_'+numb+'">'+
                        '<hr>'+
                        '<div style="margin-top: -15px; margin-bottom: 60px;">'+
                            '<button onclick="removeRowTimbang(this)" type="button" class="btn btn-sm btn-danger float-right" style="width: 50px; border-radius: 5px 5px 5px 50px;"><i class="fa fa-close"></i></button>'+
                        '</div>'+
                    '</div>';
        $('#jns_timbangan #row_timbang').append(row);
        $("#row_timbang #timbang_1 .row").clone().appendTo("#row_timbang #timbang_"+numb);
        $('#jns_timbangan #row_timbang #timbang_'+numb).append('<div id="trf_timbang"> </div>');

        $('#jns_timbangan #row_timbang #timbang_'+numb+' #kapasitas').val('');
        $('#jns_timbangan #row_timbang #timbang_'+numb+' #jml_timbang').val('');
        // $("#row_timbang #timbang_1 #trf_timbang").clone().appendTo("#row_timbang #timbang_"+numb);
    }

    function selectUttp(data) {
        var idTimbang = $(data).parent().parent().parent().parent().attr('id');

        var id_jenis_alat = $(data).val();
        $("#loading-show").fadeIn("slow");
        $.post("<?= base_url().'Admin/getDataTarifPasar' ?>", {id_jenis_alat:id_jenis_alat}, function(result){
            $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');
            var dt = JSON.parse(result);
            console.log(idTimbang);
            if (dt.response) { 

                var selectTarif =   '<div class="form-group" >'+
                                        '<label for="id_tarif_timbang" class="control-label">Tarif Retribusi Layanan Tera UTTP :</label>'+
                                        '<select required id="id_tarif_timbang" name="id_tarif_timbang[]" class="form-control">'+
                                            '<option selected value="" disabled style="color: #d6d6d6">Pilih jenis UTTP</option>'+
                                        '</select>'+
                                    '</div>';
                $('#select_timbang #jns_timbangan #row_timbang #'+idTimbang+' #trf_timbang').html(selectTarif);

                
                for (var x = 0; x < dt.head.length; x++) {
                    let head = dt.head[x];
                    var opt = '';
                    for (var i = 0; i < dt.data.length; i++) {
                        if (dt.data[i].head == head) {
                            opt += '<option data-parentId="'+dt.data[i].parent_id+'" data-childId="'+dt.data[i].child_id+'" value="'+dt.data[i].id_tarif+'">'+dt.data[i].jenis_tarif+'</option>';
                        }
                    }


                    var optGroup =  '<optgroup label="'+head+'">'+
                                    opt+
                                    '</optgroup>';
                    var addList;
                    if (dt.jmlArr == 1) {
                        addList = opt;
                    } else {
                        addList = optGroup;
                    }

                    $('#select_timbang #jns_timbangan #row_timbang #'+idTimbang+' #trf_timbang #id_tarif_timbang').append(addList);
                    
                }                
            }
        });
    }

    function changeTarif(data) {
        var uttp_group = $(data).parent().parent().parent().parent().attr('id');
        var id_group = uttp_group.split("-");
        var retrif = $(data).parent().parent().attr('id');
        var id_retrif = retrif.split("-");
        var tarif = $('#'+uttp_group+' #tarif_'+id_retrif[1]).val();
        if (tarif != '') {
            // alert(parseInt(id_retrif[1])+1);
            var child_id = $('#'+uttp_group+' #tarif_'+id_retrif[1]+' option:selected').attr('data-childId');
            var parent_id = $('#'+uttp_group+' #tarif_'+id_retrif[1]+' option:selected').attr('data-parentId');
            var id_tarif = $('#'+uttp_group+' #tarif_'+id_retrif[1]+' option:selected').attr('value');
            subTarif(id_tarif, parent_id, child_id, uttp_group, parseInt(id_group[1]), parseInt(id_retrif[1]));
        }
    }

    function subTarif(id_tarif='', parent_id='', child_id='', uttp_group='', id_group='', id_retrif='') {
        var new_id_retrif = id_retrif+1;
        $("#loading-show").fadeIn("slow");
        $.post("<?= base_url().'Admin/getListTarif' ?>", {id_tarif:id_tarif, parent_id:parent_id, child_id:child_id}, function(result){
            $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');
            var dt = JSON.parse(result);
            // console.log(dt.data);
            if (dt.response) {
                $('#group_tot_bayar').remove();
                $('#'+uttp_group+' #listTarif #list_tarif_'+id_group).remove();
                $('#'+uttp_group+' #input_id_tera input').remove();
                for (var i = new_id_retrif; i < 5; i++) {
                    $('#'+uttp_group+' #retribusi-'+i+' #group_tarif_'+i).remove();
                }
                if (child_id == '0') {
                    var nama_jenis_tarif = dt.data[0].jenis_tarif;
                    var accord = '<div id="list_tarif_'+id_group+'" class="accordion m-b-30" role="tablist" aria-multiselectable="true">'+
                                    '<div class="card">'+
                                        '<a data-toggle="collapse" data-parent="#list_tarif_'+id_group+'" href="#select_tarif_'+id_group+'" aria-expanded="true" aria-controls="collapseOne">'+
                                            '<div class="card-header bg-info" role="tab" id="headingOne">'+
                                                '<h5 class="mb-0 text-white">'+
                                                     'Tarif '+nama_jenis_tarif+
                                                '</h5>'+
                                            '</div>'+
                                        '</a>'+
                                        '<div id="select_tarif_'+id_group+'" class="collapse show" role="tabpanel" aria-labelledby="headingOne">'+
                                            '<div class="card-body" id="content_tarif">'+
                                                'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                    $('#'+uttp_group+' #listTarif').html(accord);
                    var tbl_tarif = '<table id="tbl_tarif" border="1" width="100%" style="border-color: white; font-size: 10pt" cellpadding="5px">'+
                                        '<thead align="center" class="bg-megna  text-white" style="border-color: white">'+
                                            '<tr>'+
                                                '<th rowspan="3">Spesifikasi UTTP</th>'+
                                                '<th rowspan="3">Satuan</th>'+
                                                '<th colspan="4">Tarif</th>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<th colspan="2">Tera</th>'+
                                                '<th colspan="2">Tera Ulang</th>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<th>Kantor (Rp)</th>'+
                                                '<th>Tempat Pakai (Rp)</th>'+
                                                '<th>Kantor (Rp)</th>'+
                                                '<th>Tempat Pakai (Rp)</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                        '</tbody>'+
                                    '</table>';
                    $('#'+uttp_group+' #listTarif #list_tarif_'+id_group+' #content_tarif').html(tbl_tarif);
                    var tera_kantor = dt.data[0].tera_kantor.toString();
                    var tera_tempat_pakai = dt.data[0].tera_tempat_pakai.toString();
                    var tera_ulang_kantor = dt.data[0].tera_ulang_kantor.toString();
                    var tera_ulang_tempat_pakai = dt.data[0].tera_ulang_tempat_pakai.toString();
                    var pilihTarif = '<tr style="height: 45px">'+
                                        '<td>'+dt.data[0].jenis_tarif+'</td>'+
                                        '<td align="center" width="10%">'+dt.data[0].satuan+'</td>'+
                                        '<td align="right" width="12%">'+formatRupiah(tera_kantor, 'Rp.')+'</td>'+
                                        '<td align="right" width="12%">'+formatRupiah(tera_tempat_pakai, 'Rp.')+'</td>'+
                                        '<td align="right" width="12%">'+formatRupiah(tera_ulang_kantor, 'Rp.')+'</td>'+
                                        '<td align="right" width="12%">'+formatRupiah(tera_ulang_tempat_pakai, 'Rp.')+'</td>'+
                                    '</tr>';
                    $('#'+uttp_group+' #listTarif #list_tarif_'+id_group+' #content_tarif #tbl_tarif tbody').html(pilihTarif);
                    $('#'+uttp_group+' #input_id_tera').html('<input type="hidden" id="id_tarif_'+id_group+'" name="id_tarif[]" value="'+dt.data[0].id_tarif+'">');
                } else {
                    var selectTarif =   '<div class="form-group" id="group_tarif_'+new_id_retrif+'">'+
                                            '<label for="tarif_'+new_id_retrif+'" class="control-label">Sub Tarif '+id_retrif+' :</label>'+
                                            '<select required id="tarif_'+new_id_retrif+'" name="tarif_'+new_id_retrif+'[]" class="form-control" onchange="changeTarif(this)">'+
                                                '<option selected value="" disabled style="color: #d6d6d6">Pilih jenis layanan UTTP</option>'+
                                            '</select>'+
                                        '</div>';
                    $('#'+uttp_group+' #retribusi-'+new_id_retrif).html(selectTarif);
                    var opt = '';
                    for (var i = 0; i < dt.data.length; i++) {
                        opt += '<option data-parentId="'+dt.data[i].parent_id+'" data-childId="'+dt.data[i].child_id+'" value="'+dt.data[i].id_tarif+'">'+dt.data[i].jenis_tarif+'</option>';
                    }
                    $('#'+uttp_group+' #retribusi-'+new_id_retrif+' #tarif_'+new_id_retrif).append(opt);
                }
            }
        });
    }

    function removeAllUttp(id_first=0) {
        var count = $('#jml_group_uttp').val();
        for (var i = id_first; i <= count; i++) {
            if (i > id_first) {
                $('#uttp-'+i).remove();
                var xx = $('#jml_group_uttp').val();
                $('#jml_group_uttp').val(parseInt(xx)-1);
            }
        }
    }

    function removeUttp(data) {
        var count = $('#jml_group_uttp').val();
        $('#jml_group_uttp').val(parseInt(count)-1);
        $(data).parent().parent().parent().remove();
        $('#group_tot_bayar').remove();
    }

    function cekTarif(argument) {
        // var count = $('#jml_group_uttp').val();
        var layanan = $("#pengajuanSidangTera input[type='radio'][name='layanan']:checked").val();
        var tempat = $("#pengajuanSidangTera input[type='hidden'][name='tempat']").attr('data-grup');
        var trf_timbang = $('#timbangan #trf_timbang #id_tarif_timbang').val();
        var trf_anak_timbang = $('#anak_timbang #select_anak_timbang #id_tarif_anak_timbang').val();

        // console.log(trf_anak_timbang);
        // var usaha = $('#id_usaha').val();
        if (trf_timbang != 'undefined' || trf_timbang != null ) {
            var id_tarif = '';

            // if () {}
        //     var counter_tarif = 0;
        //     for (var i = 1; i <= count; i++) {
        //         var idTarif = $('#id_tarif_'+i).val();
        //         if (idTarif === undefined) {
        //             let tarifUttp = $('#uttp-'+i+' #id_uttp option:selected').attr('data-tarif');
        //             if (tarifUttp != 'null') {
        //                 counter_tarif++;
        //                 if (i == count) {
        //                     id_tarif += tarifUttp;
        //                 } else {
        //                     id_tarif += tarifUttp+',';
        //                 }
        //             } else {
        //                 alert('UTTP dan tarif ke-'+i+' belum dipilih!');
        //             }
        //         } else {
        //             counter_tarif++;
        //             if (i == count) {
        //                 id_tarif += idTarif;
        //             } else {
        //                 id_tarif += idTarif+',';
        //             }
        //         }
        //     }
        //     if (counter_tarif == count) {
        //         var uttp_id = '';
        //         for (var i = 1; i <= count; i++) {
        //             var idUttp = $('#uttp-'+i+' #id_uttp').val();
        //             if (i == count) {
        //                 uttp_id += idUttp;
        //             } else {
        //                 uttp_id += idUttp+',';
        //             }
        //         }
        //         var jml_uttp = '';
        //         var counter_jml = 0;
        //         for (var i = 1; i <= count; i++) {
        //             var jmlUttp = $('#uttp-'+i+' #jumlah_uttp').val();
        //             if (jmlUttp !== '') {
        //                 counter_jml++;
        //                 if (i == count) {
        //                     jml_uttp += jmlUttp;
        //                 } else {
        //                     jml_uttp += jmlUttp+',';
        //                 }
        //             } else {
        //                 alert('Jumlah UTTP ke-'+i+' belum diisi!');
        //             }
        //         }
        //         if (counter_jml == count) {
                    $("#loading-show").fadeIn("slow");
                    $.post("<?= base_url().'Admin/cekTarif' ?>", {id_tarif:id_tarif, uttp_id:uttp_id, jml_uttp:jml_uttp, layanan:layanan, tempat:tempat}, function(result){
                        $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');
                        var dt = JSON.parse(result);
                        // console.log(dt.data);
                        if (dt.response) {
                            var tbl_total = '<div id="group_tot_bayar">'+  
                                                '<hr>'+
                                                '<h4>Total Bayar</h4>'+
                                                '<table id="tbl_tarif" border="1" width="100%" style="border-color: white; font-size: 10pt" cellpadding="5px">'+
                                                    '<thead align="center" class="bg-megna  text-white" style="border-color: white">'+
                                                        '<tr style="height: 40px">'+
                                                            '<th width="20%">UTTP</th>'+
                                                            '<th width="25%">Spesifikasi UTTP</th>'+
                                                            '<th width="5%">Satuan</th>'+
                                                            '<th width="10%">Layanan</th>'+
                                                            '<th width="10%">Tempat</th>'+
                                                            '<th width="5%">Jumlah</th>'+
                                                            '<th width="10%">Tarif (Rp)</th>'+
                                                            '<th width="10%">Total (Rp)</th>'+
                                                        '</tr>'+
                                                    '</thead>'+
                                                    '<tbody></tbody>'+
                                                    '<tfoot></tfoot>'+
                                                '</table>'+
                                            '</div>';
                            $('#pengajuanSidangTera #total_tarif').html(tbl_total);
                            var list_total = '';
                            var total_all_tarif = 0;
                            for (var i = 0; i < dt.data.length; i++) {
                                var trf = dt.data[i].tarif.toString();
                                var tot_trf = dt.data[i].tot_tarif.toString();
                                var kapasitas = '';
                                if (dt.data[i].kapasitas !== ' -' && dt.data[i].kapasitas !== '-' && dt.data[i].kapasitas !== '' && dt.data[i].kapasitas !== null) {
                                    kapasitas = dt.data[i].kapasitas;
                                }
                                list_total += '<tr style="height: 40px">'+
                                            '<td>'+dt.data[i].jenis_alat+' '+kapasitas+'</td>'+
                                            '<td>'+dt.data[i].jenis_tarif+'</td>'+
                                            '<td align="center">'+dt.data[i].satuan+'</td>'+
                                            '<td align="center">'+dt.data[i].layanan+'</td>'+
                                            '<td align="center">'+dt.data[i].tempat+'</td>'+
                                            '<td align="center">'+dt.data[i].jumlah+'</td>'+
                                            '<td align="right">'+formatRupiah(trf, 'Rp.')+'</td>'+
                                            '<td align="right">'+formatRupiah(tot_trf, 'Rp.')+'</td>'+
                                        '</tr>';
                                total_all_tarif += dt.data[i].tot_tarif;
                            }
                            var tot_byr = total_all_tarif.toString();
                            var total_bayar =   '<tr class="bg-megna text-white" style="border-color: white; height: 40px">'+
                                                    '<td align="center" colspan="7" style="font-weight: bold">Total Bayar</td>'+
                                                    '<td align="right"  style="font-weight: bold">'+formatRupiah(tot_byr, 'Rp.')+'</td>'+
                                                '</tr>';
                            $('#total_tarif #tbl_tarif tbody').html(list_total);
                            $('#total_tarif #tbl_tarif tfoot').html(total_bayar);
                        }
                    });
                    // alert(id_tarif);
        //         }
        //     }
        } else {
            alert('Pilih jenis timbangan!');
        }
    }

    function batalSimpan(argument) {
        swal({
            title: "Batalkan Pengajuan?",
            text: "Anda ingin membatalkan pengajuan?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Batal!",
            closeOnConfirm: false
        }, function () {
            location = "<?= base_url().'Admin/dataSidangTera' ?>";
        });
    }

    function activeJml(data) {
        var select = $(data).val();
        var idTimbang = $(data).parent().parent().parent().parent().attr('id');
        // console.log(select);
        if (select != null && select != '') {
            $('#row_anak_timbang #'+idTimbang+' #jml_anak_timbang').attr('disabled',false);
        } else {
            $('#row_anak_timbang #'+idTimbang+' #jml_anak_timbang').attr('disabled',true);
        }
    }
    // $('#pengajuanSidangTera').on('submit', function(e){
    //     e.preventDefault();
    //     alert('id');
    // });
</script>

<script type="text/javascript">
    // rupiah2.value = formatRupiah(this.value, 'Rp. ');
    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }
</script>

<script type="text/javascript">
    function getDataUsaha(id_user) {
        $("#loading-show").fadeIn("slow");
        $.post("<?= base_url().'Admin/getDataUsaha' ?>", {id_user:id_user}, function(result){
            $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');
            var dt = JSON.parse(result);
            // console.log(dt.data);
            if (dt.response) {
                var opt = '';
                opt += '<option selected value="" disabled style="color: #d6d6d6">Pilih usaha Anda yang tersedia</option>';
                for (var i = 0; i < dt.data.length; i++) {
                    var nama_usaha = '';
                    if (dt.data[i].nama_usaha != null) {
                        nama_usaha = ' - '+dt.data[i].nama_usaha;
                    }
                    opt += '<option value="'+dt.data[i].id_usaha+'">'+dt.data[i].jenis_usaha+nama_usaha+'</option>';
                }
                $('#pengajuanSidangTera #id_usaha').html(opt);
                removeAllUttp(0);
            }
        });
    }

    function clearDataUsaha() {
        var opt = '<option selected value="" disabled style="color: #d6d6d6">Pilih nama user yang terdaftar</option>';
        $('#pengajuanSidangTera #id_usaha').html(opt);
        removeAllUttp(0);
    }

    function changeDataUser(data) {
        var cek = $('#pengajuanSidangTera #id_user_pasar').val();
        if (cek != '' || cek != null) {

            // $("#loading-show").fadeIn("slow");
            $.post("<?= base_url().'Admin/getDataUserPasar' ?>", {id_user_pasar:cek}, function(result){
                // $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');
                var dt = JSON.parse(result);

                if (dt.response) {
                    $('#pengajuanSidangTera #nama_user').val(dt.data.nama_user);
                    $('#pengajuanSidangTera #alamat_user').val(dt.data.alamat_user);
                }

            });

        } else {
            $(data).val('');
            // var opt = '<option selected value="" disabled style="color: #d6d6d6">Pilih nama user yang terdaftar</option>';
            // $('#pengajuanSidangTera #id_usaha').html(opt);
            // removeAllUttp(0);
        }
    }

    function activeSelectId(data) {
        var jml = $(data).val();

        if (jml != '' && jml != null && jml != '0') {
            $('#id_jenis_alat').attr('disabled', false);
        } else {
            $('#id_jenis_alat').attr('disabled', true);
        }
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
