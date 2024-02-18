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
            $cek = $this->M_central->updateData('m_vendor', $data, ['id' => $id]);
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

    public function cek_vendor($kode)
    {
        $cek = $this->M_central->jumdata('m_vendor', ['kode' => $kode]);

        if ($cek > 0) {
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
        $now = date('Y-m-d');
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Barang',
            'list_ajax' => 'Umum/list_barang/?cabang=',
            'm_role' => $this->M_central->getResult('m_role'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
            'm_unit' => $this->M_central->getDataResult('m_unit', ['tgl_selesai >= ' => $now]),
            'm_kategori' => $this->M_central->getResult('m_kategori'),
            'm_satuan' => $this->M_central->getResult('m_satuan'),
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

        $kategori = $this->input->get('kategori');
        if (empty($kategori)) {
            $kategorix = '';
        } else {
            $kategorix = $kategori;
        }

        $satuan = $this->input->get('satuan');
        if (empty($satuan)) {
            $satuanx = '';
        } else {
            $satuanx = $satuan;
        }

        $table          = 'barang';
        $column_order   = ['barang.id', 'harga_unit.kode_unit', 'barang.kode', 'barang.nama', 'barang.kategori', 'barang.satuan', 'barang.deskripsi', 'harga_unit.harga_beli', 'harga_unit.harga_beli_ppn', 'harga_unit.harga_net', 'harga_unit.harga_jual', 'harga_unit.kena_pajak', 'm_kategori.nama as kategorix', 'm_satuan.nama as satuanx'];
        $column_search  = ['barang.id', 'harga_unit.kode_unit', 'barang.kode', 'barang.nama', 'barang.kategori', 'barang.satuan', 'barang.deskripsi', 'harga_unit.harga_beli', 'harga_unit.harga_beli_ppn', 'harga_unit.harga_net', 'harga_unit.harga_jual', 'harga_unit.kena_pajak', 'm_kategori.nama as kategorix', 'm_satuan.nama as satuanx'];
        $order          = ['barang.kode', 'ASC'];
        $kondisi        = 'For_barang';
        $kondisi2       = $cabangx;
        $kondisi3       = $kategorix;
        $kondisi4       = $satuan;

        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);

        $data   = [];
        $no     = 1;
        $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi, $kondisi2, $kondisi3, $kondisi4);
        foreach ($list as $l) {
            $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]);
            $row              = [];

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = $l->kode_unit;
            $row[]            = $l->kode;
            $row[]            = $l->nama;
            $row[]            = $l->kategorix;
            $row[]            = $l->satuanx;
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->harga_beli) . '</div>';
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->harga_beli_ppn) . '</div>';
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->harga_net) . '</div>';
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->harga_jual) . '</div>';
            $row[]            = $l->deskripsi;
            if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0)) {
                $row[]            = '<div class="text-center">
                  <a type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" href="' . site_url() . 'Umum/proses_barang/' . $l->kode . '"><i class="fa-solid fa-repeat"></i></a>
                  <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->kode . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                  <a type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" href="' . site_url() . 'Umum/proses_barang/' . $l->kode . '"><i class="fa-solid fa-repeat"></i></a>
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
                  <a type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->kode . "'" . ')"><i class="fa fa-ban"></i></a>
                </div>';
            }

            $data[]           = $row;
            $no++;
        }
        $output = [
            "draw"            => $_POST['draw'],
            "recordsTotal"    => count_all($table, $column_order, $column_search, $order, $kondisi, $kondisi2, $kondisi3, $kondisi4),
            "recordsFiltered" => count_filtered($table, $column_order, $column_search, $order, $kondisi, $kondisi2, $kondisi3, $kondisi4),
            "data"            => $data,
        ];
        echo json_encode($output);
    }

    public function proses_barang($kode_barang = '')
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $unit = $this->session->userdata('kode_unit');
        $now = date('Y-m-d');

        if ($kode_barang == '') {
            $judul_form = 'Tambah Barang';
            $prosesx = 1;
            $barang = '';
            $harga = '';
        } else {
            $judul_form = 'Update Barang';
            $prosesx = 2;
            $barang = $this->M_central->getDataRow('barang', ['kode' => $kode_barang]);
            $harga = $this->M_central->getDataRow('harga_unit', ['kode_barang' => $kode_barang, 'kode_unit' => $unit]);
        }

        $data = [
            'judul' => $judul_form,
            'menu' => 'Umum/barang',
            'kategori' => $this->M_central->getResult('m_kategori'),
            'satuan' => $this->M_central->getResult('m_satuan'),
            'm_role' => $this->M_central->getResult('m_role'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
            'prosesx' => $prosesx,
            'judul_form' => $judul_form,
            'barang' => $barang,
            'harga' => $harga,
            'list_ajax' => 'Umum/list_harga_barang_unit/' . $kode_barang,
            'm_unit' => $this->M_central->getDataResult('m_unit', ['tgl_selesai >= ' => $now]),
        ];

        $this->template->load('Template/Content', 'Umum/Form_barang', $data);
    }

    public function list_harga_barang_unit($kode_barang = '')
    {
        $table          = 'harga_unit';
        $column_order   = ['harga_unit.kode_unit', 'harga_unit.harga_beli', 'harga_unit.harga_beli_ppn', 'harga_unit.harga_net', 'harga_unit.harga_jual'];
        $column_search  = ['harga_unit.kode_unit', 'harga_unit.harga_beli', 'harga_unit.harga_beli_ppn', 'harga_unit.harga_net', 'harga_unit.harga_jual'];
        $order          = ['harga_unit.kode_unit', 'ASC'];
        $kondisi        = 'For_harga_barang';
        $kondisi2       = $kode_barang;

        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);

        $data   = [];
        $no     = 1;
        $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi, $kondisi2);
        foreach ($list as $l) {
            $row              = [];

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = $l->kode_unit;
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->harga_beli) . '</div>';
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->harga_beli_ppn) . '</div>';
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->harga_net) . '</div>';
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->harga_jual) . '</div>';

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

    public function proses_barang_aksi($param)
    {
        $kode_unit = $this->session->userdata('kode_unit');
        $kategori = $this->input->post('kategori');
        $m_kategori = $this->M_central->getDataRow('m_kategori', ['kode' => $kategori]);
        $satuan = $this->input->post('satuan');
        $m_satuan = $this->M_central->getDataRow('m_satuan', ['kode' => $satuan]);

        if ($param < 2) {
            $kode = kode_barang($m_kategori->nama, $m_satuan->nama);
        } else {
            $kode = $this->input->post('kode');
        }

        $nama = $this->input->post('nama');
        $deskripsi = $this->input->post('deskripsi');
        $harga_beli = str_replace(",", "", $this->input->post('harga_beli'));
        $kena_pajak = $this->input->post('kena_pajak');
        $harga_beli_ppn = str_replace(",", "", $this->input->post('harga_beli_ppn'));
        $harga_net = str_replace(",", "", $this->input->post('harga_net'));
        $harga_jual = str_replace(",", "", $this->input->post('harga_jual'));

        $data_barang = [
            'kode' => $kode,
            'nama' => $nama,
            'kategori' => $kategori,
            'satuan' => $satuan,
            'deskripsi' => $deskripsi,
        ];

        $unit = $this->M_central->getResult('m_unit');
        foreach ($unit as $un) {
            if ($param < 2) {
                $data_harga = [
                    'kode_unit' => $un->kode_unit,
                    'kode_barang' => $kode,
                    'harga_beli' => $harga_beli,
                    'kena_pajak' => $kena_pajak,
                    'harga_beli_ppn' => $harga_beli_ppn,
                    'harga_net' => $harga_net,
                    'harga_jual' => $harga_jual,
                ];
                $cek = $this->M_central->simpanData('harga_unit', $data_harga);
            } else {
                $data_harga = [
                    'kode_barang' => $kode,
                    'harga_beli' => $harga_beli,
                    'kena_pajak' => $kena_pajak,
                    'harga_beli_ppn' => $harga_beli_ppn,
                    'harga_net' => $harga_net,
                    'harga_jual' => $harga_jual,
                ];
                $cek = $this->M_central->updateData('harga_unit', $data_harga, ['kode_barang' => $kode, 'kode_unit' => $kode_unit]);
            }
        }

        if ($param < 2) {
            $cek = $this->M_central->simpanData('barang', $data_barang);
        } else {
            $cek = $this->M_central->updateData('barang', $data_barang, ['kode' => $kode]);
        }

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function deleted_barang($kode_barang)
    {
        $cek = [
            $this->M_central->delData('barang', ['kode' => $kode_barang]),
            $this->M_central->delData('harga_unit', ['kode_barang' => $kode_barang]),
        ];

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    /**
     * GUDANG
     */

    public function gudang()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Vendor',
            'list_ajax' => 'Umum/list_gudang',
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];
        $this->template->load('Template/Content', 'Umum/Gudang', $data);
    }

    public function list_gudang()
    {
        $table          = 'm_gudang';
        $column_order   = ['id', 'kode', 'nama', 'bagian', 'nohp', 'status'];
        $column_search  = ['id', 'kode', 'nama', 'bagian', 'nohp', 'status'];
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
            $row[]            = $l->bagian;
            $row[]            = $l->nohp;
            $row[]            = $status;
            if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0) && ($cek_aksi_role->setuju > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->id . "', '" . $l->nama . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0) && ($cek_aksi_role->setuju < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" onclick="deleted(' . "'" . $l->id . "', '" . $l->nama . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1) && ($cek_aksi_role->setuju > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1) && ($cek_aksi_role->setuju < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" onclick="updated(' . "'" . $l->id . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1) && ($cek_aksi_role->setuju > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1) && ($cek_aksi_role->setuju < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else {
                $row[]            = '<div class="text-center">
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

    public function proses_gudang($param)
    {
        $id = $this->input->post('id');
        $kode = $this->input->post('kode');
        $nama = $this->input->post('nama');
        $nohp = $this->input->post('nohp');
        $status = $this->input->post('status_aktif');
        $bagian = $this->input->post('bagian');

        $data = [
            'kode' => $kode,
            'nama' => $nama,
            'nohp' => $nohp,
            'bagian' => $bagian,
            'status' => $status,
        ];

        if ($param < 2) {
            $cek = $this->M_central->simpanData('m_gudang', $data);
        } else {
            $cek = $this->M_central->updateData('m_gudang', $data, ['id' => $id]);
        }

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function getGudang($id)
    {
        $data = $this->M_central->getDataRow('m_gudang', ['id' => $id]);
        echo json_encode($data);
    }

    public function deleted_gudang_proses($id)
    {
        $cek = $this->M_central->delData('m_gudang', ['id' => $id]);

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function cek_gudang($kode)
    {
        $cek = $this->M_central->jumdata('m_gudang', ['kode' => $kode]);

        if ($cek > 0) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }
}
