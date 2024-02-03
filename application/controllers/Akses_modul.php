<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akses_modul extends CI_Controller
{
    public $data;

    function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'id_ID.utf8');
        date_default_timezone_set('Asia/Jakarta');

        $sess = $this->session->userdata('username');

        if (empty($sess)) {
            redirect('Auth');
        }
    }

    public function index()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Akses Modul',
            $this->data,
            'user_aktivasi' => $this->M_central->getResult('user'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
            'userdata' => $userdata,
            'modul' => $this->M_central->getResult('m_modul'),
            'm_role' => $this->M_central->getResult('m_role'),
        ];

        $this->template->load('Template/Content', 'Keamanan/Akses_modul', $data);
    }

    public function del_akses($id_modul, $kode_role)
    {
        $where = [
            'kode_role' => $kode_role,
            'id_modul' => $id_modul,
        ];
        $cek = [
            $this->db->where($where),
            $this->db->delete("akses_modul"),
        ];

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function add_akses($id_modul, $kode_role)
    {
        $data = [
            'kode_role' => $kode_role,
            'id_modul' => $id_modul,
        ];
        $cek = $this->db->insert("akses_modul", $data);

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }
}
