<?php
/**
 *
 * Author    : Fauzan Falah ( Anang )
 * File      : sqlquery_helper.php
 * Version   : v1.0.0
 * Ket       : Berisi tentang fungsi-fungsi sql query manual
 *
 *
 */
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('sql_transaksi')) {
    function sql_transaksi()
    {
        return "SELECT DISTINCT `pinjam_id`, `anggota_id`, `status`, `tgl_pinjam`, `lama_pinjam`, `tgl_balik`, `tgl_kembali` FROM tbl_pinjam";
    }
}

if (!function_exists('unset_cart')) {
    function unset_cart()
    {
        $ci = & get_instance();
        $ci->db->where('login_id', $ci->session->userdata('ses_id'));
        return $ci->db->delete('tbl_keranjang');
    }
}
