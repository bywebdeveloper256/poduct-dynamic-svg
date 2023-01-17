<?php
/**
 * Plugin Name:       Dynamic Product
 * Plugin URI:        https://proyectoseis.cl
 * Description:       This plugin allows you to add variable products with dynamic attributes, it makes use of SVG images to change colors. Requires: Safe SVG, Woocommerce
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Proyecto Seis
 * Author URI:        https://proyectoseis.cl
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ps-dynamic-product
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

//Name and path of the main plugin file
if ( ! defined( 'MAIN_FILE_PATH' ) ) define( 'MAIN_FILE_PATH', __FILE__ );

//PATH to the main folder of the plugin. ends with /
if ( ! defined( 'MAIN_FOLDER_PATH' ) ) define( 'MAIN_FOLDER_PATH', plugin_dir_path( __FILE__ ) );

//URL to the Assets folder of the plugin. ends with /
if ( ! defined( 'ASSETS_FOLDER_URL' ) ) define( 'ASSETS_FOLDER_URL', plugins_url( '/assets/', __FILE__ ) );

//PATH to the inc folder of the plugin. ends with /
if ( ! defined( 'INC_FOLDER_PATH' ) ) define( 'INC_FOLDER_PATH', plugin_dir_path( __FILE__ ) . 'inc/' );

//PATH to the front folder of the plugin. ends with /
if ( ! defined( 'FRONT_FOLDER_PATH' ) ) define( 'FRONT_FOLDER_PATH', plugin_dir_path( __FILE__ ) . 'front/' );

//URL to the front folder of the plugin. ends with /
if ( ! defined( 'FRONT_FOLDER_URL' ) ) define( 'FRONT_FOLDER_URL', plugins_url( '/front/', __FILE__ ) );

//PATH to the languages folder of the plugin. ends with /
if ( ! defined( 'LANGUAGES_FOLDER_PATH' ) ) define( 'LANGUAGES_FOLDER_PATH', plugin_dir_path( __FILE__ ) . 'languages/' );

//URL to the main folder of the plugin. ends with /
if ( ! defined( 'MAIN_FOLDER_URL' ) ) define( 'MAIN_FOLDER_URL', plugins_url( '/', __FILE__ ) );

require INC_FOLDER_PATH . 'functions.php';

if ( ! function_exists( 'is_plugin_active' ) )
{
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) )
{
    add_action( 'admin_notices', function(){ 
        echo '<div class="notice notice-error"><p>';
        esc_html_e( 'To use the Dynamic Product plugin you must have WooCommerce installed and activated.', bwd_plugin_data( 'TextDomain' ) );
        echo '</p></div>';
    }, 1000 );
    
}else{
    require INC_FOLDER_PATH . 'enqueues.php';
    require INC_FOLDER_PATH . 'product-type.php';
    require INC_FOLDER_PATH . 'ajax/ajax.php';
    require INC_FOLDER_PATH . 'woo.php';
    require FRONT_FOLDER_PATH . 'inc/enqueues.php';
    require FRONT_FOLDER_PATH . 'inc/shortcodes.php';
    require FRONT_FOLDER_PATH . 'inc/ajax/ajax.php';
}
