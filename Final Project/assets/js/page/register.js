$(document).ready(function(){
    
  const dataRemote = $('#username').attr('data-remote');
  const dataTarget = $('#username').attr('data-target');

    $.validator.addMethod("huruf_cek", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
    });
    $.validator.addMethod("username_cek", function(value, element) {
        return this.optional(element) || /^[a-z0-9_]*$/.test(value);
    });
    function message(tipe, body) {
      $('#message').empty();
      if (tipe == "success") {
        $('#message').addClass('alert alert-success').html('<span class="glyphicon glyphicon-info-sign"></span> &nbsp;' + body);
      } else {
        $('#message').addClass('alert alert-danger').html('<span class="glyphicon glyphicon-info-sign"></span> &nbsp;' + body);
      }
    }
    function clearregister(id) {
      $(id).find('.form-group').attr('class','form-group has-feedback');
      $(id)[0].reset();
    }
    $('#register').validate({
      errorClass: 'has-error',
      validClass: 'has-success',
      rules: {
        name: {
            required: true,
            rangelength: [3, 35],
            huruf_cek: true,
        },
        username: {
            required: true,
            rangelength: [8,20],
            username_cek: true,
            remote : {
                    url: `${http}check?f=${dataRemote}&d=${dataTarget}`,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        username: () => $('#username').val()
                    }
            }
            
        },
        password: {
            required: true,
            rangelength: [8,25],
        },
        password_confirm: {
            required: true,
            rangelength: [8,25],
            equalTo: '#password1',
        }
      },
      messages: {
        name: {
            required: "Nama harus diisi !",
            rangelength: "Minimal 3 huruf dan Maksimal 25 huruf !",
            huruf_cek: "Tidak boleh mengandung simbol lain selain huruf !",
        },
        username: {
            required: "Username harus diisi !",
            rangelength: "Minimal 8 karakter dan maksimal 25 karakter !",
            username_cek: "Gunakan huruf kecil atau angka atau <i>Underscore</i> _",
            remote:"Username Tidak Dapat Digunakan!"
        },
        password: {
            required: "Password harus diisi",
            rangelength: "Minimal password 8 karakter dan maksimal 25 karakter",
        },
        password_confirm: {
            required: "Konfirmasi password harus diisi",
            rangelength: "Minimal password 8 karakter dan maksimal 25 karakter",
            equalTo: "Konfirmasi password harus sama dengan field password",
        }
      },
      highlight: function(element, errorClass, validClass) {
        $(element).parent('div').addClass(errorClass).removeClass(validClass);
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).parent('div').addClass(validClass).removeClass(errorClass);
      },
      submitHandler: function(form) {
        var register = new FormData($('#register')[0]);
        // console.log($('#register')[0][0]);
        $.ajax({
          url: http + 'api/v1/register',
          type: 'POST',
          async: true,
          cache: false,
          dataType: 'json',
          processData: false,
          contentType: false,
          timeout: 3000,
          data: register,
          beforeSend: function() {
            showLoading();
          },
          success: function(res) {
            if (res.length == 0) {
              hideLoading();
              message('error', 'Invalid response !');
            } else {
              if (res.register.code == 1) {
                message('success', res.register.message);
                clearregister('#register');
                setTimeout('window.location.href = http + "dashboard/";', 2000);
              } else {
                hideLoading();
                clearregister('#register'); 
                message('error', res.register.message);
              }
            }
          },
          error: function(jqXHR, status, error) {
            hideLoading();
            clearregister('#register');
            message('error', status);
          }
        });
        return false;
      }
    });
    
  });//penutup ready function
  