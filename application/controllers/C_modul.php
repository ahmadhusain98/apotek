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

    $id_modulm = $this->input->get('id_modulm');
    if (($id_modulm == '') || ($id_modulm == null)) {
      $menu = $this->db->get('menu')->result_object();
    } else {
      $menu = $this->M_central->getDataResult('menu', ['id_modul' => $id_modulm]);
    }

    $id_menum = $this->input->get('id_menum');
    if (($id_menum == '') || ($id_menum == null)) {
      $submenu = $this->db->get('sub_menu')->result_object();
    } else {
      $submenu = $this->M_central->getDataResult('sub_menu', ['id_menu' => $id_menum]);
    }

    $data = [
      'judul' => 'Master Modul',
      'modul' => $this->db->get('m_modul')->result_object(),
      'menu' => $menu,
      'submenu' => $submenu,
      'tabFor' => $param,
      'kat_modul' => $id_modulm,
      'kat_menu' => $id_menum,
    ];
    $this->template->load('Template/Content', 'Konfig/Ms_modul', $data);
  }

  public function proses($param, $forProses)
  {
    if ($forProses == 1) {
      if ($param == 1) {
        $nama_modul = $this->input->post('nama_modul');

        $data = [
          'id' => last_id('m_modul', 'id'),
          'nama' => $nama_modul,
        ];

        $table = 'm_modul';
      } else if ($param == 2) {
        $id_modul = $this->input->post('id_modulm');
        $nama_menu = $this->input->post('nama_menu');
        $ikon = $this->input->post('ikon_menu');
        $url = $this->input->post('link_url');

        $data = [
          'id' => last_id('menu', 'id'),
          'nama' => $nama_menu,
          'id_modul' => $id_modul,
          'ikon' => $ikon,
          'url' => $url,
        ];

        $table = 'menu';
      } else {
        $id_menu = $this->input->post('id_menum');
        $nama_submenu = $this->input->post('nama_submenu');
        $url = $this->input->post('link_urlm');

        $data = [
          'id' => last_id('sub_menu', 'id'),
          'nama' => $nama_submenu,
          'url' => $url,
          'id_menu' => $id_menu,
        ];

        $table = 'sub_menu';
      }

      $cek = $this->M_central->simpanData($table, $data);
    } else {
      if ($param == 1) {
        $nama_modul = $this->input->post('nama_modul');

        $data = [
          'nama' => $nama_modul,
        ];

        $table = 'm_modul';
        $where = ['id' => $this->input->post('id_modul')];
      } else if ($param == 2) {
        $id = $this->input->post('id_menu');
        $id_modul = $this->input->post('id_modulm');
        $nama_menu = $this->input->post('nama_menu');
        $ikon = $this->input->post('ikon_menu');
        $url = $this->input->post('link_url');

        $data = [
          'nama' => $nama_menu,
          'id_modul' => $id_modul,
          'ikon' => $ikon,
          'url' => $url,
        ];

        $table = 'menu';
        $where = ['id' => $id];
      } else {
        $id = $this->input->post('id_submenu');
        $id_menu = $this->input->post('id_menum');
        $nama_submenu = $this->input->post('nama_submenu');
        $url = $this->input->post('link_urlm');

        $data = [
          'nama' => $nama_submenu,
          'id_menu' => $id_menu,
          'url' => $url,
        ];

        $table = 'sub_menu';
        $where = ['id' => $id];
      }

      $cek = $this->M_central->updateData($table, $data, $where);
    }

    if ($cek) {
      echo json_encode(['response' => 1]);
    } else {
      echo json_encode(['response' => 0]);
    }
  }

  public function showData($param, $by)
  {
    $where = ['id' => $by];

    if ($param == 1) {
      $table = 'm_modul';
    } else if ($param == 2) {
      $table = 'menu';
    } else {
      $table = 'sub_menu';
    }

    $data = $this->M_central->getDataRow($table, $where);

    if ($param == 1) {
      $id = $data->id;
      $nama = $data->nama;

      echo json_encode(['response' => 1, 'id' => $id, 'nama' => $nama]);
    } else if ($param == 2) {
      $id = $data->id;
      $nama = $data->nama;
      $ikon = $data->ikon;
      $url = $data->url;
      $id_modul = $data->id_modul;

      echo json_encode(['response' => 1, 'id' => $id, 'nama' => $nama, 'ikon' => $ikon, 'url' => $url, 'id_modul' => $id_modul]);
    } else if ($param == 3) {
      $id = $data->id;
      $nama = $data->nama;
      $url = $data->url;
      $id_menu = $data->id_menu;

      echo json_encode(['response' => 1, 'id' => $id, 'nama' => $nama, 'url' => $url, 'id_menu' => $id_menu]);
    } else {
      echo json_encode(['response' => 0]);
    }
  }

  public function deleted_proses($param, $by)
  {
    if ($param == 1) {
      $cek = $this->M_central->delData('m_modul', ['id' => $by]);
    } else if ($param == 2) {
      $cek = $this->M_central->delData('menu', ['id' => $by]);
    } else {
      $cek = $this->M_central->delData('sub_menu', ['id' => $by]);
    }

    if ($cek) {
      echo json_encode(['response' => 1]);
    } else {
      echo json_encode(['response' => 0]);
    }
  }
}
