<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function index()
  {
    $data = [
      'judul' => 'Selamat Datang',
    ];
    $this->template->load('Template/Auth', 'Auth/Login', $data);
  }

  public function regist()
  {
    $data = [
      'judul' => 'Bergabung Sekarang',
    ];
    $this->template->load('Template/Auth', 'Auth/Regist', $data);
  }

  public function cekUsername($username)
  {
    $data = $this->M_central->jumdata('user', ['username' => $username]);
    if ($data > 0) {
      echo json_encode(['response' => 1]);
    } else {
      echo json_encode(['response' => 0]);
    }
  }

  public function regist_action()
  {
    $nama = $this->input->post('nama');
    $username = $this->input->post('username');
    $sandi = md5($this->input->post('password'));
    $nohp = $this->input->post('nohp');
    $email = $this->input->post('email');
    $tempat_lahir = $this->input->post('tempat_lahir');
    $tgl_lahir = $this->input->post('tgl_lahir');
    $alamat = $this->input->post('alamat');
    $gender = $this->input->post('gender');
    $kode_role = 'R0005';
    $kode_member = kode_member($nama);
    $tgl_gabung = date("Y-m-d");
    $status_akun = 1;
    $status_aktif = 0;

    if ($gender == 'P') {
      $foto = 'default1.svg';
    } else {
      $foto = 'default2.svg';
    }

    $dataRegist = [
      'username' => $username,
      'sandi' => $sandi,
      'kode_member' => $kode_member,
      'nama' => $nama,
      'alamat' => $alamat,
      'nohp' => $nohp,
      'email' => $email,
      'tgl_gabung' => $tgl_gabung,
      'status_akun' => $status_akun,
      'status_aktif' => $status_aktif,
      'tgl_lahir' => $tgl_lahir,
      'tempat_lahir' => $tempat_lahir,
      'kode_role' => $kode_role,
      'gender' => $gender,
      'foto' => $foto,
      'status_akun' => 1,
    ];

    $cek = $this->M_central->simpanData('user', $dataRegist);

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

  public function ajukan_aktivasi($username)
  {
    $cekuser = $this->M_central->jumdata('user', ['username' => $username]);
    if ($cekuser < 1) {
      echo json_encode(['response' => 0]);
    } else {
      $cekaktivasi = $this->M_central->jumdata('user_aktivasi', ['username' => $username]);

      $data = [
        'username' => $username,
        'aktivasi' => 1,
      ];

      if ($cekaktivasi < 1) {
        $cek = $this->M_central->simpanData('user_aktivasi', $data);
      } else {
        $cek = $this->M_central->updateData('user_aktivasi', $data, ['username' => $username]);
      }

      if ($cek) {
        echo json_encode(['response' => 1]);
      } else {
        echo json_encode(['response' => 2]);
      }
    }
  }

  public function cek_user()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $cabang = $this->input->post('cabang');
    $shift = $this->input->post('shift');

    $cekuser = $this->M_central->jumdata('user', ['username' => $username]);

    if ($cekuser < 1) {
      echo json_encode(['response' => 0]);
    } else {
      $cek_aktivasi = $this->M_central->getDataRow('user', ['username' => $username]);
      if ($cek_aktivasi->status_akun > 0) {
        $cekpass = $this->M_central->getDataRow('user', ['username' => $username]);

        if ($cekpass->sandi == md5($password)) {
          $dataSession = [
            'username' => $cekpass->username,
            'nama' => $cekpass->nama,
            'kode_member' => $cekpass->kode_member,
            'kode_role' => $cekpass->kode_role,
            'kode_unit' => $cabang,
            'shift' => $shift,
          ];
          $this->session->set_userdata($dataSession);

          $this->M_central->updateData('user', ['status_aktif' => 1], ['username' => $username]);

          echo json_encode(['response' => 1]);
        } else {
          echo json_encode(['response' => 2]);
        }
      } else {
        echo json_encode(['response' => 3]);
      }
    }
  }

  public function logout_action($param = '')
  {
    $username = $this->session->userdata('username');
    $cek = $this->M_central->updateData('user', ['status_aktif' => 0], ['username' => $username]);
    if ($param == '') {
      if ($cek) {
        echo json_encode(['response' => 1]);
      } else {
        echo json_encode(['response' => 2]);
      }
    } else {
      redirect('Auth');
    }
  }

  public function cekCabang($username)
  {
    $now        = date("Y-m-d");
    $data       = $this->db->query("SELECT * FROM m_unit WHERE kode_unit IN (SELECT kode_unit FROM akses_unit WHERE username = '$username') AND tgl_selesai >= '$now'")->result();
    echo json_encode($data);
  }

  public function cekRole($username)
  {
    $data = $this->M_central->getDataRow('user', ['username' => $username]);
    echo json_encode(['kode_role' => $data->kode_role]);
  }
}
