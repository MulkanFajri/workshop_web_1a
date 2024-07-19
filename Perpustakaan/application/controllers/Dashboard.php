<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_Admin');
        if ($this->session->userdata('masuk_perpus') != true) {
            $url=base_url('login');
            redirect($url);
        }
    }

    public function index()
    {
        $this->data['uid'] 				= $this->session->userdata('ses_id');
        $this->data['title_web'] 		= 'Dashboard ';
        $this->data['sidebar'] 			= 'dashboard';
        $this->data['count_pengguna']	= $this->db->query("SELECT * FROM tbl_login")->num_rows();
        $this->data['count_buku']		= $this->db->query("SELECT * FROM tbl_buku")->num_rows();
        $this->data['count_kategori']	= $this->db->query("SELECT * FROM tbl_kategori")->num_rows();
        $this->data['count_pinjam']		= $this->db->query("SELECT sum(jml) as jml FROM tbl_pinjam WHERE status = 'Dipinjam'")->row();
        $this->data['count_kembali']	= $this->db->query("SELECT sum(jml) as jml FROM tbl_pinjam WHERE status = 'Di Kembalikan' AND periode_kembali = '".date('m-Y')."'")->row();

        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('dashboard_view', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function track()
    {
        $this->data['uid'] 				= $this->session->userdata('ses_id');
        $this->data['title_web'] 		= 'Visitor Counter';
        $this->data['count_pengunjung'] = $this->db->query("SELECT * FROM tbl_pengunjung WHERE tgl_masuk = ?", [date('Y-m-d')])->num_rows();
        $this->data['sidebar'] 			= 'track';
        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('track/track_view', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function data()
    {
        $this->data['uid'] 				= $this->session->userdata('ses_id');
        $this->data['title_web'] 		= 'Visitor Counter';
        $this->data['tbl_pengunjung'] 	= $this->db->query("SELECT * FROM tbl_pengunjung ORDER BY id DESC")->result();
        $this->data['count_pengunjung'] = $this->db->query("SELECT * FROM tbl_pengunjung WHERE tgl_masuk = ?", [date('Y-m-d')])->num_rows();
        $this->data['sidebar'] 			= 'track';
        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('track/track_data', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function data_pengunjung()
    {
        $query  = "SELECT l.id_jurusan, p.* FROM  tbl_pengunjung p LEFT JOIN tbl_login l ON p.anggota_id=l.anggota_id";
        $where  = null;
        $isWhere = " YEAR(p.tgl_masuk) = '".$this->input->get('tahun')."' ";
		if(!empty($this->input->get('jurusan'))) {
			$where = array('l.id_jurusan' => (int)$this->input->get('jurusan'));
		}
        $search = array('p.anggota_id','p.nama','p.tgl_masuk');
        // $where  = array('nama_kategori' => 'Tutorial');
        // jika memakai IS NULL pada where sql
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }
	
    public function print_pengunjung()
    {
        $this->load->library('pdfgenerator');

		$tahun = $this->input->get('tahun') ?? date('Y');
        $isWhere = " WHERE YEAR(p.tgl_masuk) = '".$tahun."' ";
		$this->data['title_web'] = ' Data Pengunjung Tahun '.$tahun;
		if(!empty($this->input->get('jurusan'))) {
			$jur = $this->db->get_where('tbl_jurusan', ['id_jurusan' => (int)$this->input->get('jurusan')])->row();
			$isWhere .= ' AND l.id_jurusan = "'.(int)$this->input->get('jurusan').'" ';
			$this->data['title_web'] .= ' - '.$jur->nama_jurusan; 
		}
        $query  = "SELECT l.id_jurusan, p.* FROM  tbl_pengunjung p LEFT JOIN tbl_login l ON p.anggota_id=l.anggota_id ".$isWhere;
		$pengunjung = $this->db->query($query)->result();

		$this->data['pengunjung'] = $pengunjung;
        // filename dari pdf ketika didownload
        $file_pdf 	 = $this->data['title_web'];
        // setting paper
        $paper 		 = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "landscape";

        $html 		 = $this->load->view('track/print_pengunjung', $this->data, true);
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function store()
    {
        $this->form_validation->set_rules("nama", "Nama", "required");
        if ($this->form_validation->run() != false) {
			$anggotaId =  $this->input->post("anggota_id", true) ?? '-';
            $data 	   = [
							'anggota_id' 	=> $anggotaId,
							'nama' 			=> htmlspecialchars($this->input->post("nama", true), ENT_QUOTES),
							'created_at' 	=> date('Y-m-d H:i:s'),
							'tgl_masuk' 	=> date('Y-m-d'),
						];

            $this->db->insert("tbl_pengunjung", $data);
            $this->session->set_flashdata("success", " Berhasil Insert Data ! ");
            redirect(base_url("dashboard/track"));
        } else {
            $this->session->set_flashdata("failed", " Gagal Insert Data ! ".validation_errors());
            redirect(base_url("dashboard/track"));
        }
    }

    public function delete()
    {
        $id = (int)$this->input->get("id");
        $cek = $this->db->get_where("tbl_pengunjung", ["id" => $id]); // tulis id yang dituju
        if ($cek->num_rows() > 0) {
            $this->db->where("id", $id); // tulis id yang dituju
            $this->db->delete("tbl_pengunjung");
            $this->session->set_flashdata("pesan", " Berhasil Delete Data ! ");
            redirect(base_url("dashboard/data"));
        } else {
            $this->session->set_flashdata("pesan", " Gagal Delete Data ! ".validation_errors());
            redirect(base_url("dashboard/data"));
        }
    }

    public function atur()
    {
        $this->data['uid'] 			= $this->session->userdata('ses_id');
        $this->data['title_web'] 	= 'Atur';
        $this->data['sidebar'] 		= 'atur';

        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('atur', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function aturan()
    {
        $data = [
            'nama_perpus' 	=> htmlspecialchars($this->input->post("nama_perpus", true), ENT_QUOTES),
            'email' 		=> htmlspecialchars($this->input->post("email", true), ENT_QUOTES),
            'telepon' 		=> htmlspecialchars($this->input->post("telepon", true), ENT_QUOTES),
            'alamat' 		=> htmlspecialchars($this->input->post("alamat", true), ENT_QUOTES),
        ];

        $upload_foto = $_FILES['logo']['name'];
        if ($upload_foto) {
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/image';
            // $this->load->library('upload', $config);
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('logo')) {
                $foto_baru = $this->upload->data('file_name');
                $this->db->set('logo', $foto_baru);
            }
        }

        $this->db->where("id", 1); // ubah id dan postnya
        $this->db->update("tbl_atur", $data);
        $this->session->set_flashdata("success", " Berhasil Update Data ! ");
        redirect(base_url('dashboard/atur'));
    }
}
