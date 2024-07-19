<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_login');
    }

    public function index()
    {
        $this->data['title_web'] = 'Login | Sistem Informasi Perpustakaan';
        $this->load->view('login_view', $this->data);
    }

    public function daftar()
    {
        $this->data['title_web'] = 'Daftar | Sistem Informasi Perpustakaan';
        $this->data['sidebar'] 	 = 'register';
        $this->data['jur'] 		 = $this->M_Admin->get_table('tbl_jurusan');
        $this->load->view('register', $this->data);
    }

    public function set_barcode($code)
    {
        // //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //generate barcode
        $barcodeOptions = array('text' => $code,'drawText' => false);
        $rendererOptions = array('imageType'=>'png');
        $file = Zend_Barcode::draw('code128', 'image', $barcodeOptions, $rendererOptions);
        $code = $code;
        $store_image = imagepng($file, "./assets/image/barcode/{$code}.png");
    }

    public function add()
    {
        // format tabel / kode baru 3 hurup / id tabel / order by limit ngambil data terakhir
        $id 	 = $this->M_Admin->buat_kode('tbl_login', 'AG', 'id_login', 'ORDER BY id_login DESC LIMIT 1');
        $this->set_barcode($id);
        $nim 	 = htmlentities($this->input->post('nim', true));
        if ($this->input->post('jurusan', true)) {
            $jur = htmlentities($this->input->post('jurusan', true));
        } else {
            $jur = 0;
        }
		
        $nama  = htmlentities($this->input->post('nama', true));
        $user  = htmlentities($this->input->post('user', true));
        $pass  = htmlentities($this->input->post('pass', true));
        $level = "Anggota";
        // $jenkel = htmlentities($this->input->post('jenkel', true));
        // $telepon = htmlentities($this->input->post('telepon', true));
        // $alamat = "-";
        $email = $this->input->post('email', true);

        $passhash = password_hash($pass, PASSWORD_DEFAULT);

        $dd = $this->db->query("SELECT * FROM tbl_login WHERE user = '$user' OR email = '$email'");
        if ($dd->num_rows() > 0) {
            $this->session->set_flashdata('failed', 'Gagal Update User : '.$nama.' !, Username / Email Anda Sudah Terpakai');
            redirect(base_url('login/daftar'));
        } else {
            $data = array(
                'anggota_id' 	=> $id,
                'nim'			=> 0,
                'nama'			=> $nama,
                'id_jurusan' 	=> 0,
                'user'			=> $user,
                'pass'			=> $passhash,
                'level'			=> $level,
                'email'			=> $email,
                'telepon'		=> '-',
                'jenkel'		=> '-',
                'foto' 			=> 'user_default.png',
                'alamat'		=> '-',
                'tgl_bergabung' => date('Y-m-d')
            );
            $this->db->insert('tbl_login', $data);

            $this->session->set_flashdata('success', 'Daftar User telah berhasil !');
            redirect(base_url('login'));
        }
    }

    public function auth()
    {
        $user = htmlspecialchars($this->input->post('user', true), ENT_QUOTES);
        $pass = htmlspecialchars($this->input->post('pass', true), ENT_QUOTES);
        // auth
        $proses_login = $this->db->query("SELECT * FROM tbl_login WHERE user = ?", array($user));
        $row = $proses_login->num_rows();
        if ($row > 0) {
            $hasil_login = $proses_login->row_array();
            if (password_verify($pass, $hasil_login['pass'])) {
                $hasil_login = $proses_login->row_array();

                // create session
                $this->session->set_userdata('masuk_perpus', true);
                $this->session->set_userdata('level', $hasil_login['level']);
                $this->session->set_userdata('ses_id', $hasil_login['id_login']);
                $this->session->set_userdata('anggota_id', $hasil_login['anggota_id']);

                redirect(base_url('dashboard'));
            } else {
                echo '<script>alert("Login Gagal, Periksa Kembali Password Anda"); window.location="'.base_url('login').'"</script>';
            }
        } else {
            echo '<script>alert("Login Gagal, Periksa Kembali Username dan Password Anda"); window.location="'.base_url('login').'"</script>';
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}
