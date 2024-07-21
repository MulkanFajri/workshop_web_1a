<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<?php 
	$bulan_tes =array(
		'01'=>"Januari",
		'02'=>"Februari",
		'03'=>"Maret",
		'04'=>"April",
		'05'=>"Mei",
		'06'=>"Juni",
		'07'=>"Juli",
		'08'=>"Agustus",
		'09'=>"September",
		'10'=>"Oktober",
		'11'=>"November",
		'12'=>"Desember"
	);
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit" style="color:green"> </i> <?= $title_web;?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
            <li class="active"><i class="fa fa-file-text"></i>&nbsp; <?= $title_web;?></li>
        </ol>
    </section>
    <section class="content">
        <?php if(!empty($this->session->flashdata())){ echo $this->session->flashdata('pesan');}?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <?php if($this->session->userdata('level') == 'Petugas'){ ?>
                        <a href="transaksi/pinjam"><button class="btn btn-primary">
                                <i class="fa fa-plus"> </i> Tambah Pinjam</button></a>
                        <?php }?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="get" action="">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th>
                                            Pilih Bulan
                                        </th>
                                        <th>
                                            Pilih Tahun
                                        </th>
                                        <th>
                                            Aksi
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="bln" class="form-control" required>
                                                <option selected="selected" value="" disabled>Bulan</option>
                                                <?php
									$bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
									$jlh_bln=count($bulan);
									$bln1 = array('01','02','03','04','05','06','07','08','09','10','11','12');
									$no=1;
									for($c=0; $c<$jlh_bln; $c+=1){
										echo"<option value='$bln1[$c]'> $bulan[$c] </option>";
									$no++;}
								?>
                                            </select>
                                        </td>
                                        <td>
                                            <?php
								$now=date('Y');
								echo "<select name='thn' class='form-control' required>";
								echo '
								<option selected="selected">Tahun</option>';
								for ($a=2020;$a<=$now;$a++)
								{
									echo "<option value='$a'>$a</option>";
								}
								echo "</select>";
								?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="periode" value="ya">
                                            <button class="btn btn-primary">
                                                <i class="fa fa-search"></i> Cari
                                            </button>
                                            <a href="<?= base_url('transaksi');?>" class="btn btn-success">
                                                <i class="fa fa-refresh"></i> Refresh</a>

                                            <?php if($this->session->userdata('level') == 'Petugas'){ ?>
                                            <?php if(!empty($this->input->get('bln'))){?>
                                            <a href="<?= base_url('transaksi');?>/cetak?excel=yes&bln=<?=$this->input->get('bln');?>&thn=<?=$this->input->get('thn');?>"
                                                class="btn btn-info"><i class="fa fa-download"></i>
                                                Excel</a>
                                            <a href="<?= base_url('transaksi');?>/cetak?bln=<?=$this->input->get('bln');?>&thn=<?=$this->input->get('thn');?>"
                                                target="_blank" class="btn btn-warning btn-md"><i
                                                    class="fa fa-print"></i>
                                                Print </a>
                                            <?php }else{?>
                                            <a href="<?= base_url('transaksi');?>/cetak?excel=yes"
                                                class="btn btn-info"><i class="fa fa-download"></i>
                                                Excel</a>
                                            <a href="<?= base_url('transaksi');?>/cetak" target="_blank"
                                                class="btn btn-warning btn-md"><i class="fa fa-print"></i> Print </a>
                                            <?php }?>
                                            <?php }?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                        <center>
                            <h4> -
                                <?php if(!empty($this->input->get('bln') && $this->input->get('thn'))){ ?>
                                Data Peminjaman <?= $bulan_tes[$this->input->get('bln')];?>
                                <?= $this->input->get('thn');?>
                                <?php }else{?>
                                Data Semua Peminjaman
                                <?php }?> -
                            </h4>
                        </center>
                        <br />
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Pinjam</th>
                                        <th>ID Anggota</th>
                                        <th>Nama</th>
                                        <th>Pinjam</th>
                                        <th>Balik</th>
                                        <th style="width:10%">Status</th>
                                        <th>Denda</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no=1;
                                        foreach($pinjam->result_array() as $isi){
                                                $anggota_id = $isi['anggota_id'];
                                                $ang = $this->db->query("SELECT * FROM tbl_login WHERE anggota_id = '$anggota_id'")->row();

                                                $pinjam_id = $isi['pinjam_id'];
                                                $denda = $this->db->query("SELECT * FROM tbl_denda WHERE pinjam_id = '$pinjam_id'");
                                                $total_denda = $denda->row();
                                    ?>
                                    <tr>
                                        <td><?= $no;?></td>
                                        <td><?= $isi['pinjam_id'];?></td>
                                        <td><?= $isi['anggota_id'];?></td>
                                        <td><?= $ang->nama ?? '-';?></td>
                                        <td><?= $isi['tgl_pinjam'];?></td>
                                        <td><?= $isi['tgl_balik'];?></td>
                                        <td><?= $isi['status'];?></td>
                                        <td>
                                            <?php 
										if($isi['status'] == 'Di Kembalikan')
										{
											echo $this->M_Admin->rp($total_denda->denda);
										}else{
											$jml = $this->db->query("SELECT sum(jml) as jml FROM tbl_pinjam WHERE pinjam_id = '$pinjam_id'")->row();	
											$jml = $jml->jml;												
											$date1 = date('Ymd');
											$date2 = preg_replace('/[^0-9]/','',$isi['tgl_balik']);
											$diff = $date1 - $date2;
											$now = time(); // or your date as well
											$your_date = strtotime($isi['tgl_balik']);
											$datediff = $now - $your_date;
											$tenggat = round($datediff / (60 * 60 * 24));
											// echo round($datediff / (60 * 60 * 24)).'<br>';
											if($tenggat > 0 )
											{
												echo $tenggat.' hari';
												$dd = $this->M_Admin->get_tableid_edit('tbl_biaya_denda','stat','Aktif'); 
												echo '<p style="color:red;font-size:18px;">
												'.$this->M_Admin->rp($jml*($dd->harga_denda*$tenggat)).' 
												</p><small style="color:#333;">* Untuk '.$jml.' Buku</small>';
											}else{
												echo '<p style="color:green;">
												Tidak Ada Denda</p>';
											}
										}
									?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php if($this->session->userdata('level') == 'Petugas'){ ?>
                                            <?php if($isi['tgl_kembali'] == '0') {?>
                                            <a href="<?= base_url('transaksi/kembalipinjam/'.$isi['pinjam_id']);?>"
                                                class="btn btn-warning btn-sm" title="pengembalian buku">
                                                <i class="fa fa-sign-out"></i> Kembalikan</a>
                                            <?php }else{ ?>
                                            <a href="javascript:void(0)" class="btn btn-success btn-sm"
                                                title="pengembalian buku">
                                                <i class="fa fa-check"></i> Dikembalikan</a>
                                            <?php }?>
                                            <a href="<?= base_url('transaksi/detailpinjam/'.$isi['pinjam_id'].'?pinjam=yes');?>"
                                                class="btn btn-primary btn-sm" title="detail pinjam"><i
                                                    class="fa fa-eye"></i></button></a>
                                            <a href="<?= base_url('transaksi/prosespinjam?pinjam_id='.$isi['pinjam_id']);?>"
                                                onclick="return confirm('Anda yakin Peminjaman Ini akan dihapus ?');"
                                                class="btn btn-danger btn-sm" title="hapus pinjam">
                                                <i class="fa fa-trash"></i></a>
                                            <?php }else{?>
                                            <a href="<?= base_url('transaksi/detailpinjam/'.$isi['pinjam_id']);?>"
                                                class="btn btn-primary btn-sm" title="detail pinjam">
                                                <i class="fa fa-eye"></i> Detail Pinjam</a>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php $no++;}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>