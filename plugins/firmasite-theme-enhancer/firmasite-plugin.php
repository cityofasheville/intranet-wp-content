<?php
/*
Plugin Name: FirmaSite Theme Enhancer
Plugin URI: http://firmasite.com
Description: This plugin provides new features to themes. Twitter Bootstrap design elements, custom editor buttons and more..
Version: 1.3.1
Author: Ünsal Korkmaz
Author URI: http://unsalkorkmaz.com
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl.txt
Text Domain:   firmasite-theme-enhancer
Domain Path:   /languages/
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// You can translate Plugin Name with this
__("FirmaSite Theme Enhancer", "firmasite-theme-enhancer");
// You can translate description with this
__("This plugin provides new features to themes. Twitter Bootstrap design elements, custom editor buttons and more..", "firmasite-theme-enhancer");

add_action('after_setup_theme', "firmasite_plugin_setup", 99);
function firmasite_plugin_setup() {
	
	/* 
	 * Settings init 
	 */
	global $firmasite_plugin_settings, $firmasite_settings;

	if (!isset($firmasite_plugin_settings["plugin_url"])) $firmasite_plugin_settings["plugin_url"] = plugin_dir_url( __FILE__ );
	if (!isset($firmasite_plugin_settings["plugin_dir"])) $firmasite_plugin_settings["plugin_dir"] = plugin_dir_path( __FILE__ );
	
	if (!isset($firmasite_plugin_settings["url"])) $firmasite_plugin_settings["url"] = $firmasite_plugin_settings["plugin_url"] . 'theme-enhancer/';
	if (!isset($firmasite_plugin_settings["dir"])) $firmasite_plugin_settings["dir"] = $firmasite_plugin_settings["plugin_dir"] . 'theme-enhancer/';
	
	if (!isset($firmasite_plugin_settings["font_url"])) $firmasite_plugin_settings["font_url"] = $firmasite_plugin_settings["plugin_url"] . 'font-awesome/';
	if (!isset($firmasite_plugin_settings["font_dir"])) $firmasite_plugin_settings["font_dir"] = $firmasite_plugin_settings["plugin_dir"] . 'font-awesome/';
	if (!isset($firmasite_plugin_settings["font_js_url"])) $firmasite_plugin_settings["font_js_url"] = $firmasite_plugin_settings["font_url"] . 'fontawesome-webfont.js';
	if (!isset($firmasite_plugin_settings["font_css_url"])) $firmasite_plugin_settings["font_css_url"] = $firmasite_plugin_settings["font_url"] . 'fontawesome-webfont.css';
	if (!isset($firmasite_plugin_settings["font_name"])) $firmasite_plugin_settings["font_name"] = 'FontAwesome';
	if (!isset($firmasite_plugin_settings["font_id"])) $firmasite_plugin_settings["font_id"] = 'fontawesome-webfont';

	
	/*
	 * FIRMASITE_CDN MODE
	 */
	if ( defined('FIRMASITE_CDN') && FIRMASITE_CDN && defined('FIRMASITE_POWEREDBY') ) {
		// Font awesome
		$firmasite_plugin_settings["font_css_url"] = "//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css?ver=3.6";
			
		// We dont want thumbnails to show from cdn
		$firmasite_settings["thumbnail_url"] = $firmasite_settings["styles_url"];
		
		// bootstrapcdn.com
		$firmasite_settings["styles_url"] = apply_filters( 'firmasite_theme_styles_url', array(		
			"amelia" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/amelia",		
			"cerulean" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/cerulean",	
			"cosmo" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/cosmo",			
			"cyborg" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/cyborg",		
			"darkly" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/darkly",		
			"default" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/default",		
			"flatly" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/flatly",		
			"journal" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/journal",		
			"lumen" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/lumen",		
			"paper" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/paper",		
			"readable" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/readable",	
			"sandstone" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/sandstone",	
			"simplex" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/simplex",		
			"slate" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/slate",			
			"spacelab" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/spacelab",	
			"superhero" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/superhero",	
			"united" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/united",		
			"yeti" => "//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/yeti",		
		));
		
		//jquery
		wp_deregister_script( 'jquery-core' );
		wp_register_script( 'jquery-core', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array(), '1.11.1');
		wp_deregister_script( 'jquery-migrate' );
		wp_register_script( 'jquery-migrate', 'http://code.jquery.com/jquery-migrate-1.2.1.min.js', array(), '1.2.1');
	}	
	
	if (!current_theme_supports('firmasite-bootstrap') || !defined('FIRMASITE_POWEREDBY') ){
		add_action('wp_enqueue_scripts', "firmasite_plugin_enqueue_script" );
		function firmasite_plugin_enqueue_script() {
			global $firmasite_plugin_settings;
			// bootstrap
			wp_register_style( 'bootstrap', $firmasite_plugin_settings["plugin_url"] . 'bootstrap/css/bootstrap.min.css' );
			wp_enqueue_style( 'bootstrap' );
		}
		
		add_action("wp_head", "firmasite_plugin_custom_css");
		function firmasite_plugin_custom_css(){
		?>
		<style type="text/css">	
		/* make modals usable */
		.firmasite-modal-static{position:inherit;top:inherit;left:inherit;right:inherit;bottom:inherit;	margin:0 auto 20px;z-index:inherit;max-width:100%;width:100%;word-wrap:break-word;display:inline-block;overflow:inherit}
		.firmasite-modal-static .modal-dialog{width:100%;z-index:inherit;left:inherit;right:inherit;padding:0}
		.firmasite-modal-static .modal-footer{border-radius:6px;text-align:inherit;margin-top:0}
		.firmasite-modal-static .bbp-reply-author{text-align:center} 
		.firmasite-modal-static .modal-body{overflow-y:inherit;max-height:inherit}
		.firmasite-modal-static .modal-body.alert{margin-bottom:0}

		/* Tinymce Bootstrap Fixes for wp-admin */
		body.mceContentBody { margin:10px!important;padding:10px!important;border:none!important }
		</style>
        <?php
		}
		// Tell the TinyMCE editor to use a custom stylesheet
		add_filter( 'mce_css', 'firmasite_plugin_mce_css' );
		function firmasite_plugin_mce_css( $mce_css ) {
			global $firmasite_plugin_settings;
			if ( ! empty( $mce_css ) )
				$mce_css .= ',';
		
			$mce_css .= $firmasite_plugin_settings["plugin_url"] . 'wpeditor.php';
			$mce_css .= ',';
			$mce_css .= $firmasite_plugin_settings["font_css_url"];
		
			return $mce_css;
		}	
	}
	
	if ( defined('FIRMASITE_POWEREDBY') ) {
		include_once( $firmasite_plugin_settings["dir"] . "functions/anatema-custom-css.php");		

		// Tell the TinyMCE editor to use a custom stylesheet
		add_filter( 'mce_css', 'firmasite_plugin_mce_css_for_theme' );
		function firmasite_plugin_mce_css_for_theme( $mce_css ) {
			global $firmasite_plugin_settings;

			$mce_css = $firmasite_plugin_settings["font_css_url"]. ',' . $mce_css;
		
			return $mce_css;
		}
		
		// Register css for customizer panel
		add_action( 'customize_controls_print_styles', "firmasite_plugin_customize_controls_font" );
		function firmasite_plugin_customize_controls_font( $mce_css ) {
			global $firmasite_plugin_settings;

			wp_register_style( 'firmasite_plugin_fontcss', $firmasite_plugin_settings["font_css_url"] );
			wp_enqueue_style( 'firmasite_plugin_fontcss' );
		}

			
	}
	
	add_action('wp_enqueue_scripts', "firmasite_plugin_enqueue_fontcss", 11 );
	function firmasite_plugin_enqueue_fontcss() {
		global $firmasite_plugin_settings;
		// font-css
		wp_register_style( 'firmasite_plugin_fontcss', $firmasite_plugin_settings["font_css_url"] );
		wp_enqueue_style( 'firmasite_plugin_fontcss' );
	}
	
	require_once ($firmasite_plugin_settings["dir"] . 'functions/tinymce-buttons.php');			// Tinymce buttons
}


	


