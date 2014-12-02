<?php
if ( ! defined( 'ABSPATH' ) )
	exit;
	
	
// Tinymce button
add_filter('mce_external_plugins', "firmasite_firmasitebutton_register");
function firmasite_firmasitebutton_register($plugin_array){
	if ( ! is_admin() ) return $plugin_array;
	global $firmasite_plugin_settings;
    $plugin_array["firmasitebutton"] = $firmasite_plugin_settings["url"] . "assets/js/firmasite-button.js";
    $plugin_array["firmasiteicons"] = $firmasite_plugin_settings["url"] . "assets/js/firmasite-icons.js";
   return $plugin_array;
} 
add_filter('mce_buttons', "firmasite_firmasitemce_buttons");
function firmasite_firmasitemce_buttons($buttons){
	if ( ! is_admin() ) return $buttons;
	array_unshift($buttons, "firmasitebutton","firmasiteicons");
	return $buttons;
} 
add_filter('tiny_mce_before_init', 'firmasite_firmasitebutton' );
function firmasite_firmasitebutton($init) {
	if ( ! is_admin() ) return $init;
	global $firmasite_settings;
	$init['body_class'] = $init['body_class'] . ' panel panel-default ' . $firmasite_settings["layout_page_class"];
	return $init;
}



add_filter('admin_init', "firmasite_plugin_editor_init");
function firmasite_plugin_editor_init() {
	global $firmasite_plugin_settings;
	wp_localize_script( 'editor', 'firmasitebutton', array(
		//'url'    => plugin_dir_url( __FILE__ ),
		'icons'  => __( 'Icons', "firmasite-theme-enhancer" ),		
		'title'  => __( 'Styles', "firmasite-theme-enhancer" ),		
		'container'  => __( 'Container', "firmasite-theme-enhancer" ),		
			// Well Box
			'well'  => __( 'Well Box', "firmasite-theme-enhancer" ),
				'well_small'  => __( 'Small Well Box', "firmasite-theme-enhancer" ),
				'well_standard'  => __( 'Standard Well Box', "firmasite-theme-enhancer" ),
				'well_large'  => __( 'Large Well Box', "firmasite-theme-enhancer" ),
			// Message Box
			'messagebox'  => __( 'Message Box', "firmasite-theme-enhancer" ),
				'messagebox_alert'  => __( 'Alert Box', "firmasite-theme-enhancer" ),
				'messagebox_error'  => __( 'Alert Box (Danger)', "firmasite-theme-enhancer" ),
				'messagebox_success'  => __( 'Alert Box (Success)', "firmasite-theme-enhancer" ),
				'messagebox_info'  => __( 'Alert Box (Information)', "firmasite-theme-enhancer" ),
			// Modal Box
			'modal'  => __( 'Modal Box', "firmasite-theme-enhancer" ),
				'modal_header'  => __( 'Modal Box (Header)', "firmasite-theme-enhancer" ),
				'modal_body'  => __( 'Modal Box (Body)', "firmasite-theme-enhancer" ),
				'modal_footer'  => __( 'Modal Box (Footer)', "firmasite-theme-enhancer" ),
		// Text Styles
		'text'  => __( 'Text Styles', "firmasite-theme-enhancer" ),
			// Text Color
			'textcolor'  => __( 'Text Color', "firmasite-theme-enhancer" ),
				'text_muted'  => __( 'Muted', "firmasite-theme-enhancer" ),
				'text_alert'  => __( 'Alert', "firmasite-theme-enhancer" ),
				'text_error'  => __( 'Danger', "firmasite-theme-enhancer" ),
				'text_success'  => __( 'Success', "firmasite-theme-enhancer" ),
				'text_info'  => __( 'Information', "firmasite-theme-enhancer" ),
			// Label
			'label'  => __( 'Label', "firmasite-theme-enhancer" ),
				'label_standard'  => __( 'Label', "firmasite-theme-enhancer" ),
				'label_warning'  => __( 'Label (Warning)', "firmasite-theme-enhancer" ),
				'label_important'  => __( 'Label (Important)', "firmasite-theme-enhancer" ),
				'label_success'  => __( 'Label (Success)', "firmasite-theme-enhancer" ),
				'label_info'  => __( 'Label (Info)', "firmasite-theme-enhancer" ),
				'label_primary'  => __( 'Label (Primary)', "firmasite-theme-enhancer" ),
			// Badge
			'badge'  => __( 'Badge', "firmasite-theme-enhancer" ),
				'badge_standard'  => __( 'Badge', "firmasite-theme-enhancer" ),
				'badge_warning'  => __( 'Badge (Warning)', "firmasite-theme-enhancer" ),
				'badge_important'  => __( 'Badge (Important)', "firmasite-theme-enhancer" ),
				'badge_success'  => __( 'Badge (Success)', "firmasite-theme-enhancer" ),
				'badge_info'  => __( 'Badge (Info)', "firmasite-theme-enhancer" ),
				'badge_primary'  => __( 'Badge (Primary)', "firmasite-theme-enhancer" ),
		// Button
		'button'  => __( 'Link to Button', "firmasite-theme-enhancer" ),
			// Button Color
			'buttoncolor'  => __( 'Button Color', "firmasite-theme-enhancer" ),
				'button_standard'  => __( 'Standard', "firmasite-theme-enhancer" ),
				'button_primary'  => __( 'Primary', "firmasite-theme-enhancer" ),
				'button_alert'  => __( 'Alert', "firmasite-theme-enhancer" ),
				'button_error'  => __( 'Danger', "firmasite-theme-enhancer" ),
				'button_success'  => __( 'Success', "firmasite-theme-enhancer" ),
				'button_info'  => __( 'Information', "firmasite-theme-enhancer" ),
				'button_primary'  => __( 'Primary', "firmasite-theme-enhancer" ),
			// Button Size
			'buttonsize'  => __( 'Button Size', "firmasite-theme-enhancer" ),
					'button_block'  => __( 'Block', "firmasite-theme-enhancer" ),
					'button_large'  => __( 'Large', "firmasite-theme-enhancer" ),
					'button_standard'  => __( 'Standard', "firmasite-theme-enhancer" ),
					'button_small'  => __( 'Small', "firmasite-theme-enhancer" ),
					'button_mini'  => __( 'Mini', "firmasite-theme-enhancer" ),
	
	) );
	wp_localize_script( 'editor', 'firmasiteicons', array(
		'wp_includes_url'    => WPINC,
		'title'  => __( 'Icons', "firmasite-theme-enhancer" ),		
	
	) );
}
