<?php
function _get_datatables_query($table, $column_order, $column_search, $order, $kondisi, $kondisi2, $kondisi3, $kondisi4)
{
    $CI           = &get_instance();

    $CI->db->select($column_order);
    $CI->db->from($table);
    if ($kondisi == 'user_pengelola') {
        $CI->db->where('kode_role <> ', 'R0005');
        $CI->db->order_by('username', 'ASC');
    } else if ($kondisi == 'user_member') {
        $CI->db->where('kode_role', 'R0005');
        $CI->db->order_by('username', 'ASC');
    } else if (($kondisi == 'modul') || ($kondisi == 'menu') || ($kondisi == 'submenu')) {
        $CI->db->order_by('nama', 'ASC');
    } else if ($kondisi == 'For_barang') {
        $CI->db->join('harga_unit', $table . '.kode = harga_unit.kode_barang', 'INNER');
        $CI->db->join('m_kategori', 'm_kategori.kode = ' . $table . '.kategori', 'INNER');
        $CI->db->join('m_satuan', 'm_satuan.kode = ' . $table . '.satuan', 'INNER');
        $CI->db->where('harga_unit.kode_unit', $kondisi2);
        if ($kondisi3 != '') {
            $CI->db->where('barang.kategori', $kondisi3);
        }
        if ($kondisi4 != '') {
            $CI->db->where('barang.satuan', $kondisi4);
        }
    }
    $i = 0;
    foreach ($column_search as $item) {
        if ($_POST['search']['value']) {
            if ($i === 0) {
                $CI->db->group_start();
                $CI->db->like($item, $_POST['search']['value']);
            } else {
                $CI->db->or_like($item, $_POST['search']['value']);
            }
            if (count($column_search) - 1 == $i)
                $CI->db->group_end();
        }
        $i++;
    }
    if (isset($_POST['order'])) {
        $CI->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($order)) {
        $order = $order;
        $CI->db->order_by(key($order), $order[key($order)]);
    }
}

function get_datatables($table, $column_order, $column_search, $order, $kondisi, $kondisi2 = '', $kondisi3 = '', $kondisi4 = '')
{
    $CI           = &get_instance();

    _get_datatables_query($table, $column_order, $column_search, $order, $kondisi, $kondisi2, $kondisi3, $kondisi4);
    if ($_POST['length'] != -1)
        $CI->db->limit($_POST['length'], $CI->input->post('start'));
    $query = $CI->db->get();
    return $query->result();
}

function count_filtered($table, $column_order, $column_search, $order, $kondisi, $kondisi2 = '', $kondisi3 = '', $kondisi4 = '')
{
    $CI           = &get_instance();

    _get_datatables_query($table, $column_order, $column_search, $order, $kondisi, $kondisi2, $kondisi3, $kondisi4);
    $query = $CI->db->get();
    return $query->num_rows();
}

function count_all($table, $column_order, $column_search, $order, $kondisi, $kondisi2 = '', $kondisi3 = '', $kondisi4 = '')
{
    $CI           = &get_instance();

    $CI->db->select($column_order);
    $CI->db->from($table);
    if ($kondisi == 'user_pengelola') {
        $CI->db->where('kode_role <> ', 'R0005');
        $CI->db->order_by('username', 'ASC');
    } else if ($kondisi == 'user_member') {
        $CI->db->where('kode_role', 'R0005');
        $CI->db->order_by('username', 'ASC');
    } else if (($kondisi == 'modul') || ($kondisi == 'menu') || ($kondisi == 'submenu')) {
        $CI->db->order_by('nama', 'ASC');
    } else if ($kondisi == 'For_barang') {
        $CI->db->join('harga_unit', $table . '.kode = harga_unit.kode_barang', 'INNER');
        $CI->db->join('m_kategori', 'm_kategori.kode = ' . $table . '.kategori', 'INNER');
        $CI->db->join('m_satuan', 'm_satuan.kode = ' . $table . '.satuan', 'INNER');
        $CI->db->where('harga_unit.kode_unit', $kondisi2);
        if ($kondisi3 != '') {
            $CI->db->where('barang.kategori', $kondisi3);
        }
        if ($kondisi4 != '') {
            $CI->db->where('barang.satuan', $kondisi4);
        }
    }
    return $CI->db->count_all_results();
}
