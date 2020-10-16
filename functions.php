<?php
/**
 * Plugin Name: WP Netlify Webhook
 * Plugin URI: https://github.com/jimmy121192/wp-netlify-webhook
 * Description: Allows you to trigger automatically a Netlify build
 * Version: 1.0
 * Author: Jimmy
 * Author URI: https://jimmytruong.ca
 */

 /***************************************************************************************
 * Constants
 **************************************************************************************/
define( 'NWH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'NWH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


/***************************************************************************************
 * Enqueue Style
 **************************************************************************************/
add_action('admin_enqueue_scripts', 'nwh_style');
function nwh_style() {
    wp_register_style('nwh_style', plugins_url('style.css',__FILE__ ));
    wp_enqueue_style('nwh_style');
}

/***************************************************************************************
 * Include files
 **************************************************************************************/
require_once( NWH_PLUGIN_DIR . '/core/register.php' );
require_once( NWH_PLUGIN_DIR . '/core/hook.php' );