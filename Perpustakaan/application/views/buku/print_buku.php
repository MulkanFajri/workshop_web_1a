<!DOCTYPE html>
<html>

<head>
    <title><?= $title_web;?></title>
    <style>
    @page {
        margin: 5px;
    }

    body {
        margin: 5px;
    }

    #table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 9pt;
    }

    #table td,
    #table th {
        border: 1px solid #ddd;
        padding: 5px;
    }

    #table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #table tr:hover {
        background-color: #ddd;
    }

    #table th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
    </style>
</head>

<body>
    <center>
        <h2><?= $title_web;?></h2>
    </center>
    <table id="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Buku id</th>
                <th>Isbn</th>
                <th>Title</th>
                <th>Kategori</th>
                <th>Rak</th>
                <th>Penerbit</th>
                <th>Pengarang</th>
                <th>Thn buku</th>
                <th>Jml</th>
                <th>Tgl masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $no =1;
                foreach($buku as $r){
            ?>
            <tr>
                <td><?= $no;?></td>
                <td>
                    <center>
                        <img src="<?php echo base_url();?>assets/image/barcode/<?= $r->buku_id;?>.png"
                            style="width:70px;"><br><?=$r->buku_id;?>
                    </center>
                </td>
                <td><?=$r->isbn;?></td>
                <td><?=$r->title;?></td>
                <td><?=$r->nama_kategori;?></td>
                <td><?=$r->nama_rak;?></td>
                <td><?=$r->penerbit;?></td>
                <td><?=$r->pengarang;?></td>
                <td><?=$r->thn_buku;?></td>
                <td><?=$r->jml;?></td>
                <td><?=$r->tgl_masuk;?></td>
            </tr>
            <?php $no++; }?>
        </tbody>
    </table>
</body>

</html>
