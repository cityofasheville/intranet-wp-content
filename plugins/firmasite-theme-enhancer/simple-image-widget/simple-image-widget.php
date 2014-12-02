<?php
/**
 * Simple Image Widget
 *
 * @package   SimpleImageWidget
 * @author    Brady Vercher
 * @copyright Copyright (c) 2014, Blazer Six, Inc.
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 */

/**
 * Main plugin instance.
 *
 * @since 4.0.0
 * @type FirmaSite_Simple_Image_Widget $FirmaSite_Simple_Image_Widget
 */
global $FirmaSite_Simple_Image_Widget;

if ( ! defined( 'SIW_DIR' ) ) {
	/**
	 * Plugin directory path.
	 *
	 * @since 4.0.0
	 * @type string SIW_DIR
	 */
	define( 'SIW_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Check if the installed version of WordPress supports the new media manager.
 *
 * @since 3.0.0
 */
function is_FirmaSite_Simple_Image_Widget_legacy() {
	/**
	 * Whether the installed version of WordPress supports the new media manager.
	 *
	 * @since 4.0.0
	 *
	 * @param bool $is_legacy
	 */
	return apply_filters( 'is_FirmaSite_Simple_Image_Widget_legacy', version_compare( get_bloginfo( 'version' ), '3.4.2', '<=' ) );
}

/**
 * Include functions and libraries.
 */
require_once( SIW_DIR . 'includes/class-simple-image-widget.php' );
require_once( SIW_DIR . 'includes/class-simple-image-widget-legacy.php' );
require_once( SIW_DIR . 'includes/class-simple-image-widget-plugin.php' );
require_once( SIW_DIR . 'includes/class-simple-image-widget-template-loader.php' );

/**
 * Deprecated main plugin class.
 *
 * @since      3.0.0
 * @deprecated 4.0.0
 */
class FirmaSite_Simple_Image_Widget_Loader extends FirmaSite_Simple_Image_Widget_Plugin {}

// Initialize and load the plugin.
$FirmaSite_Simple_Image_Widget = new FirmaSite_Simple_Image_Widget_Plugin();
add_action( 'plugins_loaded', array( $FirmaSite_Simple_Image_Widget, 'load' ) );
