$(document).ready(function(){
  function message(tipe, body) {
    $('#message').empty();
    if (tipe == "success") {
      $('#message').addClass('alert alert-success').html('<span class="glyphicon glyphicon-info-sign"></span> &nbsp;' + body);
    } else {
      $('#message').addClass('alert alert-danger').html('<span class="glyphicon glyphicon-info-sign"></span> &nbsp;' + body);
    }
  }
  function clearLogin(id) {
    $(id).find('.form-group').attr('class','form-group has-feedback');
    $(id)[0].reset();
  }
  $('#login').validate({
    errorClass: 'has-error',
    validClass: 'has-success',
    rules: {
      username : {
        required: true,
        minlength: 8
      },
      password : {
        required: true,
        minlength: 8
      }
    },
    messages: {
      username: {
        required: "Masukan Username !",
        minlength: "Username minimal harus 8 karakter !"
      },
      password: {
        required: "Masukan Password !",
        minlength: "Password minimal harus 8 karakter !"
      }
    },
    highlight: function(element, errorClass, validClass) {
      $(element).parent('div').addClass(errorClass).removeClass(validClass);
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).parent('div').addClass(validClass).removeClass(errorClass);
    },
    submitHandler: function(form) {
      var login = new FormData($('#login')[0]);
      // console.log($('#login')[0][0]);
      $.ajax({
        url: http + 'api/v1/login',
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        timeout: 3000,
        data: login,
        beforeSend: function() {
          showLoading();
        },
        success: function(res) {
          if (res.length == 0) {
            hideLoading();
            message('error', 'Invalid response !');
          } else {
            if (res.auth.code == 1) {
              message('success', res.auth.message);
              clearLogin('#login');
              setTimeout('window.location.href = http + "dashboard/";', 2000);
            } else {
              hideLoading();
              clearLogin('#login'); 
              message('error', res.auth.message);
            }
          }
        },
        error: function(jqXHR, status, error) {
          hideLoading();
          clearLogin('#login');
          message('error', status);
        }
      });
      return false;
    }
  });
  
});//penutup ready function

