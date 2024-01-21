<?php
function _get_datatables_query($table, $column_order, $column_search, $order, $kondisi)
{
    $CI           = &get_instance();

    $CI->db->select($column_order);
    $CI->db->from($table);
    if ($kondisi == 'user_pengelola') {
        $CI->db->where('kode_role', 'R0001');
        $CI->db->order_by('username', 'ASC');
    } else if ($kondisi == 'user_member') {
        $CI->db->where('kode_role <> ', 'R0001');
        $CI->db->order_by('username', 'ASC');
    } else if (($kondisi == 'modul') || ($kondisi == 'menu') || ($kondisi == 'submenu')) {
        $CI->db->order_by('nama', 'ASC');
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

function get_datatables($table, $column_order, $column_search, $order, $kondisi)
{
    $CI           = &get_instance();

    _get_datatables_query($table, $column_order, $column_search, $order, $kondisi);
    if ($_POST['length'] != -1)
        $CI->db->limit($_POST['length'], $CI->input->post('start'));
    $query = $CI->db->get();
    return $query->result();
}

function count_filtered($table, $column_order, $column_search, $order, $kondisi)
{
    $CI           = &get_instance();

    _get_datatables_query($table, $column_order, $column_search, $order, $kondisi);
    $query = $CI->db->get();
    return $query->num_rows();
}

function count_all($table, $column_order, $column_search, $order, $kondisi)
{
    $CI           = &get_instance();

    $CI->db->select($column_order);
    $CI->db->from($table);
    if ($kondisi == 'user_pengelola') {
        $CI->db->where('kode_role', 'R0001');
        $CI->db->order_by('username', 'ASC');
    } else if (($kondisi == 'modul') || ($kondisi == 'menu') || ($kondisi == 'submenu')) {
        $CI->db->order_by('nama', 'ASC');
    }
    return $CI->db->count_all_results();
}
