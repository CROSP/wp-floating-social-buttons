<?php
/*
Plugin Name: Floating social share buttons
Plugin URI: http://crosp.net/
Description: It is plugin that can be used to display social share buttons on your site. You can customize predefined settings and add custom social share buttons.
Author: Alexander Molochko
Author URI: http://crosp.net/about
Version: 1.0
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'FSSB_VERSION', '1.0' );
define( 'FSSB_DOMAIN','fcsb_domain');
define( 'FSSB_UNIQUE_ID','floating_social_buttons');
define( 'FSSB_SETTINGS_PAGE_URL','settings_page_floating_social_buttons');
define( 'FSSB_NAME','Floating Social Share Buttons');
define( 'FSSB_PLUGIN_FILE_URL' ,plugin_basename(__FILE__));
define( 'FSSB_PLUGIN_DIR' , WP_PLUGIN_URL . '/floating-social-share-buttons');
if ( is_admin()) {
    function fssb_handle_plugin_activation() {

    }
    function fssb_handle_plugin_deactivation() { 

    }
    register_activation_hook( __FILE__, 'fssb_handle_plugin_activation');
    register_deactivation_hook( __FILE__, 'fssb_handle_plugin_deactivation');
    require_once(dirname( __FILE__ ) . '/include/core/class-floating-share-buttons-admin.php');
    $floating_buttons_plugin = Floating_Share_Buttons_Admin::get_instance();
    $floating_buttons_plugin->init();
}
