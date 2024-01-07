<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
  public $data;

  function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');

    if (empty($this->session->userdata('username'))) {
      redirect('Auth');
    }
  }

  public function pengelola()
  {
    $data = [
      'judul' => 'Pengelola',
      $this->data,
      'list_ajax' => 'Users/list_pengelola',
    ];

    $this->template->load('Template/Content', 'Pengguna/Pengelola', $data);
  }

  public function list_pengelola()
  {
    $table          = 'user';
    $column_order   = ['id', 'username', 'foto', 'gender', 'nama', 'alamat', 'nohp', 'email', 'tgl_gabung', 'status_akun', 'status_aktif', 'tgl_lahir', 'tempat_lahir', 'kode_role'];
    $column_search  = ['id', 'username', 'foto', 'gender', 'nama', 'alamat', 'nohp', 'email', 'tgl_gabung', 'status_akun', 'status_aktif', 'tgl_lahir', 'tempat_lahir', 'kode_role'];
    $order          = ['username', 'ASC'];
    $kondisi        = 'user_pengelola';

    $data   = [];
    $no     = 1;
    $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi);
    foreach ($list as $l) {
      $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $l->kode_role]);
      $row              = [];

      $row[]            = '<div class="text-right">' . $no . '</div>';
      $row[]            = $l->username;
      $row[]            = $l->nama;
      $row[]            = $l->nohp;
      $row[]            = ($l->status_aktif > 0) ? 'Aktif' : 'Non-aktif';
      $row[]            = $this->M_central->getDataRow('m_role', ['kode' => $l->kode_role])->keterangan;
      $row[]            = '<div class="text-center">
        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->username . '"><i class="fa-solid fa-repeat"></i></button>
        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->username . '"><i class="fa fa-ban"></i></button>
      </div>';

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
}
