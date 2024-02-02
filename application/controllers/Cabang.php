<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang extends CI_Controller
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
    MASTER UNIT
    */

    public function unit()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $data = [
            'judul' => 'Unit',
            $this->data,
            'list_ajax' => 'Cabang/list_unit',
            'm_role' => $this->M_central->getResult('m_role'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
        ];

        $this->template->load('Template/Content', 'Cabang/Unit', $data);
    }

    public function list_unit()
    {
        $table          = 'm_unit';
        $column_order   = ['id', 'kode_unit', 'nama_unit', 'foto', 'penanggungjawab', 'alamat', 'kontak', 'tgl_mulai', 'tgl_selesai', 'status_unit'];
        $column_search  = ['id', 'kode_unit', 'nama_unit', 'foto', 'penanggungjawab', 'alamat', 'kontak', 'tgl_mulai', 'tgl_selesai', 'status_unit'];
        $order          = ['kode_unit', 'ASC'];
        $kondisi        = '';


        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);

        $data   = [];
        $no     = 1;
        $list   = get_datatables($table, $column_order, $column_search, $order, $kondisi);
        foreach ($list as $l) {
            $cek_aksi_role    = $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]);
            $row              = [];

            $row[]            = '<div class="text-right">' . $no . '</div>';
            $row[]            = '<div class="text-center">' . '<img src="' . base_url() . '../assets/img/unit/' . $l->foto . '" class="card-img-top p-3" style="border-radius: 25px; width: 100px;">' . '<br>' . $l->kode_unit . '</div>';
            $row[]            = $l->nama_unit;
            $row[]            = $l->alamat;
            $row[]            = $l->penanggungjawab;
            $row[]            = $l->kontak;
            $hari             = hitung($l->tgl_selesai);
            if ($hari >= 90) {
                $color = 'success';
            } else if ($hari >= 60 && $hari <= 90) {
                $color = 'warning';
            } else {
                $color = 'danger';
            }
            if ($hari < 1) {
                $text = 'Tidak aktif';
                $hitung = 0;
            } else {
                $text = 'Aktif';
                $hitung = $hari;
            }
            $row[]            = '<div class="text-center">' . (($l->status_unit > 0) ? '<span class="badge badge-' . $color . '">' . $text . ' ' . $hitung . ' Hari</span>' : '<span class="badge badge-secondary">Non-aktif</span>') . '</div>';
            if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus > 0)) {
                if ($l->status_unit > 0) {
                    $row[]            = '<div class="text-center">
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" onclick="updated(' . "'" . $l->kode_unit . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" disabled><i class="fa fa-ban"></i></button>
                    </div>';
                } else {
                    $row[]            = '<div class="text-center">
                        <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" onclick="updated(' . "'" . $l->kode_unit . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                        <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" onclick="deleted(' . "'" . $l->kode_unit . "'" . ')"><i class="fa fa-ban"></i></button>
                    </div>';
                }
            } else if (($cek_aksi_role->ubah > 0) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" onclick="updated(' . "'" . $l->kode_unit . "'" . ')"><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else if (($cek_aksi_role->ubah < 1) && ($cek_aksi_role->hapus < 1)) {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" disabled><i class="fa fa-ban"></i></button>
                </div>';
            } else {
                $row[]            = '<div class="text-center">
                    <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="tooltip" title="Ubah Data ' . $l->nama_unit . '" disabled><i class="fa-solid fa-repeat"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="tooltip" title="Hapus Data ' . $l->kode_unit . '" onclick="deleted(' . "'" . $l->kode_unit . "'" . ')"><i class="fa fa-ban"></i></button>
                </div>';
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

    public function get_unit($kode_unit)
    {
        $data = $this->M_central->getDataRow('m_unit', ['kode_unit' => $kode_unit]);
        echo json_encode($data);
    }

    public function add_unit_proses($param)
    {
        $id = $this->input->post('id');
        $kode_unit = $this->input->post('kode_unit');
        $nama_unit = $this->input->post('nama_unit');
        $penanggungjawab = $this->input->post('penanggungjawab');
        $kontak = $this->input->post('kontak');
        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');
        $alamat = $this->input->post('alamat');

        $date_now = date('Y-m-d');
        if (strtotime($tgl_selesai) >= strtotime($date_now)) {
            $status_unit = 1;
        } else {
            $status_unit = 0;
        }

        $config['upload_path'] = '../assets/img/unit/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '2048';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($_FILES['foto_profil']['name']) {
            $this->upload->do_upload('foto_profil');
        }

        $foto = $this->input->post('name_foto');

        $data = [
            'kode_unit' => $kode_unit,
            'nama_unit' => $nama_unit,
            'foto' => $foto,
            'penanggungjawab' => $penanggungjawab,
            'kontak' => $kontak,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'alamat' => $alamat,
            'status_unit' => $status_unit,
        ];

        if ($param == 1) {
            $cek = $this->M_central->simpanData('m_unit', $data);
        } else {
            $cek = $this->M_central->updateData('m_unit', $data, ['id' => $id]);
        }

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function deleted_unit_proses($kode_unit)
    {
        $data = $this->M_central->getDataRow('m_unit', ['kode_unit' => $kode_unit]);

        if ($data->foto == 'default.png') {
        } else {
            $lokasi = '../assets/img/unit/' . $data->foto;
            if (file_exists($lokasi)) {
                unlink($lokasi);
            }
        }

        $cek = $this->M_central->delData('m_unit', ['kode_unit' => $kode_unit]);

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    /*
    MASTER PENGELOLA
    */

    public function pengelola()
    {
        $sess = $this->session->userdata('username');
        $userdata = $this->M_central->getDataRow('user', ['username' => $sess]);
        $now = date('Y-m-d');
        $cabang = $this->M_central->getDataResult('m_unit', ['tgl_selesai >= ' => $now]);
        $data = [
            'judul' => 'Pengelola Unit',
            $this->data,
            'table' => $this->M_central->getDataResult('user', ['kode_role <> ' => 'R0005']),
            'm_role' => $this->M_central->getResult('m_role'),
            'role_aksi' => $this->M_central->getDataRow('role_aksi', ['kode_role' => $userdata->kode_role]),
            'cabang' => $cabang,
        ];

        $this->template->load('Template/Content', 'Cabang/Pengelola', $data);
    }

    public function del_cabang($kode_unit, $username)
    {
        $where = [
            'username' => $username,
            'kode_unit' => $kode_unit,
        ];
        $cek = [
            $this->db->where($where),
            $this->db->delete("akses_unit"),
        ];

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }

    public function add_cabang($kode_unit, $username)
    {
        $data = [
            'username' => $username,
            'kode_unit' => $kode_unit,
        ];
        $cek = $this->db->insert("akses_unit", $data);

        if ($cek) {
            echo json_encode(['response' => 1]);
        } else {
            echo json_encode(['response' => 0]);
        }
    }
}