// Load translations
add_action('plugins_loaded', "firmasite_plugin_language_init",900);
function firmasite_plugin_language_init() {
	/*
	 * widget-conditions from Jetpack
	 *
	 * replaced:
	 'jetpack'
	 * to
	 "firmasite-theme-enhancer"
	 *
	 * replaced:
	 Jetpack
	 * to
	 FirmaSite
	 */	
	if ( ! class_exists( 'Jetpack' ) ) 
		include_once ('widget-visibility/widget-conditions.php');

		
	/*
	 * Simple Image Widget from https://github.com/blazersix/simple-image-widget
	 *
	 * open simple-image-widget.php
	 * remove plugin definition lines from top for prevent plugin scans like codestyling-localization
	 *
	 * remove line:
	 load_plugin_textdomain
	 *
	 * replaced:
	'simple-image-widget'
	 * to
	"firmasite-theme-enhancer"

	 * replaced:
	 Simple_Image_Widget
	 * to
	 FirmaSite_Simple_Image_Widget
	 */
	if ( !class_exists( 'Simple_Image_Widget' ) ) {
		include_once ('simple-image-widget/simple-image-widget.php');			
		add_action( 'plugins_loaded', array( $FirmaSite_Simple_Image_Widget, 'load' ), 901 );
	}
		

	global $firmasite_plugin_settings;
	load_plugin_textdomain( 'firmasite-theme-enhancer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );	
}


