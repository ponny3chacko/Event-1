<?php
session_start();
if(isset($_SESSION['adminId'])){
  header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Festivito | Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    
    <style type="text/css">
      .loadinggif {
        background:url('../images/small.gif') no-repeat 95% center;
        background-size: 20%;
      }
    </style>
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>Festivito</b> Admin</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <div class="alert-warning text-center" id = "message">

        </div>
        <form id = "adminLogin" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name = "username" placeholder="Username">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name = "password" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>          
          <div class="row">           
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" id = "loginBtn">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    
    <script src="../js/jquery.min.js"></script>

    <script src="bootstrap/js/bootstrap.min.js"></script>    
    <script>
      $('#adminLogin').on('submit', function(e){
        $('#loginBtn').addClass('loadinggif');
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({          
          url : 'ajax/login.php', 
          data : data, 
          type : 'post',
          processData : false,
          contentType : false,
          success : function(data){            
            
            if(data.indexOf('OK') >= 0){
              window.location.href = 'index.php';
            }else{
              $('#loginBtn').removeClass('loadinggif');
              $('#message').html('Check Username or Password');
              window.setTimeout(function(){
                $('#message').hide('blind');
              },5000);
            }
          }
        });
      });
    </script>
  </body>
</html>
