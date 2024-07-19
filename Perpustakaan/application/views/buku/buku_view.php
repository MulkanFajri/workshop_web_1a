<?php if(! defined('BASEPATH')) exit('No direct script acess allowed');?>
<?php 
	if($this->input->get('sortir')){
		$print = base_url('data/print_buku?sortir='.$this->input->get('sortir'));
	}else{
		if($this->input->get('rak')){
			$print = base_url('data/print_buku?rak='.$this->input->get('rak'));
		}else{
			$print = base_url('data/print_buku');
		}
	}
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
                        <?php if($this->session->userdata('level') == 'Petugas'){?>
                        <a href="data/bukutambah"><button class="btn btn-primary" style="margin-top:0.5pc;">
                                <i class="fa fa-plus"> </i> Tambah Buku</button></a>
                        <?php }?>
                        <span class="dropdown">
                            <button class="btn btn-success dropdown-toggle" style="margin-top:0.5pc;" type="button"
                                data-toggle="dropdown"> Sortir Kategori
                                <?php if($this->input->get('sortir')){?>
                                ( <?= htmlspecialchars($this->input->get('sortir'));?> )
                                <?php }else{?>
                                ( Semua Data )
                                <?php }?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu btn-block" style="margin-top:0.7pc;">
                                <li><a href="<?= base_url('data');?>">Semua Data</a></li>
                                <?php $kat = $this->db->query('SELECT * FROM tbl_kategori ORDER BY nama_kategori ASC');?>
                                <?php foreach($kat->result() as $r){?>
                                <li><a href="<?= base_url('data?sortir='.urlencode($r->nama_kategori));?>"><?= $r->nama_kategori;?></a>
                                </li>
                                <?php }?>
                            </ul>
                        </span>
                        <span class="dropdown">
                            <button class="btn btn-danger dropdown-toggle" style="margin-top:0.5pc;" type="button"
                                data-toggle="dropdown"> Sortir Rak buku
                                <?php if($this->input->get('rak')){?>
                                ( <?= htmlspecialchars($this->input->get('rak'));?> )
                                <?php }else{?>
                                ( Semua Data )
                                <?php }?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu btn-block" style="margin-top:0.7pc;">
                                <li><a href="<?= base_url('data');?>">Semua Data</a></li>
                                <?php $kat = $this->db->query('SELECT * FROM tbl_rak ORDER BY nama_rak ASC');?>
                                <?php foreach($kat->result() as $r){?>
                                <li><a href="<?= base_url('data?rak='.urlencode($r->nama_rak));?>"><?= $r->nama_rak;?></a></li>
                                <?php }?>
                            </ul>
                        </span>
						<a href="<?= $print;?>" target="_blank" class="btn btn-info" style="margin-top:0.5pc;"><i class="fa fa-print"></i> Print List Buku</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br />
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-striped table table-sm" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sampul</th>
                                        <th style="width:10%;">Buku ID</th>
                                        <th>ISBN</th>
                                        <th>Title</th>
                                        <th>Kategori</th>
                                        <th>Rak</th>
                                        <th>Penerbit</th>
                                        <th>Tahun</th>
                                        <th>Stok</th>
                                        <th>Pinjam</th>
                                        <?php if($this->session->userdata('level') == 'Petugas'){?>
                                        <th style="width:12%;">Aksi</th>
                                        <?php }else{?>
                                        <th>Aksi</th>
                                        <?php }?>
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
            <?php if($this->input->get('sortir')){?> "url": "<?= base_url('data/data_buku?sortir='.$this->input->get('sortir'));?>", // URL file untuk proses select datanya
            <?php }else{?>
            <?php if($this->input->get('rak')){?> "url": "<?= base_url('data/data_buku?rak='.$this->input->get('rak'));?>",
            <?php }else{?> "url": "<?= base_url('data/data_buku');?>",
            <?php }?>
            <?php }?> "type": "POST"
        },
        "deferRender": true,
        "aLengthMenu": [
            [10, 25, 50],
            [10, 25, 50]
        ], // Combobox Limit
        "columns": [{
                "data": 'id_buku',
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "data": "sampul",
                "render": function(data, type, row, meta) {
                    if (row.sampul == null) {
                        return `<center><i class="fa fa-book fa-3x" style="color:#333;"></i> <br/><br/>
											Tidak Ada Sampul</center>`;
                    } else {
                        return `<img src="${base_url}assets/image/buku/${row.sampul}" 
                                        alt="#" class="img-responsive" 
                                        style="height:auto;width:100px;"/>`;
                    }
                }
            },
            {
                "data": "buku_id",
                "render": function(data, type, row, meta) {
                    return `<img src="<?php echo base_url();?>assets/image/barcode/${row.buku_id}.png" 
                                    class="img-responsive"><center><b>${row.buku_id}</b></center>`;
                }
            },
            {
                "data": "isbn"
            },
            {
                "data": "title"
            },
            {
                "data": "nama_kategori"
            },
            {
                "data": "nama_rak"
            },
            {
                "data": "penerbit"
            },
            {
                "data": "thn_buku"
            },
            {
                "data": "jml"
            },
            {
                "data": "dipinjam"
            },
            {
                "data": "id_buku",
                "render": function(data, type, row, meta) {
                    <?php if($this->session->userdata('level') == 'Petugas'){?>
                    return ` <a href="${base_url}data/bukuedit/${row.id_buku}" title="Edit buku" class="btn btn-success btn-sm">
                                    <i class="fa fa-edit"></i></a>
                                <a href="${base_url}data/bukudetail/${row.id_buku}" title="Detail Buku"
                                    class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> </a>
                                <a href="${base_url}data/prosesbuku?buku_id=${row.id_buku}" 
                                    onclick="return confirm('Anda yakin Buku ini akan dihapus ?');" 
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i></a>`;

                    <?php }else{?>
                    return `<a href="${base_url}data/bukudetail/${row.id_buku}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-sign-in"></i> Detail
                                    </a>`;
                    <?php }?>
                }
            },
        ],
    });
});
</script>
