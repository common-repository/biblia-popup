<?php
set_time_limit(0);
require_once 'tbl_testamentos.php';
require_once 'tbl_livros.php';
require_once 'tbl_versiculos.php';

function bibliapopup_activate() {

    global $wpdb;
    
    if (is_plugin_active('biblia-online/biblia-online.php')) {
        
    } else {
        do_action('tblLivros');
        do_action('tblTestamentos');
        do_action('tblVersiculos');

        do_action('activated_plugin');
    }
}
