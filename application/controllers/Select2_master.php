<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Select2_master extends CI_Controller
{
    public function data_barang($cabang)
    {
        $key = $this->input->post('searchTerm');
        if ($key == "") {
            $data = $this->db->query('SELECT b.kode AS id, CONCAT(b.kode, " | ", b.nama, " | ", s.nama) AS text FROM barang b JOIN harga_unit hu ON b.kode = hu.kode_barang JOIN m_kategori k ON k.kode = b.kategori JOIN m_satuan s ON s.kode = b.satuan WHERE hu.kode_unit = "' . $cabang . '" LIMIT 10')->result();
        } else {
            $data = $this->db->query('SELECT b.kode AS id, CONCAT(b.kode, " | ", b.nama, " | ", s.nama) AS text FROM barang b JOIN harga_unit hu ON b.kode = hu.kode_barang JOIN m_kategori k ON k.kode = b.kategori JOIN m_satuan s ON s.kode = b.satuan WHERE hu.kode_unit = "' . $cabang . '" AND (b.kode LIKE "%' . $key . '%" OR b.nama LIKE "%' . $key . '%" OR b.deskripsi LIKE "%' . $key . '%" OR k.nama LIKE "%' . $key . '%" OR s.nama LIKE "%' . $key . '%")')->result();
        }
        echo json_encode($data);
    }
}
