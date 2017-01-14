<?php
session_start();
if(!isset($_SESSION['adminId'])){
  header('Location: login.php');
}
include'../config.php';
$file = ucwords(basename($_SERVER['PHP_SELF'],'.php'));
$file = $file == 'index' ? 'Dashboard' : $file ;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Festivito | <?php echo $file ?></title>
    <link rel='icon' href='../images/event icon.png' type='image/x-icon'>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <!-- Font Awesome -->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

    <!-- Ionicons -->      
    <link href="ionicons/css/ionicons.css" rel="stylesheet" type="text/css" />
    <link href="ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" type="text/css" href="css/on-off-switch.css"/>
<!--Button slide-->    
<script type="text/javascript">
  // Geting current timezone
function timeZone()
{
    // Getting Current Timezone Offset
    var Cookies = {};
    var expires ='';
    Cookies.create = function (name, value, days)
    {
        if (days)
        {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        else
        {
            expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
        this[name] = value;
    };
    var now = new Date();

    Cookies.create("GMT_bias",now.getTimezoneOffset(),1);
    // End Getting Current Timezone Offset
}


    timeZone();

</script>
  </head>
  <body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>Festivito</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Festivito</b> Admin</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">              
              <li class="dropdown user user-menu">
                <a href="logout.php">                  
                  <i class="fa fa-sign-out"></i>
                  <span class="hidden-xs">Logout</span>
                </a>                
              </li>              
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['adminUsername']; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
              <a href="index.php">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
              </a>              
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Event</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="list.php"><i class="fa fa-circle-o"></i> Event List </a></li>
                <li><a href="addEvent.php"><i class="fa fa-circle-o"></i> Add Event</a></li>
                <li><a href="addTicket.php"><i class="fa fa-circle-o"></i> Add Tickets</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Organisers</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="orglist.php"><i class="fa fa-circle-o"></i> Organisers List </a></li>
                <li><a href="orgdetail.php"><i class="fa fa-circle-o"></i> Organisers Detail</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Transactions</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="orglist.php"><i class="fa fa-circle-o"></i> Organizar List </a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> </a></li>
              </ul>
            </li>            
            <li>
              <a href="mailbox.php">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                <small class="label pull-right bg-yellow">12</small>
              </a>
            </li>            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $file; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $file; ?></li>
          </ol>
        </section>