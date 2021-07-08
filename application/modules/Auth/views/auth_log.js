$('#loginform').submit(function(){
    var username = $('#username').val();
    var password = $('#password').val();

    $.ajax({
        type : "POST",
        url  : "Auth/cek_login",
        dataType : "json",
        data : {username:username , password:password},
        success: function(data){

            if(data.success){
                window.location = data.link;
            } else {
                showFailedMessage('Username atau Password Salah!');
            }
        }
    });

    return false;

});