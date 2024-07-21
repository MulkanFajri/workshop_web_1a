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
        padding: 8px;
    }

    #table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #table tr:hover {
        background-color: #ddd;
    }

    #table th {
        padding-top: 10px;
        padding-bottom: 10px;
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
            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota ID</th>
                    <th>Nama</th>
                    <th>Created at</th>
                    <th>Tgl masuk</th>
                </tr>
            </thead>
        <tbody>
            <?php 
                $no =1;
                foreach($pengunjung as $r){
            ?>
            <tr>
                <td><?= $no;?></td>
                <td><?=$r->anggota_id;?></td>
                <td><?=$r->nama;?></td>
                <td><?=$r->created_at;?></td>
                <td><?=$r->tgl_masuk;?></td>
            </tr>
            <?php $no++; }?>
        </tbody>
    </table>
</body>

</html>
