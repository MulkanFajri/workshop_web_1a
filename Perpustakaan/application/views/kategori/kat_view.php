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
                                <h4> Edit Kategori</h4>
                                <?php }else{?>
                                <h4> Tambah Kategori</h4>
                                <?php }?>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <?php if(!empty($this->input->get('id'))){?>
                                <form method="post" action="<?= base_url('data/katproses');?>">
                                    <div class="form-group">
                                        <label for="">Nama Kategori</label>
                                        <input type="text" name="kategori" value="<?=$kat->nama_kategori;?>"
                                            id="kategori" class="form-control" placeholder="Contoh : Pemrograman Web">

                                    </div>
                                    <br />
                                    <input type="hidden" name="edit" value="<?=$kat->id_kategori;?>">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Edit
                                        Kategori</button>
                                </form>
                                <?php }else{?>

                                <form method="post" action="<?= base_url('data/katproses');?>">
                                    <div class="form-group">
                                        <label for="">Nama Kategori</label>
                                        <input type="text" name="kategori" id="kategori" class="form-control"
                                            placeholder="Contoh : Pemrograman Web">

                                    </div>
                                    <br />
                                    <input type="hidden" name="tambah" value="tambah">
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-plus"></i> Tambah
                                        Kategori</button>
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
                                                <th>Kategori</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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
            "url": "<?= base_url('data/data_kategori');?>", // URL file untuk proses select datanya
            "type": "POST"
        },
        "deferRender": true,
        "aLengthMenu": [
            [10, 25, 50],
            [10, 25, 50]
        ], // Combobox Limit
        "columns": [{
                "data": 'id_kategori',
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "data": "nama_kategori"
            },
            {
                "data": "id_kategori",
                "render": function(data, type, row, meta) {
                    return `<a href="${base_url}data/kategori?id=${row.id_kategori}" 
									class="btn btn-success"><i class="fa fa-edit"></i></a>
								<a href="${base_url}data/katproses?kat_id=${row.id_kategori}" 
									onclick="return confirm('Anda yakin Kategori ini akan dihapus ?');" 
									class="btn btn-danger"><i class="fa fa-trash"></i></a>`;
                }
            },
        ],
    });
});
</script>