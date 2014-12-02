<?php
/*
 * This file using for loading styles in wp-editor
 */
define('WP_USE_THEMES', false);
if (file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-blog-header.php')) {
	/** Loads the WordPress Environment and Template */
	require($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-blog-header.php');
	// http://wordpress.org/support/topic/integrating-wp-in-external-php-pages?replies=22#post-1568366
	status_header(200);
	header("Content-type: text/css");
	
//	global $firmasite_settings;  // site options
} else {
	exit;
}
	global $firmasite_plugin_settings;
?>
	@import url(<?php echo $firmasite_plugin_settings["plugin_url"] . 'bootstrap/css/bootstrap.min.css'; ?>);
	@import url(<?php echo $firmasite_plugin_settings["plugin_url"] . 'custom.css'; ?>);
<?php

do_action("firmasite_wpeditor_style");

