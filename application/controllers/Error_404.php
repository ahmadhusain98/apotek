<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error_404 extends CI_Controller
{
  public function index()
  {
    $data = [
      'judul' => 'Selamat Datang Kembali',
    ];
    $this->template->load('Template/Content', '404', $data);
  }
}
