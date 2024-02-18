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
            'judul' => 'Pre Order',
            'list_ajax' => 'Pembelian/list_po',
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];
        $this->template->load('Template/Content', 'Pembelian/Pre_order', $data);
    }

    public function list_po()
    {
        $table          = 'h_preorder';
        $column_order   = ['h_preorder.id', 'kode_unit', 'invoice', 'v.nama AS nama_vendor', 'g.nama AS nama_gudang', 'total', 'pajak', 'h_preorder.status', 'h_preorder.user'];
        $column_search  = ['h_preorder.id', 'kode_unit', 'invoice', 'v.nama AS nama_vendor', 'g.nama AS nama_gudang', 'total', 'pajak', 'h_preorder.status', 'h_preorder.user'];
        $order          = ['invoice', 'DESC'];
        $kondisi        = 'pre_order';
        $kondisi2       = $this->session->userdata('kode_unit');

        $data   = [];
        $no     = 1;
        $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi, $kondisi2);
        foreach ($list as $l) {
            $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $this->session->userdata('kode_role')]);
            $row              = [];

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = $l->invoice;
            $row[]            = $l->nama_vendor;
            $row[]            = $l->nama_gudang;
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->pajak) . '</div>';
            $row[]            = '<div class="text-right">Rp. ' . number_format($l->total) . '</div>';
            $row[]            = '<div class="text-center">' . (($l->status > 0) ? '<span class="badge badge-success">Lunas</span>' : '<span class="badge badge-danger">Belum lunas</span>') . '</div>';
            $row[]            = $l->user;
            if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->username . '" onclick="updated(' . "'" . $l->username . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->username . '" onclick="deleted(' . "'" . $l->username . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->username . '" onclick="updated(' . "'" . $l->username . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->username . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->username . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->username . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->username . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->username . '" onclick="deleted(' . "'" . $l->username . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
            }

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

    public function form_po($invoice = '')
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        if ($invoice == '') {
            $judul = 'Tambah PO (Pre Order)';
            $prosesx = 1;
        } else {
            $judul = 'Update PO (Pre Order)';
            $prosesx = 2;
        }
        $data = [
            'judul' => 'Pre Order',
            'judul_form' => $judul,
            'prosesx' => $prosesx,
            'menu' => 'Pembelian/po',
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
            'gudang' => $this->M_central->getDataResult('m_gudang', ['bagian' => 'FARMASI', 'status' => '1']),
            'vendor' => $this->M_central->getDataResult('m_vendor', ['status' => '1']),
            'cabang' => $this->session->userdata('kode_unit'),
        ];
        $this->template->load('Template/Content', 'Pembelian/Form_po', $data);
    }
}
