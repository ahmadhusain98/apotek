<?php
function kode_member($param)
{
  $CI           = &get_instance();

  $number       = 1;
  $initial      = substr($param, 0, 1);
  $awal         = strtoupper($initial);

  $lastNumber   = $CI->db->query('SELECT kode_member FROM user WHERE nama LIKE "' . $initial . '%" ORDER BY id DESC LIMIT 1')->row();
  if ($lastNumber) {
    $number += 1;
    $updateNumber = $awal . sprintf("%09d", $number);
  } else {
    $number = 0;
    $updateNumber = $awal . "000000001";
  }
  return $updateNumber;
}

function last_id($table, $get)
{
  $CI = &get_instance();

  $id = $CI->db->query('SELECT ' . $get . ' FROM ' . $table . ' ORDER BY ' . $get . ' DESC LIMIT 1')->row()->$get;

  return $id + 1;
}
