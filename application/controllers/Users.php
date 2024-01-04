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

    $this->load->model('M_pengelola');

    $this->data = [
      'list_ajax' => 'Users/list_pengelola',
    ];

    if (empty($this->session->userdata('username'))) {
      redirect('Auth');
    }
  }

  public function pengelola()
  {
    $data = [
      'judul' => 'Pengelola',
      $this->data,
      'list' => $this->M_central->getDataResult('user', ['kode_role' => 'R0001']),
    ];

    $this->template->load('Template/Content', 'Pengguna/Pengelola', $data);
  }

  public function list_pengelola()
  {
    $data   = [];
    $no     = 1;
    $list   = $this->M_pengelola->get_datatables();
    foreach ($list as $l) {
      $row              = [];
      $row[]            = $no;
      $row[]            = $l->username;
      $row[]            = $l->nama;
      $row[]            = $l->nohp;
      $row[]            = $l->status_aktif;
      $row[]            = $l->kode_role;
      // $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $l->kode_role])->row();
      $data[]           = $row;
      $no++;
    }
    $output = [
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->M_pengelola->count_all(),
      "recordsFiltered" => $this->M_pengelola->count_filtered(),
      "data"            => $data,
    ];
    echo json_encode($output);
  }
}
