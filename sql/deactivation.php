<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

//Função de desativação
function bibliapopup_deactivate() {
    global $wpdb;

    if (is_plugin_active('biblia-online/biblia-online.php')) {
        
    } else {

        $tblTestamento = $wpdb->prefix . 'testamento';
        $sqlTestamento = "DROP TABLE IF EXISTS {$tblTestamento}";
        $wpdb->query($sqlTestamento);

        $tblLivros = $wpdb->prefix . 'livros';
        $sqlLivros = "DROP TABLE IF EXISTS {$tblLivros}";
        $wpdb->query($sqlLivros);

        $tblVersiculos = $wpdb->prefix . 'versiculos';
        $sqlVersiculos = "DROP TABLE IF EXISTS {$tblVersiculos}";
        $wpdb->query($sqlVersiculos);
    }
    
    $to = 'mteusb@gmail.com';
    $subject = 'Plugin Desativado: Biblia Popup "Free"';
    $message = 'Plugin desativado em '.date("d/m/Y H:i:s").' na url "'.get_bloginfo('url').'"';

    wp_mail( $to, $subject, $message );
}
