<?php
/**
 * Plugin Name: Website Webkit
 * Plugin URI: https://wesite-webkit.com/
 * Description: A Website Webkit plugin that helps you manage anything. Beautifully.
 * Version: 1.0.0
 * Author: Bhuwan Ojha
 * Author URI: https://bhuwanojha.com.np
 * Text Domain: website-webkit
 * @package Website Webkit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}



// Define MWW_PLUGIN_FILE.
if ( ! defined( 'MWW_PLUGIN_FILE' ) ) {
    define( 'MWW_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'MWW_PLUGIN_PATH' ) ) {
    define( 'MWW_PLUGIN_PATH', plugin_dir_path( __FILE__));
}

if ( ! defined( 'MWW_PLUGIN_NAME' ) ) {
    define( 'MWW_PLUGIN_NAME', 'Website Webkit');
}

// Include the main Website Webkit class.
if ( ! class_exists( 'Website_Webkit' ) ) {
    include_once dirname( __FILE__ ) . '/includes/class-website-webkit.php';
}

/**
 * Main instance of Website Webkit.
 *
 * Returns the main instance of MWW to prevent the need to use globals.
 *
 * @since  2.1
 * @return Website Webkit
 */
function mww() {
    return Website_Webkit::instance();
}

// Global for backwards compatibility.
$GLOBALS['website-webkit'] = mww();
