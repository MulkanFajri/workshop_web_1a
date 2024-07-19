<?php
/**
 *
 * Author    : Fauzan Falah ( Anang )
 * File      : alert_helper.php
 * Version   : v1.0.0
 * Ket       : Berisi tentang fungsi-fungsi alert alert yg digunakan
 *
 *
 */
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('alert_bs')) {
    function alert_bs()
    {
        $CI = & get_instance();
        if ($CI->session->flashdata('success')) {
            $alert = '<div id="notifikasi">
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							'.$CI->session->flashdata('success').'
						</div></div>';
            return $alert;
        }
        if ($CI->session->flashdata('failed')) {
            $alert = '<div id="notifikasi"><div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						'.$CI->session->flashdata('failed').'
					</div></div>';
            return $alert;
        }
    }
}

function base64_encode_image($filename=string, $filetype=string)
{
    if ($filename) {
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}
