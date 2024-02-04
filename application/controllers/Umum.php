<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Umum extends CI_Controller
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
     * VENDOR
     */

    public function vendor()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Vendor',
            'list_ajax' => 'Umum/list_vendor',
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];
        $this->template->load('Template/Content', 'Umum/Vendor', $data);
    }

    public function list_vendor()
    {
        $table          = 'm_vendor';
        $column_order   = ['id', 'kode', 'nama', 'alamat', 'nohp', 'email', 'trx_terakhir', 'status'];
        $column_search  = ['id', 'kode', 'nama', 'alamat', 'nohp', 'email', 'trx_terakhir', 'status'];
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
            if ($l->status > 0) {
                $status = '<div class="text-center"><span class="badge badge-success">Aktif</span></div>';
            } else {
                $status = '<div class="text-center"><span class="badge badge-danger">Non-aktif</span></div>';
            }

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = $l->kode;
            $row[]            = $l->nama;
            $row[]            = $l->alamat;
            $row[]            = $l->nohp;
            $row[]            = $l->email;
            $row[]            = (($l->trx_terakhir == '0000-00-00 00:00:00') ? 'Belum ada transaksi' : date('D, m-Y | H:i', strtotime($l->trx_terakhir)));
            $row[]            = $status;
            if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0) && ($cek_aksi_role->setuju > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-success btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Status ' . $l->nama . '" onclick="updated_status(' . "'" . $l->id . "', '" . $l->nama . "', '" . $l->status . "'" . ')"><i class="fa-regular fa-circle-check"></i></button>
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->id . "', '" . $l->nama . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0) && ($cek_aksi_role->setuju < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-success btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Status ' . $l->nama . '" disabled><i class="fa-regular fa-circle-check"></i></button>
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->id . "', '" . $l->nama . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1) && ($cek_aksi_role->setuju > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-success btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Status ' . $l->nama . '" onclick="updated_status(' . "'" . $l->id . "', '" . $l->nama . "', '" . $l->status . "'" . ')"><i class="fa-regular fa-circle-check"></i></button>
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1) && ($cek_aksi_role->setuju < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-success btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Status ' . $l->nama . '" disabled><i class="fa-regular fa-circle-check"></i></button>
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1) && ($cek_aksi_role->setuju > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-success btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Status ' . $l->nama . '" onclick="updated_status(' . "'" . $l->id . "', '" . $l->nama . "', '" . $l->status . "'" . ')"><i class="fa-regular fa-circle-check"></i></button>
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1) && ($cek_aksi_role->setuju < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-success btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Status ' . $l->nama . '" disabled><i class="fa-regular fa-circle-check"></i></button>
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-success btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Status ' . $l->nama . '" disabled><i class="fa-regular fa-circle-check"></i></button>
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->id . "', '" . $l->nama . "'" . ')"><i class="fa fa-ban"></i></button>
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

    public function status_vendor($id)
    {
        $vendor = $this->M_central->getDataRow('m_vendor', ['id' => $id]);
        if ($vendor->status < 1) {
            $status = 1;
        } else {
            $status = 0;
        }
        $cek = $this->M_central->updateData('m_vendor', ['status' => $status], ['id' => $id]);

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function getVendor($id)
    {
        $data = $this->M_central->getDataRow('m_vendor', ['id' => $id]);
        echo json_encode($data);
    }

    public function proses_vendor($param)
    {
        $id = $this->input->post('id');
        $kode = $this->input->post('kode');
        $nama = $this->input->post('nama');
        $nohp = $this->input->post('nohp');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $status = 1;

        $data = [
            'kode' => $kode,
            'nama' => $nama,
            'nohp' => $nohp,
            'email' => $email,
            'alamat' => $alamat,
            'status' => $status,
        ];

        if ($param < 2) {
            $cek = $this->M_central->simpanData('m_vendor', $data);
        } else {
            $cek = $this->M_central->simpanData('m_vendor', $data, ['id' => $id]);
        }

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function deleted_vendor_proses($id)
    {
        $cek = $this->M_central->delData('m_vendor', ['id' => $id]);

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    /**
     * BARANG
     */

    public function barang()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Barang',
            'list_ajax' => 'Umum/list_barang/?cabang=' . $this->session->userdata('kode_unit'),
            'm_role' => $this->M_central->getResult('m_role'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];

        $this->template->load('Template/Content', 'Umum/Barang', $data);
    }

    public function list_barang()
    {
        $cabang = $this->input->get('cabang');
        if (empty($cabang)) {
            $cabangx = $this->session->userdata('kode_unit');
        } else {
            $cabangx = $cabang;
        }

        $table          = 'barang';
        $column_order   = ['barang.id', 'harga_unit.kode_unit', 'barang.kode', 'barang.nama', 'barang.kategori', 'barang.satuan', 'barang.deskripsi', 'harga_unit.harga_beli', 'harga_unit.harga_beli_ppn', 'harga_unit.harga_net', 'harga_unit.harga_jual'];
        $column_search  = ['barang.id', 'harga_unit.kode_unit', 'barang.kode', 'barang.nama', 'barang.kategori', 'barang.satuan', 'barang.deskripsi', 'harga_unit.harga_beli', 'harga_unit.harga_beli_ppn', 'harga_unit.harga_net', 'harga_unit.harga_jual'];
        $order          = ['barang.kode', 'ASC'];
        $kondisi        = 'For_barang';
        $kondisi2       = $cabangx;

        $data   = [];
        $no     = 1;
        $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi, $kondisi2);
        foreach ($list as $l) {
            $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $l->kode_role]);
            $row              = [];

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = $l->kode_unit;
            $row[]            = $l->kode;
            $row[]            = $l->nama;
            $row[]            = $l->kategori;
            $row[]            = $l->satuan;
            $row[]            = $l->harga_beli;
            $row[]            = $l->harga_beli_ppn;
            $row[]            = $l->harga_net;
            $row[]            = $l->harga_jual;
            $row[]            = $l->deskripsi;

            $data[]           = $row;
            $no++;
        }
        $output = [
            "draw"            => $_POST['draw'],
            "recordsTotal"    => count_all($table, $column_order, $column_search, $order, $kondisi, $kondisi2),
            "recordsFiltered" => count_filtered($table, $column_order, $column_search, $order, $kondisi, $kondisi2),
            "data"            => $data,
        ];
        echo json_encode($output);
    }

    public function tambah_barang()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Tambah Barang',
            'menu' => 'Umum/barang',
            'kategori' => $this->M_central->getResult('m_kategori'),
            'satuan' => $this->M_central->getResult('m_satuan'),
            'm_role' => $this->M_central->getResult('m_role'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
            'kode' => kode_barang('Obat Ringan', 'Botol Plastik'),
        ];

        $this->template->load('Template/Content', 'Umum/Tambah_barang', $data);
    }
}
