<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  public function index()
  {
    $data = [
      'judul' => 'Selamat Datang Kembali',
    ];
    $this->template->load('Template/Content', 'Dashboard/Home', $data);
  }
}
