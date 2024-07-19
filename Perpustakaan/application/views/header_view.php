<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $atur = $this->db->query("SELECT logo, nama_perpus FROM tbl_atur WHERE id = 1")->row();?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title_web;?> | Sistem Informasi Perpustakaan </title>
    <!-- Tell the browser to be responsive to screen width -->


    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet"
        href="<?php echo base_url();?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="<?php echo base_url();?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Select2 -->
    <link rel="stylesheet"
        href="<?php echo base_url();?>assets/adminlte/bower_components/select2/dist/css/select2.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet"
        href="<?php echo base_url();?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link href="<?php echo base_url();?>assets/adminlte/plugins/summernote/summernote-lite.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/dist/css/responsive.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet"
        href="<?php echo base_url();?>assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="<?php echo base_url();?>assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="<?php echo base_url();?>assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
    <link rel="shortcut icon" href="<?= base_url('assets/image/'.$atur->logo);?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/adminlte/plugins/pace/pace.min.css">
    <!-- jQuery 3 -->
    <script src="<?php echo base_url();?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- offline -->
    <script type="text/javascript">
    $(document).ajaxStart(function() {
        Pace.restart();
    });
    </script>
    <!-- jQuery 3 -->
    <script src="<?php echo base_url();?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
</head>
<?php 
	if($this->uri->uri_string() == 'dashboard/track'){
		$class_side = 'sidebar-collapse';
	}elseif($sidebar == 'buku_data'){
		$class_side = 'sidebar-collapse';
	}else{
		$class_side = '';
	}
?>
<body class="hold-transition skin-blue-light sidebar-mini <?= $class_side;?>">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b><i class="fa fa-book"></i></b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><?= $atur->nama_perpus;?></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <?php if($this->session->userdata('level')){?>
                        <li>
                            <?php $user = $this->db->query("SELECT nama, level FROM tbl_login WHERE id_login = '$uid'")->row();?>
                            <a href="<?= base_url('user/edit/'.$uid);?>" class="bg-purple">
                                <i class="fa fa-edit"></i> <?php echo $user->nama; echo ' ( '.$user->level.' )'; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>login/logout">Sign out</a>
                        </li>
                        <?php }?>
                        <!-- Control Sidebar Toggle Button 
						<li>
							<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
						</li>-->
                    </ul>
                </div>
            </nav>
        </header>
        <!--loading-->
        <!-- Left side column. contains the logo and sidebar -->
