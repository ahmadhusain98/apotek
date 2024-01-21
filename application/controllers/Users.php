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
  PENGELOLA SISTEM
  */

  public function pengelola()
  {
    $sess = $this->session->userdata('username');
    $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
    $data = [
      'judul' => 'Pengelola',
      $this->data,
      'list_ajax' => 'Users/list_pengelola',
      'm_role' => $this->M_central->getResult('m_role'),
      'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
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
      $row[]            = (($l->status_aktif > 0) ? 'Aktif' : 'Non-aktif');
      $row[]            = $this->M_central->getDataRow('m_role', ['kode' => $l->kode_role])->keterangan;
      if ($l->status_aktif > 0) {
        $row[]            = '<div class="text-center">
          <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->username . '" disabled><i class="fa-solid fa-repeat"></i></button>
          <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->username . '" disabled><i class="fa fa-ban"></i></button>
        </div>';
      } else {
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

  public function add_pengelola_proses($param)
  {
    $nama = $this->input->post('nama');
    $username = $this->input->post('username');
    $nohp = $this->input->post('nohp');
    $email = $this->input->post('email');
    $tempat_lahir = $this->input->post('tempat_lahir');
    $tgl_lahir = $this->input->post('tgl_lahir');
    $alamat = $this->input->post('alamat');
    $gender = $this->input->post('gender');
    $kode_role = $this->input->post('kode_role');
    $status_akun = 1;
    $status_aktif = 0;
    $sandi_ori = $this->input->post('password');
    $sandi = md5($sandi_ori);

    if ($param == 2) {
      $kode_member = $this->M_central->getDataRow('user', ['username' => $username])->kode_member;
      $tgl_gabung = date("Y-m-d", strtotime($this->M_central->getDataRow('user', ['username' => $username])->tgl_gabung));
    } else {
      $kode_member = kode_member($nama);
      $tgl_gabung = date("Y-m-d");
    }

    if ($gender == 'P') {
      $foto = 'default1.svg';
    } else {
      $foto = 'default2.svg';
    }

    $dataRegist = [
      'username' => $username,
      'sandi' => $sandi,
      'sandi_ori' => $sandi_ori,
      'kode_member' => $kode_member,
      'nama' => $nama,
      'foto' => $foto,
      'alamat' => $alamat,
      'nohp' => $nohp,
      'email' => $email,
      'tgl_gabung' => $tgl_gabung,
      'status_akun' => $status_akun,
      'status_aktif' => $status_aktif,
      'tgl_lahir' => $tgl_lahir,
      'tempat_lahir' => $tempat_lahir,
      'gender' => $gender,
      'kode_role' => $kode_role,
    ];

    if ($param == 2) {
      $cek = $this->M_central->updateData('user', $dataRegist, ['username' => $username]);
    } else {
      $cek = $this->M_central->simpanData('user', $dataRegist);
    }

    if ($cek) {
      $data_aktivasi = [
        'username' => $username,
        'aktivasi' => 0,
      ];

      $cekaktivasi = $this->M_central->jumdata('user_aktivasi', ['username' => $username]);

      if ($cekaktivasi < 1) {
        $this->M_central->simpanData('user_aktivasi', $data_aktivasi);
      } else {
        $this->M_central->updateData('user_aktivasi', $data_aktivasi, ['username' => $username]);
      }

      echo json_encode(['response' => 1]);
    } else {
      echo json_encode(['response' => 0]);
    }
  }

  public function deleted_pengelola_proses($username)
  {
    $cek_user = $this->M_central->jumdata('user', ['username' => $username]);
    if ($cek_user > 0) {
      $cek = [
        $this->M_central->delData('user', ['username' => $username]),
        $this->M_central->delData('user_aktivasi', ['username' => $username]),
      ];

      if ($cek) {
        echo json_encode(['response' => 1]);
      } else {
        echo json_encode(['response' => 0]);
      }
    } else {
      echo json_encode(['response' => 2]);
    }
  }

  public function get_data_user($username)
  {
    $data = $this->M_central->getDataRow('user', ['username' => $username]);
    if ($data) {
      echo json_encode($data);
    } else {
      echo json_encode(['response' => 0]);
    }
  }

  /*
  MEMBER SISTEM
   */

  public function member()
  {
    $sess = $this->session->userdata('username');
    $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
    $data = [
      'judul' => 'Member',
      $this->data,
      'list_ajax' => 'Users/list_member',
      'm_role' => $this->M_central->getResult('m_role'),
      'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
    ];

    $this->template->load('Template/Content', 'Pengguna/Member', $data);
  }

  public function list_member()
  {
    $table          = 'user';
    $column_order   = ['id', 'username', 'foto', 'gender', 'nama', 'alamat', 'nohp', 'email', 'tgl_gabung', 'status_akun', 'status_aktif', 'tgl_lahir', 'tempat_lahir', 'kode_role'];
    $column_search  = ['id', 'username', 'foto', 'gender', 'nama', 'alamat', 'nohp', 'email', 'tgl_gabung', 'status_akun', 'status_aktif', 'tgl_lahir', 'tempat_lahir', 'kode_role'];
    $order          = ['username', 'ASC'];
    $kondisi        = 'user_member';

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
      $row[]            = (($l->status_aktif > 0) ? 'Aktif' : 'Non-aktif');
      $row[]            = $this->M_central->getDataRow('m_role', ['kode' => $l->kode_role])->keterangan;
      if ($l->status_aktif > 0) {
        $row[]            = '<div class="text-center">
          <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->username . '" disabled><i class="fa-solid fa-repeat"></i></button>
          <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->username . '" disabled><i class="fa fa-ban"></i></button>
        </div>';
      } else {
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

  public function add_member_proses($param)
  {
    $nama = $this->input->post('nama');
    $username = $this->input->post('username');
    $nohp = $this->input->post('nohp');
    $email = $this->input->post('email');
    $tempat_lahir = $this->input->post('tempat_lahir');
    $tgl_lahir = $this->input->post('tgl_lahir');
    $alamat = $this->input->post('alamat');
    $gender = $this->input->post('gender');
    $kode_role = 'R0005';
    $status_akun = 1;
    $status_aktif = 0;
    $sandi_ori = $this->input->post('password');
    $sandi = md5($sandi_ori);

    if ($param == 2) {
      $kode_member = $this->M_central->getDataRow('user', ['username' => $username])->kode_member;
      $tgl_gabung = date("Y-m-d", strtotime($this->M_central->getDataRow('user', ['username' => $username])->tgl_gabung));
    } else {
      $kode_member = kode_member($nama);
      $tgl_gabung = date("Y-m-d");
    }

    if ($gender == 'P') {
      $foto = 'default1.svg';
    } else {
      $foto = 'default2.svg';
    }

    $dataRegist = [
      'username' => $username,
      'sandi' => $sandi,
      'sandi_ori' => $sandi_ori,
      'kode_member' => $kode_member,
      'nama' => $nama,
      'foto' => $foto,
      'alamat' => $alamat,
      'nohp' => $nohp,
      'email' => $email,
      'tgl_gabung' => $tgl_gabung,
      'status_akun' => $status_akun,
      'status_aktif' => $status_aktif,
      'tgl_lahir' => $tgl_lahir,
      'tempat_lahir' => $tempat_lahir,
      'gender' => $gender,
      'kode_role' => $kode_role,
    ];

    if ($param == 2) {
      $cek = $this->M_central->updateData('user', $dataRegist, ['username' => $username]);
    } else {
      $cek = $this->M_central->simpanData('user', $dataRegist);
    }

    if ($cek) {
      $data_aktivasi = [
        'username' => $username,
        'aktivasi' => 0,
      ];

      $cekaktivasi = $this->M_central->jumdata('user_aktivasi', ['username' => $username]);

      if ($cekaktivasi < 1) {
        $this->M_central->simpanData('user_aktivasi', $data_aktivasi);
      } else {
        $this->M_central->updateData('user_aktivasi', $data_aktivasi, ['username' => $username]);
      }

      echo json_encode(['response' => 1]);
    } else {
      echo json_encode(['response' => 0]);
    }
  }

  public function deleted_member_proses($username)
  {
    $cek_user = $this->M_central->jumdata('user', ['username' => $username]);
    if ($cek_user > 0) {
      $cek = [
        $this->M_central->delData('user', ['username' => $username]),
        $this->M_central->delData('user_aktivasi', ['username' => $username]),
      ];

      if ($cek) {
        echo json_encode(['response' => 1]);
      } else {
        echo json_encode(['response' => 0]);
      }
    } else {
      echo json_encode(['response' => 2]);
    }
  }
}
