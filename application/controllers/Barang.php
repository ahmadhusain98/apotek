<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public $data;

    function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'id_ID.utf8');
        date_default_timezone_set('Asia/Jakarta');

        $sess = $this->session->userdata('username');

        $user = $this->M_central->getDataRow('user', ['username' => $sess]);

        if (empty($sess)) {
            redirect('Auth');
        } else {
            if (($user->kode_role == 'R0001') || ($user->kode_role == 'R0003')) {
            } else {
                redirect('Dashboard');
            }
        }
    }

    public function index()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Barang',
            $this->data,
            'list_ajax' => 'Barang/list_barang',
            'm_role' => $this->M_central->getResult('m_role'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];

        $this->template->load('Template/Content', 'Barang/Data', $data);
    }
}
