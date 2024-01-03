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
    $kode_role = 'R0001';
    $kode_member = kode_member($nama);
    $tgl_gabung = date("Y-m-d");
    $status_akun = 1;
    $status_aktif = 0;

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
    ];

    $cek = $this->M_central->simpanData('user', $dataRegist);

    if ($cek) {
      echo json_encode(['response' => 1]);
    } else {
      echo json_encode(['response' => 0]);
    }
  }
}
