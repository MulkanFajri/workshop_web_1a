<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//validasi jika user belum login
		$this->data['CI'] =& get_instance();
		$this->load->helper(array('form', 'url'));
		$this->load->model('M_Admin');
		$this->load->model('M_Datatables');
		if ($this->session->userdata('masuk_perpus') != true) {
			$url = base_url('login');
			redirect($url);
		}
	}

	public function index()
	{
		if ($this->session->userdata('level') != 'Petugas') {
			$url = base_url('transaksi');
			redirect($url);
		}

		$this->data['uid'] = $this->session->userdata('ses_id');
		$this->data['user'] = $this->M_Admin->get_table('tbl_login');
		$this->data['sidebar'] = 'user';
		$this->data['title_web'] = 'Data User ';

		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('user/user_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function get_data()
	{
		$sql = "SELECT * FROM tbl_login WHERE anggota_id = ? OR nim = ?";
		$user = $this->db->query($sql, [$this->input->post('anggota_id'), $this->input->post('anggota_id')])->row_array();

		echo json_encode($user);
	}

	public function set_barcode($code)
	{
		// //load library
		$this->load->library('zend');
		//load in folder Zend
		$this->zend->load('Zend/Barcode');
		//generate barcode
		$barcodeOptions = array('text' => $code, 'drawText' => false);
		$rendererOptions = array('imageType' => 'png');
		$file = Zend_Barcode::draw('code128', 'image', $barcodeOptions, $rendererOptions);
		$code = $code;
		$store_image = imagepng($file, "./assets/image/barcode/{$code}.png");
		// QRCODE
		// $this->load->library('ciqrcode'); //pemanggilan library QR CODE
		// $config['cacheable']    = true; //boolean, the default is true
		// $config['cachedir']     = './assets/image/barcode/'; //string, the default is application/cache/
		// $config['errorlog']     = './assets/image/barcode/'; //string, the default is application/logs/
		// $config['imagedir']     = './assets/image/barcode/'; //direktori penyimpanan qr code
		// $config['quality']      = true; //boolean, the default is true
		// $config['size']         = '1024'; //interger, the default is 1024
		// $config['black']        = array(255,255,255); // array, default is array(255,255,255)
		// $config['white']        = array(0,0,0); // array, default is array(0,0,0)
		// $this->ciqrcode->initialize($config);

		// $image_name 			= $code.'.png'; //buat name dari qr code sesuai dengan nim
		// $params['data'] 		= $code; //data yang akan di jadikan QR CODE
		// $params['level'] 		= 'H'; //H=High
		// $params['size'] 		= 10;
		// $params['savename'] 	= FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
		// $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		// echo '<img src="'.base64_encode_image (FCPATH.'./assets/image/barcode/'.$code.'.png','png').'" style="width:70px;">';
		// QRCODE
	}

	public function data_user()
	{
		$query = "SELECT tbl_login.anggota_id,tbl_login.id_login,tbl_login.nim,
					tbl_login.nama,tbl_login.user,tbl_login.jenkel,
					tbl_login.telepon,tbl_login.level,tbl_login.alamat, 
					tbl_jurusan.nama_jurusan 
					FROM tbl_login LEFT JOIN 
					tbl_jurusan ON tbl_login.id_jurusan=tbl_jurusan.id_jurusan";
		$search = array('anggota_id', 'nama', 'user', 'tbl_jurusan.nama_jurusan', 'nim', 'telepon', 'level', 'alamat');
		if ($this->input->get('sortir') == 'petugas') {
			$where = array('level' => 'Petugas');
		} elseif ($this->input->get('sortir') == 'anggota') {
			$where = array('level' => 'Anggota');
		} else {
			$where = null;
		}
		// $where  = array('nama_kategori' => 'Tutorial');
		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}

	public function data_anggota()
	{
		$query = "SELECT tbl_login.anggota_id,tbl_login.id_login,tbl_login.nim,
					tbl_login.nama,tbl_login.user,tbl_login.jenkel,
					tbl_login.telepon,tbl_login.level,tbl_login.alamat, 
					tbl_jurusan.nama_jurusan 
					FROM tbl_login LEFT JOIN 
					tbl_jurusan ON tbl_login.id_jurusan=tbl_jurusan.id_jurusan";
		$search = array('anggota_id', 'nama', 'user', 'tbl_jurusan.nama_jurusan', 'nim', 'telepon', 'level', 'alamat');
		$where = array('level' => 'Anggota');
		// $where  = array('nama_kategori' => 'Tutorial');
		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}

	public function tambah()
	{
		$this->data['uid'] = $this->session->userdata('ses_id');
		$this->data['user'] = $this->M_Admin->get_table('tbl_login');
		$this->data['jur'] = $this->M_Admin->get_table('tbl_jurusan');
		$this->data['sidebar'] = 'user';
		$this->data['title_web'] = 'Tambah User ';

		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('user/tambah_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function add()
	{
		// format tabel / kode baru 3 hurup / id tabel / order by limit ngambil data terakhir
		$id = $this->M_Admin->buat_kode('tbl_login', 'AG', 'id_login', 'ORDER BY id_login DESC LIMIT 1');
		$this->set_barcode($id);
		$nim = htmlentities($this->input->post('nim', true));
		$jur = htmlentities($this->input->post('jurusan', true));
		$nama = htmlentities($this->input->post('nama', true));
		$user = htmlentities($this->input->post('user', true));
		$pass = htmlentities($this->input->post('pass', true));
		$level = htmlentities($this->input->post('level', true));
		$jenkel = htmlentities($this->input->post('jenkel', true));
		$telepon = htmlentities($this->input->post('telepon', true));
		// $status 	= htmlentities($this->input->post('status', true));
		$alamat = htmlentities($this->input->post('alamat', true));
		$email = htmlentities($this->input->post('email', true));

		$passhash = password_hash($pass, PASSWORD_DEFAULT);

		$dd = $this->db->query("SELECT * FROM tbl_login WHERE user = '$user' OR email = '$email'");
		if ($dd->num_rows() > 0) {
			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning"><p> Gagal Update User : ' . $nama . ' !, Username / Email Anda Sudah Terpakai</p></div></div>');
			redirect(base_url('user/tambah'));
			exit;
		} else {
			$gambar = 'user_default.png';
			if(!empty($_FILES['gambar']['name'])) {
				// setting konfigurasi upload
				$nmfile = "user_" . time();
				$config['upload_path'] = './assets/image/users/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['file_name'] = $nmfile;
				// load library upload
				$this->load->library('upload', $config);

				// validasi ekstensi file yang diupload
				$file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
				$allowed_extensions = array('gif', 'jpg', 'jpeg', 'png');
				if (in_array($file_extension, $allowed_extensions)) {
					// upload gambar 1
					if ($this->upload->do_upload('gambar')) {
						$data1 = array('upload_data' => $this->upload->data());
						$gambar = $data1['upload_data']['file_name'];
					} else {
						// jika upload gagal
						$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-danger"><p>' . $this->upload->display_errors() . '</p></div></div>');
						redirect(base_url('user/tambah'));
						exit;
					}
				} else {
					$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-danger"><p>Ekstensi file tidak diperbolehkan</p></div></div>');
					redirect(base_url('user/tambah'));
					exit;
				}
			}
						
			$data = array(
				'anggota_id' => $id,
				'nim' => $nim,
				'nama' => $nama,
				'id_jurusan' => $jur,
				'user' => $user,
				'pass' => $passhash,
				'level' => $level,
				'tempat_lahir' => htmlentities($this->input->post('lahir', true)),
				'tgl_lahir' => htmlentities($this->input->post('tgl_lahir', true)),
				'email' => htmlentities($this->input->post('email', true)),
				'telepon' => $telepon,
				'foto' => $gambar,
				'jenkel' => $jenkel,
				'alamat' => $alamat,
				'tgl_bergabung' => date('Y-m-d')
			);
			$this->db->insert('tbl_login', $data);

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success"><p> Daftar User telah berhasil !</p></div></div>');
			redirect(base_url('user'));
		}
	}

	public function edit()
	{
		if ($this->session->userdata('level') == 'Petugas') {
			if ($this->uri->segment('3') == '') {
				echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('user') . '";</script>';
			}
			$this->data['uid'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_login', 'id_login', $this->uri->segment('3'));
			if ($count > 0) {
				$this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_login', 'id_login', $this->uri->segment('3'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('user') . '"</script>';
			}
		} elseif ($this->session->userdata('level') == 'Anggota') {
			$this->data['uid'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_login', 'id_login', $this->uri->segment('3'));
			if ($count > 0) {
				$this->data['user'] = $this->M_Admin->get_tableid_edit('tbl_login', 'id_login', $this->session->userdata('ses_id'));
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('user') . '"</script>';
			}
		}
		$user = $this->data['user'];
		$this->set_barcode($user->anggota_id);

		$this->data['title_web'] = 'Edit User ';
		$this->data['jur'] = $this->M_Admin->get_table('tbl_jurusan');
		$this->data['sidebar'] = 'user';

		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('user/edit_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}

	public function detail()
	{
		if ($this->session->userdata('level') == 'Petugas') {
			if ($this->uri->segment(3) == '') {
				echo '<script>alert("Halaman tidak ditemukan");window.location="' . base_url('user') . '";</script>';
				exit;
			}
			$this->data['uid'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_login', 'id_login', $this->uri->segment(3));
			if ($count > 0) {
				$this->data['user'] = $this->db->query("SELECT tbl_jurusan.nama_jurusan, tbl_login.*
					FROM tbl_login 
					LEFT JOIN tbl_jurusan ON tbl_login.id_jurusan = tbl_jurusan.id_jurusan 
					WHERE tbl_login.id_login = ?",
					array($this->uri->segment(3))
				)->row();
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('user') . '";</script>';
				exit;
			}
		} elseif ($this->session->userdata('level') == 'Anggota') {
			$this->data['uid'] = $this->session->userdata('ses_id');
			$count = $this->M_Admin->CountTableId('tbl_login', 'id_login', $this->session->userdata('ses_id'));
			if ($count > 0) {
				$this->data['user'] = $this->db->query("SELECT tbl_jurusan.nama_jurusan, tbl_login.*
					FROM tbl_login 
					LEFT JOIN tbl_jurusan ON tbl_login.id_jurusan = tbl_jurusan.id_jurusan 
					WHERE tbl_login.id_login = ?",
					array($this->session->userdata('ses_id'))
				)->row();
			} else {
				echo '<script>alert("USER TIDAK DITEMUKAN");window.location="' . base_url('user') . '";</script>';
				exit;
			}
		}

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');
		// title dari pdf
		$this->data['title_web'] = 'Print Kartu Anggota ';

		$user = $this->data['user'];
		// filename dari pdf ketika didownload
		$file_pdf = 'Anggota-' . $user->anggota_id;
		// setting paper
		$paper = 'B5';
		//orientasi paper potrait / landscape
		$orientation = "portrait";

		$html = $this->load->view('user/detail', $this->data, true);
		// run dompdf
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
	}

	public function upd()
	{
		$nim = htmlentities($this->input->post('nim', true));
		$jur = htmlentities($this->input->post('jurusan', true));
		$nama = htmlentities($this->input->post('nama', true));
		$user = htmlentities($this->input->post('user', true));
		$level = htmlentities($this->input->post('level', true));
		$jenkel = htmlentities($this->input->post('jenkel', true));
		$telepon = htmlentities($this->input->post('telepon', true));
		$alamat = htmlentities($this->input->post('alamat', true));
		$id_login = htmlentities($this->input->post('id_login', true));
		$email = htmlentities($this->input->post('email', true));

		// Pengecekan username dan email sudah dipakai
		$username_check = $this->db->query("SELECT user FROM tbl_login WHERE user = ? AND id_login != ?", array($user, $id_login))->num_rows();
		$email_check = $this->db->query("SELECT email FROM tbl_login WHERE email = ? AND id_login != ?", array($email, $id_login))->num_rows();

		if ($username_check > 0) {
			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-danger"><p> Username sudah dipakai!</p></div></div>');
			redirect(base_url('user/edit/' . $id_login));
			exit;
		}

		if ($email_check > 0) {
			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-danger"><p> Email sudah dipakai!</p></div></div>');
			redirect(base_url('user/edit/' . $id_login));
			exit;
		}

		$data = array(
			'nim' => $nim,
			'id_jurusan' => $jur,
			'nama' => $nama,
			'user' => $user,
			'tempat_lahir' => htmlentities($this->input->post('lahir', true)),
			'tgl_lahir' => htmlentities($this->input->post('tgl_lahir', true)),
			'level' => $level,
			'email' => $email,
			'telepon' => $telepon,
			'jenkel' => $jenkel,
			'alamat' => $alamat
		);

		if (!empty($_FILES['gambar']['name'])) {
			// setting konfigurasi upload
			$nmfile = "user_" . time();
			$config['upload_path'] = './assets/image/users/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['file_name'] = $nmfile;
			// load library upload
			$this->load->library('upload', $config);

			// validasi ekstensi file yang diupload
			$file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
			$allowed_extensions = array('gif', 'jpg', 'jpeg', 'png');

			if (in_array($file_extension, $allowed_extensions)) {
				// upload gambar
				if ($this->upload->do_upload('gambar')) {
					$data1 = array('upload_data' => $this->upload->data());
					// hapus gambar lama jika bukan default
					if ($this->input->post('foto') != 'user_default.png') {
						unlink('./assets/image/users/' . $this->input->post('foto'));
					}
					$data['foto'] = $data1['upload_data']['file_name'];
				} else {
					// jika upload gagal
					echo '<script>alert("Upload gambar gagal: ' . $this->upload->display_errors() . '");window.location="' . base_url('user/edit/' . $id_login) . '";</script>';
					exit;
				}
			} else {
				// jika ekstensi file tidak valid
				echo '<script>alert("Ekstensi file tidak diperbolehkan.");window.location="' . base_url('user/edit/' . $id_login) . '";</script>';
				exit;
			}
		}

		// Melanjutkan dengan proses update data lainnya...
		if ($this->input->post('pass') !== '') {
			$pass = htmlentities($this->input->post('pass'));
			$passhash = password_hash($pass, PASSWORD_DEFAULT);
			$data['pass'] = $passhash;
		}

		$this->db->where('id_login', $id_login);
		$this->db->update('tbl_login', $data);

		$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success"><p> Berhasil Update User : ' . $nama . ' !</p></div></div>');
		redirect(base_url('user/edit/' . $id_login));

	}

	public function del()
	{
		if ($this->uri->segment('3') == '') {
			echo '<script>alert("halaman tidak ditemukan");window.location="' . base_url('user') . '";</script>';
			exit;
		}

		$user = $this->M_Admin->get_tableid_edit('tbl_login', 'id_login', $this->uri->segment('3'));
		unlink('./assets/image/users/' . $user->foto);

		$this->M_Admin->delete_table('tbl_login', 'id_login', $this->uri->segment('3'));
		$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning"><p> Berhasil Hapus User !</p></div></div>');
		redirect(base_url('user'));
	}
}
