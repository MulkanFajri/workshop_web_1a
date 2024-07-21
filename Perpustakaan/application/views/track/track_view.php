<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Visitor Counter <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Visitor Counter</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php
                      if($this->input->get('tahun')){
                        $thn = $this->input->get('tahun');
                      }else{
                        $thn = date('Y');
                      }
                    ?>
                        Grafik Pengunjung Tahun <?= $thn;?>
                    </div>
                    <div class="panel-body">
                        <canvas id="line-chart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?= alert_bs();?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Visitor Counter
                    </div>
                    <div class="panel-body" style="text-align:center">
                        <form method="post" action="<?= base_url('dashboard/store');?>">
                            <h3>PENGHITUNG JUMLAH PENGUNJUNG</h3>
                            <h4>Bagi belum menjadi anggota perpustakaan, silahkan masukan Nama Lengkap</h4>
                            <br>
                            <div class="form-group">
                                <input type="text" name="anggota_id" autofocus autocomplete="off"
                                    class="form-control form-lg" id="anggota_id" style="height:50px; font-size:16pt;"
                                    placeholder="Masukan Anggota ID Atau NIM dari Kartu Mahasiswa Anda"
                                    aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <input type="text" name="nama" autocomplete="off" class="form-control form-lg" id="nama"
                                    style="height:50px; font-size:16pt;" placeholder="Masukan Nama Lengkap"
                                    aria-describedby="helpId">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fa fa-user-plus"></i> Tambah
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url();?>assets/adminlte/dist/js/chart.js"></script>
<script>
$(document).ready(function() {
    $("#anggota_id").keyup(function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/get_data');?>",
            data: 'anggota_id=' + $(this).val(),
            dataType: "json",
            success: function(data) {
                $('#nama').val(data.nama)
            }
        });
    });
});
</script>
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
        indexAxis: 'y',
    },
});
</script>