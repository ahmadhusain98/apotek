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

  function getDataRow($table, $data)
  {
    return $this->db->get_where($table, $data)->row();
  }

  function updateData($table, $data, $where)
  {
    return $this->db->update($table, $data, $where);
  }
}
