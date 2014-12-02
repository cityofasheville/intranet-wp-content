<?php
/*
 * This file using for loading styles in wp-editor
 */
define('WP_USE_THEMES', false);
if (file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-blog-header.php')) {
	/** Loads the WordPress Environment and Template */
	require($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-blog-header.php');
} else {
		//Climb dirs till we find wp-blog-header (Varies depending on wordpress install)
        while (! file_exists('wp-blog-header.php') )
        chdir('..'); 
 
   	 	/** Loads the WordPress Environment and Template */
        require ("wp-blog-header.php");
}
	// Exit if accessed directly without wp-blog-header.php
	if ( !defined( 'ABSPATH' ) ) exit;

	// http://wordpress.org/support/topic/integrating-wp-in-external-php-pages?replies=22#post-1568366
	status_header(200);
	
	global $firmasite_settings, $firmasite_plugin_settings;  // site options
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
    <?php if ( defined('FIRMASITE_POWEREDBY') ) { ?>
	    <link type="text/css" rel="stylesheet" href="<?php echo $firmasite_settings["styles_url"][$firmasite_settings["style"]] . '/bootstrap.min.css'; ?>">
		<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri() . '/style.css'; ?>">
    <?php } else { ?>
	    <link type="text/css" rel="stylesheet" href="<?php echo $firmasite_plugin_settings["plugin_url"] . 'bootstrap/css/bootstrap.min.css'; ?>">    
	    <link type="text/css" rel="stylesheet" href="<?php echo $firmasite_plugin_settings["plugin_url"] . 'custom.css'; ?>">    
    <?php } ?>
 	
    <link type="text/css" rel="stylesheet" href="<?php echo $firmasite_plugin_settings["font_url"] . $firmasite_plugin_settings["font_id"] . '.css'; ?>">  
    <style>
	body#iconscharmap { overflow:hidden; height: 240px; }
	#iconscharmapgroup { overflow-y:scroll; height: 240px; }
	#iconscharmapView td { font-size:20px; }
	#iconscharmap #iconBig { font-size: 100px; display:table-cell;}
	#iconscharmap #iconCode {
		display: inline-block;
		margin: 10px 0 10px 0;
		padding: 0;
		line-height: 100%;
		}
	a:link, a:visited {
	color: inherit !important;
	}	
	</style>  
	<script type="text/javascript" src="<?php echo includes_url("js/tinymce/tiny_mce_popup.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo $firmasite_plugin_settings["font_js_url"]; ?>"></script>
	<?php do_action("firmasite_icons_charmap"); ?>
	<script type="text/javascript" src="firmasite-icons-iconscharmap.js"></script>
</head>
<body id="iconscharmap" style="display:none" role="application">
<table align="center" border="0" cellspacing="0" cellpadding="2" role="presentation">
	<tr>
		<td id="iconscharmapView" rowspan="2" align="left" valign="top">
			<!-- Chars will be rendered here -->
		</td>
		<td width="100" align="center" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100" role="presentation">
				<tr>
                	<td colspan="2">
                    	<div id="iconBig">&nbsp;</div>
                        <h3 id="iconCode" class="text-info">&nbsp;</h3>
                    </td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
</body>
</html>
