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
<!DOCTYPE html>
<html>

<head>
    <title><?= $title_web;?></title>
    <style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 9pt;
    }

    /* #customers tr:nth-child(even){background-color: #f2f2f2;} */

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
    </style>
</head>

<body>
    <h3 style="text-align:center;">-
        <?php if(!empty($this->input->get('sortir') == 'kembali'))	{?>
        <?php if(!empty($this->input->get('bln') && $this->input->get('thn'))){ ?>
        Data Laporan Pengembalian <?= $bulan_tes[$this->input->get('bln')];?> <?= $this->input->get('thn');?>
        <?php }else{?>
        Data Laporan Pengembalian <?= $bulan_tes[date('m')];?> <?= date('Y');?>
        <?php }?>
        <?php }else{?>
        <?php if(!empty($this->input->get('bln') && $this->input->get('thn'))){ ?>
        Data Laporan Peminjaman <?= $bulan_tes[$this->input->get('bln')];?> <?= $this->input->get('thn');?>
        <?php }else{?>
        Data Laporan Peminjaman
        <?php }?>
        <?php }?> - </h3>
    <table id="customers">
        <thead>
            <tr>
                <th>No</th>
                <th>No Pinjam</th>
                <th>ID Anggota</th>
                <th>Nama</th>
                <th>Pinjam</th>
                <th>Kembali</th>
                <th>Status</th>
                <?php if(!empty($this->input->get('sortir') == 'kembali'))	{?>
                <th>Tgl Kembali</th>
                <?php }?>
                <th>Denda</th>
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
            <tr bgcolor="skyblue">
                <td><?= $no;?></td>
                <td><?= $isi['pinjam_id'];?></td>
                <td><?= $isi['anggota_id'];?></td>
                <td><?= $ang->nama ?? '-';?></td>
                <td><?= $isi['tgl_pinjam'];?></td>
                <td><?= $isi['tgl_balik'];?></td>
                <td><?= $isi['status'];?></td>
                <?php if(!empty($this->input->get('sortir') == 'kembali'))	{?>
                <td>
                    <?php 
                        if($isi['tgl_kembali'] == '0')
                        {
                            echo '<p style="color:red;">belum dikembalikan</p>';
                        }else{
                            echo $isi['tgl_kembali'];
                        }
                    
                    ?>
                </td>
                <?php }?>
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
            </tr>
            <tr bgcolor="yellow">
                <td <?php if(!empty($this->input->get('sortir') == 'kembali'))	{?>colspan="9" <?php }else{?>colspan="8"
                    <?php }?>>Data Buku :</td>
            </tr>
            <tr>
                <td>No</td>
                <td <?php if(!empty($this->input->get('sortir') == 'kembali'))	{?>colspan="5" <?php }else{?>colspan="4"
                    <?php }?>>Title</td>
                <td>Penerbit</td>
                <td>Tahun</td>
                <td>Jml</td>
            </tr>
            <?php 
                $pin = $this->M_Admin->get_tableid('tbl_pinjam','pinjam_id',$isi['pinjam_id']);
                $no2=1;
                foreach($pin as $isi)
                {
                    $buku = $this->M_Admin->get_tableid_edit('tbl_buku','buku_id',$isi['buku_id']);
            ?>
            <tr>
                <td><?= $no2;?></td>
                <td <?php if(!empty($this->input->get('sortir') == 'kembali'))	{?>colspan="5" <?php }else{?>colspan="4"
                    <?php }?>><?= $buku->title;?></td>
                <td><?= $buku->penerbit;?></td>
                <td><?= $buku->thn_buku;?></td>
                <td><?= $isi['jml'];?></td>
            </tr>
            <?php $no2++;}?>
            <?php $no++;}?>
        </tbody>
    </table>
</body>

</html>