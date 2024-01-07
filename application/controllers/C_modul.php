<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_modul extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $user = $this->session->userdata('username');
    if (empty($user)) {
      redirect("Auth");
    }
  }

  public function index()
  {
    $data = [
      'judul' => 'Konfgurasi Modul',
      'list' => $this->db->get('m_modul')->result(),
    ];
    $this->template->load('Template/Content', 'Konfig/Modul', $data);
  }

  public function Tab($par)
  {
    if ($par == 1) {
      $data = [
        'list_ajax' => 'C_modul/list_modul',
      ];
      $this->load->view("Konfig/V_modul", $data);
    } else if ($par == 2) {
      $data = [
        'list_ajax' => 'C_modul/list_menu',
      ];
      $this->load->view("Konfig/V_menu", $data);
    } else {
      $data = [
        'list_ajax' => 'C_modul/list_submodul',
      ];
      $this->load->view("Konfig/V_submenu", $data);
    }

    $this->load->view('datatable', $data);
  }

  public function list_modul()
  {
    $table          = 'm_modul';
    $column_order   = ['id', 'nama'];
    $column_search  = ['id', 'nama'];
    $order          = ['nama', 'ASC'];
    $kondisi        = 'modul';

    $data   = [];
    $no     = 1;
    $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi);
    foreach ($list as $l) {
      $row              = [];

      if ($l->nama == '') {
        $nama = 'Beranda';
      } else {
        $nama = $l->nama;
      }
      $row[]            = '<div class="text-right">' . $no . '</div>';
      $row[]            = $nama;
      $row[]            = '<div class="text-center">
        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $nama . '"><i class="fa-solid fa-repeat"></i></button>
        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $nama . '"><i class="fa fa-ban"></i></button>
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

  public function list_menu()
  {
    $table          = 'menu';
    $column_order   = ['id', 'nama', 'id_modul'];
    $column_search  = ['id', 'nama', 'id_modul'];
    $order          = ['nama', 'ASC'];
    $kondisi        = 'menu';

    $data   = [];
    $no     = 1;
    $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi);
    foreach ($list as $l) {
      $row              = [];

      if ($this->M_central->getDataRow('m_modul', ['id' => $l->id_modul])->nama == '') {
        $nama_modul = 'Beranda';
      } else {
        $nama_modul = $this->M_central->getDataRow('m_modul', ['id' => $l->id_modul])->nama;
      }
      $row[]            = '<div class="text-right">' . $no . '</div>';
      $row[]            = $l->nama;
      $row[]            = $nama_modul;
      $row[]            = '<div class="text-center">
        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '"><i class="fa-solid fa-repeat"></i></button>
        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '"><i class="fa fa-ban"></i></button>
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

  public function list_submodul()
  {
    $table          = 'sub_menu';
    $column_order   = ['id', 'nama', 'id_menu'];
    $column_search  = ['id', 'nama', 'id_menu'];
    $order          = ['nama', 'ASC'];
    $kondisi        = 'submenu';

    $data   = [];
    $no     = 1;
    $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi);
    foreach ($list as $l) {
      $row              = [];

      $row[]            = '<div class="text-right">' . $no . '</div>';
      $row[]            = $l->nama;
      $row[]            = $this->M_central->getDataRow('menu', ['id' => $l->id_menu])->nama;
      $row[]            = '<div class="text-center">
        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama . '"><i class="fa-solid fa-repeat"></i></button>
        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->nama . '"><i class="fa fa-ban"></i></button>
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

  public function change()
  {
    $idDari = $this->input->post("idDari");
    $idKe = $this->input->post("idKe");

    $menuDari = $this->db->get_where('menu', ['id_modul' => $idDari])->result();
    $menuKe = $this->db->get_where('menu', ['id_modul' => $idKe])->result();

    foreach ($menuDari as $md) {
      $idMenu = $md->id;
      $this->M_central->updateData('m_modul', ['id' => 999999], ['id' => $idDari]);
      $this->M_central->updateData('menu', ['id_modul' => $idKe], ['id' => $idMenu]);
    }

    foreach ($menuKe as $mk) {
      $idMenu = $mk->id;
      $this->M_central->updateData('m_modul', ['id' => $idDari], ['id' => $idKe]);
      $this->M_central->updateData('m_modul', ['id' => $idKe], ['id' => 999999]);
      $this->M_central->updateData('menu', ['id_modul' => $idDari], ['id' => $idMenu]);
    }

    echo json_encode(['response' => 1]);
  }

  public function l_modul()
  {
    $data = [
      'judul' => 'Master Modul',
      'modul' => $this->db->get('m_modul')->result(),
      'menu' => $this->db->get('menu')->result(),
      'submenu' => $this->db->get('sub_menu')->result(),
    ];
    $this->template->load('Template/Content', 'Konfig/Ms_modul', $data);
  }
}
