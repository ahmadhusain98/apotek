<?php
function hitung($date)
{
  $day = date("d", strtotime($date));
  $month = date("m", strtotime($date));
  $year = date("Y", strtotime($date));

  $days = (int)((mktime(0, 0, 0, $month, $day, $year) - time()) / 86400);

  return $days;
}

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

function kode_kategori()
{
  $CI           = &get_instance();

  $number       = 1;
  $awal         = 'KAT';

  $lastNumber   = $CI->db->query('SELECT kode FROM m_kategori ORDER BY id DESC LIMIT 1')->row();
  if ($lastNumber) {
    $number += 1;
    $updateNumber = $awal . sprintf("%07d", $number);
  } else {
    $number = 0;
    $updateNumber = $awal . "0000001";
  }
  return $updateNumber;
}

function kode_satuan()
{
  $CI           = &get_instance();

  $number       = 1;
  $awal         = 'SAT';

  $lastNumber   = $CI->db->query('SELECT kode FROM m_satuan ORDER BY id DESC LIMIT 1')->row();
  if ($lastNumber) {
    $number += 1;
    $updateNumber = $awal . sprintf("%07d", $number);
  } else {
    $number = 0;
    $updateNumber = $awal . "0000001";
  }
  return $updateNumber;
}

function last_id($table, $get)
{
  $CI = &get_instance();

  $id = $CI->db->query('SELECT ' . $get . ' FROM ' . $table . ' ORDER BY ' . $get . ' DESC LIMIT 1')->row()->$get;

  return $id + 1;
}

function kode_barang($kategori, $satuan)
{
  $CI = &get_instance();

  $kode_unit = $CI->session->userdata("kode_unit");

  $kode_kategori = explode(" ", $kategori);
  $kode_kat = "";

  foreach ($kode_kategori as $kk) {
    $kode_kat .= mb_substr($kk, 0, 1);
  }

  $kode_satuan = explode(" ", $satuan);
  $kode_sat = "";

  foreach ($kode_satuan as $ks) {
    $kode_sat .= mb_substr($ks, 0, 1);
  }

  $number       = 1;
  $awal         = $kode_unit . "-" . strtoupper($kode_kat) . '-' . strtoupper($kode_sat);
  $limit_awal   = strlen($awal);
  $limit        = 15;
  $result_limit = $limit - $limit_awal;

  $lastNumber   = $CI->db->query('SELECT kode FROM barang WHERE kode LIKE "' . $awal . '%" ORDER BY kode DESC LIMIT 1')->row();
  if ($lastNumber) {
    $number += 1;
    $updateNumber = $awal . sprintf("%0" . $result_limit . "d", $number);
  } else {
    $number_new = '';

    for ($i = 1; $i < $result_limit; $i++) {
      $number_new .= 0;
    }

    $updateNumber = $awal . $number_new . "1";
  }

  return $updateNumber;
}
