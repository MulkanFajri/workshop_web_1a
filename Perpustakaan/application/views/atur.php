<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php if($this->session->userdata('level') == 'Anggota'){ redirect(base_url('transaksi'));}?>
<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Atur Perpustakaan <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-cog"></i> Home</a></li>
            <li class="active">Atur Perpustakaan</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php
            $atur =$this->db->query("SELECT * FROM tbl_atur WHERE id = 1")->row();
        ?>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <?php if(!empty($this->session->flashdata('success'))){ ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('success');?>
                </div>
                <?php }?>
                <div class="box box-primary">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        <form method="post" action="<?=base_url('dashboard/aturan');?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Nama Perpustakaan</label>
                                <input type="text" value="<?= $atur->nama_perpus;?>" class="form-control"
                                    name="nama_perpus" id="nama_perpus" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">E-mail</label>
                                <input type="email" value="<?= $atur->email;?>" class="form-control" name="email"
                                    id="email" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Telepon</label>
                                <input type="number" value="<?= $atur->telepon;?>" class="form-control" name="telepon"
                                    id="telepon" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat"
                                    placeholder=""><?= $atur->alamat;?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Logo</label>
                                <input type="file" class="form-control" accept="image/*" name="logo" id="logo"
                                    placeholder="">
                                <?php 
                                        $gambar = FCPATH.'assets/image/'.$atur->logo;
                                        if(file_exists($gambar)){
                                    ?>
                                <br>
                                <img src="<?=base_url('assets/image/'.$atur->logo);?>" class="img-responsive">
                                <?php }?>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </section>
</div>
<!-- /.content -->