<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aktifasi extends CI_Controller
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
            'judul' => 'Aktifasi Akun',
            $this->data,
            'list_ajax' => 'Aktifasi/list_user',
            'user_aktivasi' => $this->M_central->getResult('user'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
            'userdata' => $userdata,
        ];

        $this->template->load('Template/Content', 'Keamanan/Aktifasi', $data);
    }

    public function list_user()
    {
        $table          = 'user';
        $column_order   = ['id', 'username', 'nama', 'status_akun', 'status_aktif', 'kode_role'];
        $column_search  = ['id', 'username', 'nama', 'status_akun', 'status_aktif', 'kode_role'];
        $order          = ['username', 'ASC'];
        $kondisi        = '';

        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);

        $data   = [];
        $no     = 1;
        $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi);
        foreach ($list as $l) {
            $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]);
            $row              = [];

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = $l->username;
            $row[]            = $l->nama;
            $row[]            = '<div class="text-center">' . (($l->status_aktif > 0) ? '<span class="badge badge-success">Online</span>' : '<span class="badge badge-secondary">Offline</span>') . '</div>';
            $row[]            = '<div class="text-center">' . (($l->status_akun > 0) ? '<span class="badge badge-primary">Aktif</span>' : '<span class="badge badge-danger">Non-aktif</span>') . '</div>';
            $row[]            = $this->M_central->getDataRow('m_role', ['kode' => $l->kode_role])->keterangan;
            if ($l->status_aktif > 0) {
                if ($l->status_akun > 0) {
                    $row[]            = '<div class="text-center">
                        <button type="button" style="background-color: transparent; border: 0px;" disabled><i class="fa-solid fa-toggle-on" style="color: green;"></i></button>
                    </div>';
                } else {
                    $row[]            = '<div class="text-center">
                        <button type="button" style="background-color: transparent; border: 0px;" disabled><i class="fa-solid fa-toggle-off" style="color: black;"></i></button>
                    </div>';
                }
            } else {
                if ($l->status_akun > 0) {
                    if ($cek_aksi_role->setuju > 0) {
                        $row[]            = '<div class="text-center">
                            <button type="button" style="background-color: transparent; border: 0px;" onclick="nonaktivasi(' . "'" . $l->username . "'" . ')"><i class="fa-solid fa-toggle-on" style="color: green;"></i></button>
                        </div>';
                    } else {
                        $row[]            = '<div class="text-center">
                            <button type="button" style="background-color: transparent; border: 0px;" disabled><i class="fa-solid fa-toggle-on" style="color: green;"></i></button>
                        </div>';
                    }
                } else {
                    if ($cek_aksi_role->setuju > 0) {
                        $row[]            = '<div class="text-center">
                            <button type="button" style="background-color: transparent; border: 0px;" onclick="aktivasi(' . "'" . $l->username . "'" . ')"><i class="fa-solid fa-toggle-off" style="color: black;"></i></button>
                        </div>';
                    } else {
                        $row[]            = '<div class="text-center">
                            <button type="button" style="background-color: transparent; border: 0px;" disabled><i class="fa-solid fa-toggle-off" style="color: black;"></i></button>
                        </div>';
                    }
                }
            }

            $data[]           = $row;
            $no++;
        }
        $output = [
            "draw"            => $_POST['draw'],
            "recordsTotal"    => count_all($table, $column_order, $column_search, $order, $kondisi),
            "recordsFiltered" => count_filtered($table, $column_order, $column_search, $order, $kondisi),
            "data"            => $data,
        ];
        echo json_encode($output);
    }

    public function akif($username)
    {
        $cek = [
            $this->M_central->updateData('user_aktivasi', ['aktivasi' => 1], ['username' => $username]),
            $this->M_central->updateData('user', ['status_akun' => 1], ['username' => $username]),
        ];

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function non_akif($username)
    {
        $cek = [
            $this->M_central->updateData('user_aktivasi', ['aktivasi' => 0], ['username' => $username]),
            $this->M_central->updateData('user', ['status_akun' => 0], ['username' => $username]),
        ];

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }
}
