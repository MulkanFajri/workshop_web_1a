<?php
        $tgla = $user->tgl_bergabung;
        $tglk = $user->tgl_lahir;
        $bulan = array(
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'Mei',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Agt',
            '09' => 'Sep',
            '10' => 'Okt',
            '11' => 'Nov',
            '12' => 'Des',
        );
    
        $array1=explode("-",$tgla);
        $tahun=$array1[0];
        $bulan1=$array1[1];
        $hari=$array1[2];
        $bl1 = $bulan[$bulan1];
		$tgl1 = $hari.' '.$bl1.' '.$tahun;
		
		if(!empty($tglk)){
			$array2=explode("-",$tglk);
			$tahun2=$array2[0];
			$bulan2=$array2[1];
			$hari2=$array2[2];
			$bl2 = $bulan[$bulan2];
			$tgl2 = $hari2.' '.$bl2.' '.$tahun2;
		}else{
			$tgl2 = $tglk;
		}
		
		$atur =$this->db->query("SELECT * FROM tbl_atur WHERE id = 1")->row();
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $title_web;?></title>
    <style>
    .kartu {
        max-width: 9cm;
        max-height: 6cm;
        border: 2px solid #333;
        background: url('<?=base_url('assets/image/cardback1.jpg');?>');
    }
    </style>
</head>

<body>
    <div class="kartu">
        <table style="border-bottom:2px solid #333;margin-bottom:4px;">
            <tr>
                <th style="font-size:11pt;text-align:center;">
                    KARTU ANGGOTA PERPUSTAKAAN
                </th>
                <th style="text-align:center; padding-left:0.7pc;">
                    <img src="<?=base_url('assets/image/'.$atur->logo);?>" style="width:55px;" class="img-responsive">
                </th>
            </tr>
        </table>
        <table>
            <tr>
                <td style="padding-left:0.5pc;padding-right:0.5pc;">
                    <center>
                        <img src="<?php echo base_url();?>assets/image/users/<?php echo $user->foto;?>"
                            style="width:2.4cm;height:3cm;border-radius:15px;" class="img-responsive">
                    </center>
                </td>
                <td style="font-size:10pt;padding:1px;width:65%;">
                    <table>
                        <tr>
                            <td>ID Anggota</td>
                            <td>:</td>
                            <td><?= $user->anggota_id;?></td>
                        </tr>
                        <tr>
                            <td>Jurusan</td>
                            <td>:</td>
                            <td><?= $user->nama_jurusan;?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?= $user->nama;?></td>
                        </tr>
                        <tr>
                            <td>TTL</td>
                            <td>:</td>
                            <td><?= $user->tempat_lahir;?>, <?= $tgl2 ;?></td>
                        </tr>
                        <!-- <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= $user->alamat;?></td>
                        </tr> -->
                        <tr>
                            <td>Tgl Bergabung</td>
                            <td>:</td>
                            <td><?= $tgl1;?></td>
                        </tr>
                        <tr>
                            <td colspan="3"><img style="height:30px;width:90%;"
                                    src="<?php echo base_url();?>assets/image/barcode/<?php echo $user->anggota_id;?>.png">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
</body>

</html>
