<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang extends CI_Controller
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

    /*
    MASTER UNIT
    */

    public function unit()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Unit',
            $this->data,
            'list_ajax' => 'Cabang/list_unit',
            'm_role' => $this->M_central->getResult('m_role'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];

        $this->template->load('Template/Content', 'Cabang/Unit', $data);
    }

    public function list_unit()
    {
        $table          = 'm_unit';
        $column_order   = ['id', 'kode_unit', 'nama_unit', 'foto', 'penanggungjawab', 'alamat', 'kontak', 'tgl_mulai', 'tgl_selesai', 'status_unit'];
        $column_search  = ['id', 'kode_unit', 'nama_unit', 'foto', 'penanggungjawab', 'alamat', 'kontak', 'tgl_mulai', 'tgl_selesai', 'status_unit'];
        $order          = ['kode_unit', 'ASC'];
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
            $row[]            = $l->kode_unit;
            $row[]            = $l->nama_unit;
            $row[]            = $l->alamat;
            $row[]            = $l->penanggungjawab;
            $row[]            = $l->kontak;
            $row[]            = '<div class="text-center">' . (($l->status_unit > 0) ? '<span class="badge badge-success">Aktif ' . hitung($l->tgl_selesai) . ' Hari</span>' : '<span class="badge badge-secondary">Non-aktif</span>') . '</div>';
            if ($l->status_unit > 0) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else {
                if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0)) {
                    $row[]            = '<div class="text-center">
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" onclick="updated(' . "'" . $l->kode_unit . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" onclick="deleted(' . "'" . $l->kode_unit . "'" . ')"><i class="fa fa-ban"></i></button>
                    </div>';
                } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1)) {
                    $row[]            = '<div class="text-center">
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" onclick="updated(' . "'" . $l->kode_unit . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" disabled><i class="fa fa-ban"></i></button>
                    </div>';
                } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1)) {
                    $row[]            = '<div class="text-center">
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" disabled><i class="fa-solid fa-repeat"></i></button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" disabled><i class="fa fa-ban"></i></button>
                    </div>';
                } else {
                    $row[]            = '<div class="text-center">
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" disabled><i class="fa-solid fa-repeat"></i></button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" onclick="deleted(' . "'" . $l->kode_unit . "'" . ')"><i class="fa fa-ban"></i></button>
                    </div>';
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

    public function add_unit_proses($param)
    {
        $id = $this->input->post('id');
        $kode_unit = $this->input->post('kode_unit');
        $nama_unit = $this->input->post('nama_unit');
        $penanggungjawab = $this->input->post('penanggungjawab');
        $kontak = $this->input->post('kontak');
        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');
        $alamat = $this->input->post('alamat');

        $data = [
            'kode_unit' => $kode_unit,
            'nama_unit' => $nama_unit,
            'penanggungjawab' => $penanggungjawab,
            'kontak' => $kontak,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'alamat' => $alamat,
            'alamat' => $alamat,
        ];

        if ($param == 1) {
            $cek = $this->M_central->simpanData('m_unit', $data);
        } else {
            $cek = $this->M_central->updateData('m_unit', $data, ['id' => $id]);
        }

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }
}
