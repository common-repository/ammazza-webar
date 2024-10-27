<?php
/*
Plugin Name: AMMAZZA Virtual Try-On for Jewellery
Plugin URI: https://wordpress.org/ammazza-webar
Description: Add Try Now button in your website .
Version: 1.0.0
Author: WebOccult Technologies Pvt Ltd
Author URI: https://www.weboccult.com
Text Domain:    ammazza-webar
Domain Path:    /languages
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !defined( 'WEBAR_DIR' ) ) {
    define('WEBAR_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'WEBAR_URL' ) ) {
    define('WEBAR_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined('WEBAR_BASENAME') ){
    define('WEBAR_BASENAME', 'webar');  // plugin base name
}
if( !defined( 'WEBAR_ADMIN_DIR' ) ) {
    define('WEBAR_ADMIN_DIR', WEBAR_DIR . '/backend' ); // plugin admin dir
}
if( !defined( 'WEBAR_ADMIN_URL' ) ) {
    define('WEBAR_ADMIN_URL', WEBAR_URL . 'backend' ); // plugin admin url
}
if( !defined( 'WEBAR_FRONT_DIR' ) ) {
    define('WEBAR_FRONT_DIR', WEBAR_DIR . '/frontend' ); // plugin frontend dir
}
if( !defined( 'WEBAR_FRONT_URL' ) ) {
    define('WEBAR_FRONT_URL', WEBAR_URL . 'frontend' ); // plugin frontend url
}
if( !defined( 'WEBAR_META_PREFIX' ) ) {
    define( 'WEBAR_META_PREFIX', '_WEBAR_' ); // meta box prefix
}


//include custom function file for backend
include WEBAR_ADMIN_DIR . '/webar-backend-custom-functions.php';

//include custom function file for frontend
include WEBAR_FRONT_DIR . '/webar-frontend-custom-functions.php';

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 */

function webar_load_textdomain() {

  load_plugin_textdomain( 'ammazza-webar', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

}
add_action( 'init', 'webar_load_textdomain' ); 

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 */
register_activation_hook( __FILE__, 'webar_install' );

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 */
register_deactivation_hook( __FILE__, 'webar_deactivate' );

/**
 * Uninstall Hook
 *
 * Register plugin deactivation hook.
 */
register_uninstall_hook ( __FILE__, 'webar_uninstall' );

/**
 * Plugin Setup (On Activation)
 *
 * Does the initial setup,
 * stest default values for the plugin options.
 */
function webar_install() {
    
    global $webar_products;
    $webar_products = array();

    //IMP Call of Function
    //Need to call when custom post type is being used in plugin
    flush_rewrite_rules();
}

/**
 * Plugin Setup (On Deactivation)
 *
 * Delete plugin options.
 */
function webar_deactivate() {
    
    
}
/**
 * Plugin Setup (On Uninstall)
 *
 * Delete plugin options.
 */
function webar_uninstall() {
    
}
?>