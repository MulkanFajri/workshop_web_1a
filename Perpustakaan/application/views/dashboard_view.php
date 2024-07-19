<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php if($this->session->userdata('level') == 'Anggota'){ redirect(base_url('user/edit/'.$uid));}?>
<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-sm-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $count_pengguna;?></h3>

                        <p>Anggota</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="user" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-sm-4">
                <!--small box-->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3><?= $count_buku;?></h3>

                        <p>Jenis Buku</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <a href="data" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-sm-4">
                <!--small box-->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3><?= $count_kategori;?></h3>

                        <p>Kategori</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bookmark"></i>
                    </div>
                    <a href="data/kategori" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-sm-4">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $count_pinjam->jml ?? 0;?></h3>

                        <p>Dipinjamkan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-plus"></i>
                    </div>
                    <a href="transaksi" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3><?= $count_kembali->jml ?? 0;?></h3>

                        <p>Dikembalikan ( Bulan Ini )</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                    <a href="transaksi/kembali" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            <?php 
                          $pinjam = $this->db->query("SELECT DISTINCT `pinjam_id`, `anggota_id`, 
                            `status`, `tgl_pinjam`, `lama_pinjam`, `tgl_balik`, `tgl_kembali` 
                            FROM tbl_pinjam WHERE status = 'Dipinjam' ORDER BY pinjam_id DESC");
                          $count = 0;
                          $jmla = 0;
                          foreach($pinjam->result_array() as $isi)
                          {
                            $pinjam_id = $isi['pinjam_id'];
                            $jml = $this->db->query("SELECT * FROM tbl_pinjam WHERE pinjam_id = '$pinjam_id'")->num_rows();			
                            $date1 = date('Ymd');
                            $date2 = preg_replace('/[^0-9]/','',$isi['tgl_balik']);
                            $diff = $date1 - $date2;
                            if($diff > 0 )
                            {
                              $jmla += $count+1;
                            }else{

                              $jmla += $count + 0;
                            }
                          }
                          echo $jmla;
                        ?>
                        </h3>

                        <p>Denda</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ban"></i>
                    </div>
                    <a href="transaksi" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php
                      if($this->input->get('tahun')){
                        $thn = $this->input->get('tahun');
                      }else{
                        $thn = date('Y');
                      }
                    ?>
                        Grafik Perpustakaan ( Pengunjung ) Tahun <?= $thn;?>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="">
                            <div class="table-responsive">
                                <table>
                                    <tr>
                                        <td>
                                            <select name="tahun" class="form-control">
                                                <option value="">- Pilih Tahun Grafik -</option>
                                                <?php
                                            $thn_skr = date('Y');
                                            for($x = $thn_skr; $x >= 2021; $x--){
                                          ?>
                                                <option value="<?= $x;?>" <?php if($thn == $x){?> selected <?php }?>>
                                                    <?= $x ;?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                        <td style="padding-left:0.5pc;">
                                            <button type="submit" class="btn btn-primary btn-md">
                                                <i class="fa fa-search"></i></button>
                                        </td>
                                        <td style="padding-left:0.5pc;">
                                            <a href="<?= base_url('dashboard');?>" class="btn btn-success btn-md">
                                                <i class="fa fa-sync"></i> Refresh</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                        <canvas id="line-chart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content -->
<script src="<?php echo base_url();?>assets/adminlte/dist/js/chart.js"></script>
<script>
var linechart = document.getElementById('line-chart');
var chart = new Chart(linechart, {
    type: 'bar',
    data: {
        labels: [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ], // Merubah data tanggal menjadi format JSON
        datasets: [{
            label: "Pengunjung",
            data: [
                <?php 
                    // php mencari produk
                    for($n=1; $n<=12; $n++){
                        if($n > 9) {
                            $m = $n;
                        }else{
                            $m = '0'.$n;
                        }
                        $gr = $this->db->query("SELECT * FROM tbl_pengunjung 
                          WHERE YEAR(tgl_masuk) = '$thn' 
                          AND MONTH(tgl_masuk) = '$m'")->num_rows();
                    ?>
                <?php echo $gr;?>,
                <?php } ?>
            ],
            borderColor: '#16a862',
            backgroundColor: '#16a862',
            borderWidth: 4,
        }, ],
    },

    options: {
        responsive: true,
    },
});
</script>
