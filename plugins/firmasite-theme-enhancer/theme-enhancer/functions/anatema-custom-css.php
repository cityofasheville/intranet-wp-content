<?php

add_action( 'after_setup_theme', "anatema_customcss_setup");
function anatema_customcss_setup(){
	add_action( 'customize_register', "anatema_customcss_register");
	function anatema_customcss_register($wp_customize) {
	
			$wp_customize->remove_setting( 'firmasite_settings[customcss]' );
			// CustomCss Option
			$wp_customize->add_setting( 'firmasite_settings[customcss]', array(
				'type'              => 'option',
				'sanitize_callback' => 'anatema_sanitize_customcss',
			) );
			/*$wp_customize->add_control( new Customize_CustomCss_Control( $wp_customize,'firmasite_settings[customcss]', array(
				'label'    => __( 'Custom Css', "firmasite-theme-enhancer" ),
				'type' => 'customcss',
				'section'  => 'theme-settings',			
				//'priority' => '3',
			) ) );	*/		

	}
}


function anatema_sanitize_customcss( $css ) {
	
	// Sadly we cant include csstidy. WordPress Theme Directory's automatic code checking system is not accepting it.
	// You have 2 option for including css checker: install jetpack and activate custom css or copy csstidy's folder to theme's functions folder from jetpack's plugin
	//if ( class_exists('safecss') ) {
		anatema_safecss_class();
		$csstidy = new csstidy();
		$csstidy->optimise = new safecss( $csstidy );
	
		$csstidy->set_cfg( 'remove_bslash',              false );
		$csstidy->set_cfg( 'compress_colors',            false );
		$csstidy->set_cfg( 'compress_font-weight',       false );
		$csstidy->set_cfg( 'optimise_shorthands',        0 );
		$csstidy->set_cfg( 'remove_last_;',              false );
		$csstidy->set_cfg( 'case_properties',            false );
		$csstidy->set_cfg( 'discard_invalid_properties', true );
		$csstidy->set_cfg( 'css_level',                  'CSS3.0' );
		$csstidy->set_cfg( 'preserve_css',               true );
		$csstidy->set_cfg( 'template',                   dirname( __FILE__ ) . '/csstidy/wordpress-standard.tpl' );
	
		$css = stripslashes( $css );
		
		// Some people put weird stuff in their CSS, KSES tends to be greedy
		$css = str_replace( '<=', '&lt;=', $css );
		// Why KSES instead of strip_tags?  Who knows?
		$css = wp_kses_split( $prev = $css, array(), array() );
		$css = str_replace( '&gt;', '>', $css ); // kses replaces lone '>' with &gt;
		// Why both KSES and strip_tags?  Because we just added some '>'.
		$css = strip_tags( $css );
	
		$csstidy->parse( $css );
	
	
		$safe_css = $csstidy->print->plain();	
	/*} else {
		$safe_css = $css;
	}*/
	
	return $safe_css;
}

function anatema_safecss_class() {
	// Wrapped so we don't need the parent class just to load the plugin
	if ( class_exists('safecss') )
		return;

	require_once( dirname( __FILE__ ) . '/csstidy/class.csstidy.php' );

	class safecss extends csstidy_optimise {
		function safecss( &$css ) {
			return $this->csstidy_optimise( $css );
		}

		function postparse() {
			do_action( 'csstidy_optimize_postparse', $this );

			return parent::postparse();
		}

		function subvalue() {
			do_action( 'csstidy_optimize_subvalue', $this );

			return parent::subvalue();
		}
	}
}