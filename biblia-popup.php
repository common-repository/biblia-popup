<?php
/*
Plugin Name: Bíblia Popup
Plugin URI: ovangelho.com
Description: B&iacute;blia Popup converte automaticamente refer&ecirc;ncias b&iacute;blicas em seu site em links para que seus leitores possam l&ecirc;-las simplesmente passando o mouse (desktop) ou clicando (mobile) melhorando assim o engajamento com seu p&uacute;blico.
Version: 1.0
Author: OEvangelho
Author URI: OEvangelho.com
Author email: mteusb@gmail.com 
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once("biblia-popup-functions.php");

register_activation_hook( __FILE__, 'bibliapopup_activate' );
register_deactivation_hook( __FILE__, 'bibliapopup_deactivate' );

function bibliapopup_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {        
        exit( wp_redirect( admin_url( 'admin.php?page=bibliapopup' ) ) );
    }
}
add_action( 'activated_plugin', 'bibliapopup_activation_redirect' );