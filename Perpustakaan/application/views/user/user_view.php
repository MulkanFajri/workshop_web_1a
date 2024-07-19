<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit" style="color:green"> </i> Daftar Data User
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
            <li class="active"><i class="fa fa-file-text"></i>&nbsp; Daftar Data User</li>
        </ol>
    </section>
    <section class="content">
        <?php if(!empty($this->session->flashdata())){ echo $this->session->flashdata('pesan');}?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <a href="user/tambah" class="btn btn-primary"><i class="fa fa-plus"> </i> Tambah User</a>
                        <span class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"> Sortir
                                <?php if($this->input->get('sortir') == 'petugas'){?>
                                ( Petugas )
                                <?php }else if($this->input->get('sortir') == 'anggota'){?>
                                ( Anggota )
                                <?php }else{?>
                                ( Semua Data )
                                <?php }?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url('user');?>">Semua Data</a></li>
                                <li><a href="<?= base_url('user?sortir=petugas');?>">Petugas</a></li>
                                <li><a href="<?= base_url('user?sortir=anggota');?>">Anggota</a></li>
                            </ul>
                        </span>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <br />
                            <table id="example" class="table table-bordered table-striped table" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>User</th>
                                        <th>Telepon</th>
                                        <th>Level</th>
                                        <th>Alamat</th>
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
            "url": "<?= base_url('user/data_user?sortir='.$this->input->get('sortir'));?>", // URL file untuk proses select datanya
            "type": "POST"
        },
        "deferRender": true,
        "aLengthMenu": [
            [10, 25, 50],
            [10, 25, 50]
        ], // Combobox Limit
        "columns": [{
                "data": 'id_login',
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "data": "anggota_id"
            },
            {
                "data": "nim"
            },
            {
                "data": "nama"
            },
            {
                "data": "nama_jurusan"
            },
            {
                "data": "user"
            },
            {
                "data": "telepon"
            },
            {
                "data": "level"
            },
            {
                "data": "alamat"
            },
            {
                "data": "id_login",
                "render": function(data, type, row, meta) {
                    return `<a href="${base_url}user/edit/${row.id_login}" 
                                    class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                <a href="${base_url}user/del/${row.id_login}" 
                                    onclick="return confirm('Anda yakin user akan dihapus ?');"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                <a href="${base_url}user/detail/${row.id_login}" target="_blank" 
                                    class="btn btn-primary btn-sm">
                                    <i class="fa fa-print"></i> Cetak Kartu</a>`;
                }
            },
        ],
    });
});
</script>