<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>--</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?=$themes?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
<!--    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
    <!-- Theme style -->
    <link href="<?=$themes?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?=$themes?>/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
          <!--<img src="<?=base_url()?>images/peruri_logo.png" style="width:100%"/>-->
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg ">Login</p>
        <div class="alert alert-error hide"> 
            <button class="close" data-dismiss="alert"></button>
            <span class="message"></span>
        </div>
        <form class="login-form" action="#" id="form_login">
          <div class="form-group has-feedback">
            <input type="text" id="username" name="username" class="form-control form_input" placeholder="Username" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="password" name="password" class="form-control form_input" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">
              <button type="button" onclick="submit_form()" class="btn btn-primary btn-block btn-flat">Login</button>
            </div><!-- /.col -->
          </div>
        </form>


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=$themes?>/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?=$themes?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  
    <script>
        var base_url = "<?=base_url();?>";
        function submit_form(){ 
            $('.alert').addClass('hide');
            var username = $('#username').val();
            var password = $('#password').val();
            if(username != '' && password != ''){
                $.ajax({
                    type : "POST",
                    url  : base_url+"admin/process_login",
                    data : $('#form_login').serialize(),
                    datatype: "json",
                    success: function(data){ 
                        if (data['reset']) {
                            $('.alert').removeClass('hide');
                            $('.message').html('User is Blocked please contact Administrator.');
                            $("#form_login").attr("style","display:none");
                          } else {
                              if (data['success']) {
                                  if (data['login']) {
                                      $('.alert').removeClass('hide');
                                      $('.message').html('User sedang login.');
                                  } else {
                                      window.location = base_url + 'Index';
                                  }
                              } else if (!data['success']) {
                                  $("#attempt").val(data['attempt']);
                                  $('.alert').removeClass('hide');
                                  $('.message').html('Username dan password salah.');

                              }
                          }
                    }
                });
            }else{                
                $('.alert').removeClass('hide');
                $('.message').html('Mohon isi semua data.');
            }
        }
    </script>
  </body>
</html>
