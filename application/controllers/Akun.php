<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public $data;

    function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'id_ID.utf8');
        date_default_timezone_set('Asia/Jakarta');

        $sess = $this->session->userdata('username');

        if (empty($sess)) {
            redirect('Auth');
        }
    }

    public function index()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Profil',
            $this->data,
            'm_role' => $this->M_central->getResult('m_role'),
            'userdata' => $userdata,
        ];

        $this->template->load('Template/Content', 'Akun/Profil', $data);
    }

    public function update_proses()
    {
        $username = $this->session->userdata('username');

        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $nohp = $this->input->post('nohp');
        $gender = $this->input->post('gender');
        $alamat = $this->input->post('alamat');
        $cek_foto = $this->input->post('cek_foto');
        $sandi_ori = $this->input->post('password');
        $sandi = md5($sandi_ori);

        $config['upload_path'] = 'assets/img/user/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '2048';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($_FILES['foto_profil']['name']) {
            $this->upload->do_upload('foto_profil');
            $foto = $this->upload->data('file_name');
        } else {
            if (($cek_foto == 'default1.svg') || ($cek_foto == 'default2.svg')) {
                if ($gender == 'P') {
                    $foto = 'default1.svg';
                } else {
                    $foto = 'default2.svg';
                }
            } else {
                $foto = $cek_foto;
            }
        }

        $data = [
            'nama' => $nama,
            'email' => $email,
            'tempat_lahir' => $tempat_lahir,
            'tgl_lahir' => $tgl_lahir,
            'nohp' => $nohp,
            'gender' => $gender,
            'alamat' => $alamat,
            'foto' => $foto,
            'sandi_ori' => $sandi_ori,
            'sandi' => $sandi,
        ];

        $cek = $this->M_central->updateData('user', $data, ['username' => $username]);

        if ($cek) {
            echo json_encode(['response' => 1, 'username' => $username]);
        } else {
            echo json_encode(['response' => 0, 'username' => $username]);
        }
    }
}
