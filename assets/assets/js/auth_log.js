
function showBasicMessage() {
    swal("Here's a message!");
}


function showWithTitleMessage() {
    swal("Here's a message!", "It's pretty, isn't it?");
}



function validasiMessage(){
    swal({
        title: "Dilarang!",
        text: "Data tidak boleh lebih dari jumlah permintaan!",
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

$('#loginform').submit(function(){
    var username = $('#username').val();
    var password = $('#password').val();
    var captcha  = $('#captcha').val();
    if (username != '' && password != '' && captcha != '') {
        $.ajax({
            type : "POST",
            url  : "Auth/cek_login",
            dataType : "json",
            data : $(this).serialize(),
            success: function(data){

                if(data.success){
                    window.location = data.link;
                } else {
                    showFailedMessage(data.alert);
                    $('#img_captcha').html(data.img_captcha);
                }
            }
        });

        return false;
    }

});