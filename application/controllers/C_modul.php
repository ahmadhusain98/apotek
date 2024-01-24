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

  public function l_modul($paramx = '')
  {
    if ($paramx == '') {
      $param = 1;
    } else {
      $param = $paramx;
    }

    $data = [
      'judul' => 'Master Modul',
      'modul' => $this->db->get('m_modul')->result_object(),
      'menu' => $this->db->get('menu')->result_object(),
      'submenu' => $this->db->get('sub_menu')->result_object(),
      'tabFor' => $param,
    ];
    $this->template->load('Template/Content', 'Konfig/Ms_modul', $data);
  }

  public function proses($param)
  {
    if ($param == 1) {
      $nama_modul = $this->input->post('nama_modul');

      $data = [
        'id' => last_id('m_modul', 'id'),
        'nama' => $nama_modul,
      ];

      $table = 'm_modul';
    }

    $cek = $this->M_central->simpanData($table, $data);

    if ($cek) {
      echo json_encode(['response' => 1]);
    } else {
      echo json_encode(['response' => 0]);
    }
  }

  public function deleted_proses($param, $by)
  {
    $cek = $this->M_central->delData('m_modul', ['id' => $by]);
    // if ($param == 1) {
    // } else {
    //   $cek = false;
    // }

    if ($cek) {
      echo json_encode(['response' => 1]);
    } else {
      echo json_encode(['response' => 0]);
    }
  }
}
