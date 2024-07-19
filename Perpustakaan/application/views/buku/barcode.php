<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode</title>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align:center;
            font-size:8pt;
        }
    </style>
    <script>window.print();</script>
</head>
<body>
    <table id="customers">
        <?php for($i =1; $i<=7;$i++){?>
        <tr>
            <td>
                <img src="<?php echo base_url();?>assets/image/barcode/<?= $buku->buku_id;?>.png" 
                    class="img-responsive" style="width:70px;">
                <br>
                <b><?= $buku->buku_id;?></b><br>
                (<?= $buku->title;?>)
            </td>
            <td>
                <img src="<?php echo base_url();?>assets/image/barcode/<?= $buku->buku_id;?>.png" 
                    class="img-responsive" style="width:70px;">
                <br>
                <b><?= $buku->buku_id;?></b><br>
                (<?= $buku->title;?>)
            </td>
            <td>
                <img src="<?php echo base_url();?>assets/image/barcode/<?= $buku->buku_id;?>.png" 
                    class="img-responsive" style="width:70px;">
                <br>
                <b><?= $buku->buku_id;?></b><br>
                (<?= $buku->title;?>)
            </td>
            <td>
                <img src="<?php echo base_url();?>assets/image/barcode/<?= $buku->buku_id;?>.png" 
                    class="img-responsive" style="width:70px;">
                <br>
                <b><?= $buku->buku_id;?></b><br>
                (<?= $buku->title;?>)
            </td>
        </tr>
        <?php }?>
    </table>
</body>
</html>