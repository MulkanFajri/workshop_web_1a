<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title_web;?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="shortcut icon" href="" />
    <link rel="stylesheet"
        href="<?php echo base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="<?php echo base_url('assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css');?>">
    <!-- Ionicons -->
    <link rel="stylesheet"
        href="<?php echo base_url('assets/adminlte/bower_components/Ionicons/css/ionicons.min.css');?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/dist/css/AdminLTE.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/dist/css/responsivelogin.css');?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
    .navbar-inverse {
        background-color: #333;
    }

    .navbar-color {
        color: #fff;
    }

    blink,
    .blink {
        animation: blinker 3s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
    </style>
</head>

<body class="hold-transition login-page" style="overflow-y: hidden;background:url(
	'<?php echo base_url('assets/image/Buku-2.jpg');?>')no-repeat;background-size:100% 100%; ">
    <div class="login-box">
        <?=alert_bs();?>
        <!-- /.login-logo -->
        <div class="login-box-body text-center bg-blue">
            <a href="index.php" style="color:#fff;font-size:20px !important;"><b>Sistem Informasi Perpustakaan</b></a>
        </div>
        <div class="login-box-body" style="border:2px solid #226bbf;">
            <form action="<?php echo base_url('login/add');?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12">
						<div class="form-group">
							<label>Nama Pengguna</label>
							<input type="text" class="form-control" name="nama" required="required"
								placeholder="Nama Pengguna">
						</div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" class="form-control" name="email" required="required"
                                placeholder="Contoh : anang@gmail.com">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="user" required="required"
                                placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pass" required="required"
                                placeholder="Password">
                        </div>
                    </div>
                </div>
                <div class="pull-left">
                    <p>Sudah Punya Akun ? Silahkan <a href="<?= base_url('login');?>">Login</a></p>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary btn-md">Daftar</button>
                    <!-- <a href="<?= base_url('login');?>" class="btn btn-danger btn-md">Kembali</a> -->
                </div>
                <br>
            </form>
			<br>
        </div>
        <!-- /.login-box-body -->
        <footer>
            <div class="login-box-body text-center bg-blue">
                <a style="color: #fff;"> Copyright &copy; Sistem Perpustakaan Codekop - <?php echo date("Y");?>
            </div>
        </footer>
    </div>
    <!-- /.login-box -->
    <!-- Response Ajax -->
    <div id="tampilkan"></div>
    <!-- jQuery 3 -->
    <script src="<?php echo base_url('assets/adminlte/bower_components/jquery/dist/jquery.min.js');?>"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url('assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js');?>">
    </script>
    <!-- iCheck -->
    <script src="<?php echo base_url('assets/adminlte/plugins/iCheck/icheck.min.js');?>"></script>
</body>

</html>
