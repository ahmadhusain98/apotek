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
