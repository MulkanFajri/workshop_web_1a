<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Penerbit / Tahun</th>
                <th>Jml</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $no=1;
                $cart =  $this->db->query("SELECT * FROM tbl_keranjang WHERE login_id = ?",[$this->session->userdata('ses_id')])
                            ->result_array();
                foreach($cart as $items){
            ?>
            <tr>
                <td><?= $no;?></td>
                <td><?= $items['nama_buku'];?></td>
                <td><?= $items['penerbit'];?> / <?= $items['tahun'];?></td>
                <td><input type="number" name="jml" id="jml<?=$items['id'];?>" data_<?=$items['id'];?>="<?= $items['id'];?>"
                        value="<?= $items['jml'];?>" class="form-control form-control-sm"></td>
                <td>
                    <a href="javascript:void(0)" id="delete_buku<?=$items['id'];?>" data_<?=$items['id'];?>="<?= $items['id'];?>"
                        class="btn btn-danger btn-xs">
                        <i class="fa fa-times"></i>
                    </a>
                </td>
            </tr>
            <script>
            $(document).ready(function() {
                $("#delete_buku<?=$items['id'];?>").click(function(e) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('transaksi/del_cart');?>",
                        data: 'kode_buku=' + $(this).attr("data_<?=$items['id'];?>"),
                        success: function(html) {
                            $("#tampil").html(html);
                        }
                    });
                });
                $('#jml<?=$items['id'];?>').bind('keyup mouseup', function() {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('transaksi/buku?upd=yes');?>",
                        data: {
                            id: $(this).attr("data_<?=$items['id'];?>"),
                            jml: $(this).val(),
                        },
                        success: function(html) {
                            $("#tampil").html(html);
                        }
                    });
                });
            });
            </script>
            <?php $no++;}?>
        </tbody>
    </table>
    <?php foreach($cart as $items){ ?>
    <input type="hidden" value="<?= $items['kode_buku'];?>" name="idbuku[]">
    <?php }?>
    <div id="tampil"></div>
</div>
