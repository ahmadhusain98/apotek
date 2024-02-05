<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{
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

    /**
     * Pre Order
     */

    public function po()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Vendor',
            'list_ajax' => 'Umum/list_vendor',
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];
        $this->template->load('Template/Content', 'Pembelian/Pre_order', $data);
    }
}
