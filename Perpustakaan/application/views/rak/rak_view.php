<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
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
                <div class="row">
                    <div class="col-sm-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <?php if(!empty($this->input->get('id'))){?>
                                <h4> Edit Rak</h4>
                                <?php }else{?>
                                <h4> Tambah Rak</h4>
                                <?php }?>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <?php if(!empty($this->input->get('id'))){?>
                                <form method="post" action="<?= base_url('data/rakproses');?>">
                                    <div class="form-group">
                                        <label for="">Nama Rak / Lokasi</label>
                                        <input type="text" name="rak" value="<?=$rak->nama_rak;?>" id="rak"
                                            class="form-control" placeholder="Contoh : Rak Buku 1">

                                    </div>
                                    <br />
                                    <input type="hidden" name="edit" value="<?=$rak->id_rak;?>">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Edit
                                        Rak</button>
                                </form>
                                <?php }else{?>

                                <form method="post" action="<?= base_url('data/rakproses');?>">
                                    <div class="form-group">
                                        <label for="">Nama Rak / Lokasi</label>
                                        <input type="text" name="rak" id="rak" class="form-control"
                                            placeholder="Contoh : Rak Buku 1">

                                    </div>
                                    <br />
                                    <input type="hidden" name="tambah" value="tambah">
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah
                                        Rak</button>
                                </form>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered table-striped table" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Rak Buku</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
var base_url = '<?= base_url();?>';
var tabel = null;
$(document).ready(function() {
    tabel = $('#example').DataTable({
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [
            [0, 'desc']
        ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": "<?= base_url('data/data_rak');?>", // URL file untuk proses select datanya
            "type": "POST"
        },
        "deferRender": true,
        "aLengthMenu": [
            [5, 10, 50],
            [5, 10, 50]
        ], // Combobox Limit
        "columns": [{
                "data": 'id_rak',
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "data": "nama_rak"
            },
            {
                "data": "id_rak",
                "render": function(data, type, row, meta) {
                    return `<a href="${base_url}data/rak?id=${row.id_rak}" 
									class="btn btn-success"><i class="fa fa-edit"></i></a>
								<a href="${base_url}data/rakproses?rak_id=${row.id_rak}" 
									onclick="return confirm('Anda yakin rak ini akan dihapus ?');" 
									class="btn btn-danger"><i class="fa fa-trash"></i></a>`;
                }
            },
        ],
    });
});
</script>