<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengelola extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
  }

  var $table_p          = 'user';
  var $column_order_p   = ['id', 'username', 'foto', 'gender', 'nama', 'alamat', 'nohp', 'email', 'tgl_gabung', 'status_akun', 'status_aktif', 'tgl_lahir', 'tempat_lahir', 'kode_role'];
  var $column_search_p  = ['id', 'username', 'foto', 'gender', 'nama', 'alamat', 'nohp', 'email', 'tgl_gabung', 'status_akun', 'status_aktif', 'tgl_lahir', 'tempat_lahir', 'kode_role'];
  var $order_p          = ['username' => 'asc'];
  var $kondisi_p        = ['kode_role' => 'R0001'];

  private function _get_datatables_query()
  {
    $this->db->select($this->column_order_p);
    $this->db->from($this->table_p);
    $this->db->where($this->kondisi_p);
    $this->db->order_by($this->order_p);
    $i = 0;
    foreach ($this->column_search_p as $item) {
      if ($_POST['search']['value']) {
        if ($i === 0) {
          $this->db->group_start();
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if (count($this->column_search_p) - 1 == $i)
          $this->db->group_end();
      }
      $i++;
    }
    if (isset($_POST['order'])) {
      $this->db->order_by($this->column_order_p[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order_p)) {
      $order = $this->order_p;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  public function get_datatables()
  {
    $this->_get_datatables_query();
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $this->input->post('start'));
    $query = $this->db->get();
    return $query->result();
  }

  public function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    $this->db->select($this->column_order_p);
    $this->db->from($this->table_p);
    $this->db->where($this->kondisi_p);
    return $this->db->count_all_results();
  }
}
