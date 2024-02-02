<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inti extends CI_Controller
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
     * Kategori
     */

    public function kategori()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Kategori Barang',
            'list_ajax' => 'Inti/list_kategori',
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];
        $this->template->load('Template/Content', 'Inti/Kategori', $data);
    }

    public function list_kategori()
    {
        $table          = 'm_kategori';
        $column_order   = ['id', 'kode', 'nama'];
        $column_search  = ['id', 'kode', 'nama'];
        $order          = ['nama', 'ASC'];
        $kondisi        = '';

        $sess           = $this->session->userdata('username');
        $userdata       = $this->M_central->getDataRow('user', ['username' => $sess]);

        $data           = [];
        $no             = 1;
        $list           = get_datatables($table, $column_order, $column_search, $order, $kondisi);
        foreach ($list as $l) {
            $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]);
            $row              = [];

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = $l->kode;
            $row[]            = $l->nama;
            if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->id . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->id . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
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

    public function proses_kategori($param)
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');

        if ($param == 1) {
            $kode = kode_kategori();
        } else {
            $kode = $this->input->post('kode');
        }

        $data = [
            'kode' => $kode,
            'nama' => $nama,
        ];

        if ($param == 1) {
            $cek = $this->M_central->simpanData('m_kategori', $data);
        } else {
            $cek = $this->M_central->updateData('m_kategori', $data, ['id' => $id]);
        }

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function show_data_kategori($id)
    {
        $data = $this->M_central->getDataRow('m_kategori', ['id' => $id]);
        echo json_encode(['response' => 1, 'nama' => $data->nama, 'kode' => $data->kode, 'id' => $data->id]);
    }

    public function del_kategori($id)
    {
        $cek = $this->M_central->delData('m_kategori', ['id' => $id]);

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    /**
     * Satuan
     */

    public function satuan()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Satuan Barang',
            'list_ajax' => 'Inti/list_satuan',
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];
        $this->template->load('Template/Content', 'Inti/Satuan', $data);
    }

    public function list_satuan()
    {
        $table          = 'm_satuan';
        $column_order   = ['id', 'kode', 'nama'];
        $column_search  = ['id', 'kode', 'nama'];
        $order          = ['nama', 'ASC'];
        $kondisi        = '';

        $sess           = $this->session->userdata('username');
        $userdata       = $this->M_central->getDataRow('user', ['username' => $sess]);

        $data           = [];
        $no             = 1;
        $list           = get_datatables($table, $column_order, $column_search, $order, $kondisi);
        foreach ($list as $l) {
            $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]);
            $row              = [];

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = $l->kode;
            $row[]            = $l->nama;
            if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->id . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->id . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
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

    public function proses_satuan($param)
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');

        if ($param == 1) {
            $kode = kode_satuan();
        } else {
            $kode = $this->input->post('kode');
        }

        $data = [
            'kode' => $kode,
            'nama' => $nama,
        ];

        if ($param == 1) {
            $cek = $this->M_central->simpanData('m_satuan', $data);
        } else {
            $cek = $this->M_central->updateData('m_satuan', $data, ['id' => $id]);
        }

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function show_data_satuan($id)
    {
        $data = $this->M_central->getDataRow('m_satuan', ['id' => $id]);
        echo json_encode(['response' => 1, 'nama' => $data->nama, 'kode' => $data->kode, 'id' => $data->id]);
    }

    public function del_satuan($id)
    {
        $cek = $this->M_central->delData('m_satuan', ['id' => $id]);

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    /**
     * Jatuh Tempo
     */

    public function tempo()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Jatuh Tempo',
            'list_ajax' => 'Inti/list_tempo',
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];
        $this->template->load('Template/Content', 'Inti/Tempo', $data);
    }

    public function list_tempo()
    {
        $table          = 'm_tempo';
        $column_order   = ['id', 'keterangan', 'hitung'];
        $column_search  = ['id', 'keterangan', 'hitung'];
        $order          = ['keterangan', 'ASC'];
        $kondisi        = '';

        $sess           = $this->session->userdata('username');
        $userdata       = $this->M_central->getDataRow('user', ['username' => $sess]);

        $data           = [];
        $no             = 1;
        $list           = get_datatables($table, $column_order, $column_search, $order, $kondisi);
        foreach ($list as $l) {
            $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]);
            $row              = [];

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = $l->keterangan;
            $row[]            = $l->hitung . ' Hari';
            if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->keterangan . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->keterangan . '" onclick="deleted(' . "'" . $l->id . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->keterangan . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->keterangan . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->keterangan . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->keterangan . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->keterangan . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->keterangan . '" onclick="deleted(' . "'" . $l->id . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
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

    public function getTempo($id)
    {
        $data = $this->M_central->getDataRow('m_tempo', ['id' => $id]);
        echo json_encode($data);
    }

    public function proses_tempo($param)
    {
        $id = $this->input->post('id');
        $keterangan = $this->input->post('keterangan');
        $hitung = $this->input->post('hitung');

        $data = [
            'keterangan' => $keterangan,
            'hitung' => $hitung,
        ];

        if ($param < 2) {
            $cek = $this->M_central->simpanData('m_tempo', $data);
        } else {
            $cek = $this->M_central->updateData('m_tempo', $data, ['id' => $id]);
        }

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function deleted_tempo_proses($id)
    {
        $cek = $this->M_central->delData('m_tempo', ['id' => $id]);

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }
}
