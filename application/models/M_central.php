<?php
class M_central extends CI_Model
{
  function jumdata($table, $where)
  {
    return $this->db->get_where($table, $where)->num_rows();
  }

  function simpanData($table, $data)
  {
    return $this->db->insert($table, $data);
  }
}
