<?php
/*
Plugin Name: Tinychat
Plugin URI: 
Description: Add tinychat to your wordpress blogg / site
Version: 1.0.1
Author: Tinychat
Author URI: tinychat
*/

define('COMPARE_VERSION', '1.0.0');

require_once('tinychat-functions.php');
require_once('tinychat-admin.php');
require_once('tinychat-widget.php');

register_activation_hook(__FILE__, 'tinychat_install');

function tinychat_install() {
	global $wpdb, $wp_version;
	//We add an page for displaying tinychat
	$post_date = date("Y-m-d H:i:s");
	$post_date_gmt = gmdate("Y-m-d H:i:s");
	$sql = "SELECT * FROM ".$wpdb->posts." WHERE post_content LIKE '%[tinychat_page]%' AND `post_type` NOT IN('revision') LIMIT 1";
	$page = $wpdb->get_row($sql, ARRAY_A);
	if($page == NULL) {
		$sql ="INSERT INTO ".$wpdb->posts."(
			post_author, post_date, post_date_gmt, post_content, post_content_filtered, post_title, post_excerpt,  post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_parent, menu_order, post_type)
			VALUES
			('1', '$post_date', '$post_date_gmt', '[tinychat_page]', '', 'Video chat room', '', 'publish', 'closed', 'closed', '', 'Video chat room', '', '', '$post_date', '$post_date_gmt', '0', '0', 'page')";
		$wpdb->query($sql);
		$post_id = $wpdb->insert_id;
		$wpdb->query("UPDATE $wpdb->posts SET guid = '" . get_permalink($post_id) . "' WHERE ID = '$post_id'");
	} else {
		$post_id = $page['ID'];
	}
	
	update_option('tinychat_chat_url', get_permalink($post_id));
}

add_filter('the_content', 'wp_show_tinychat_page', 12);
function wp_show_tinychat_page($content = '') {
	if(preg_match("/\[tinychat_page\]/",$content)) {
		wp_show_tinychat();
		return "";
	}
	
	return $content;
}

function wp_show_tinychat() {
	$current_user = wp_get_current_user();
	
	if(!get_option('tinychat_chat_enabled', 0)) {
		return;
	}
	
	if($current_user->ID == 0 && !get_option('tinychat_allow_guests', 0)) {
		_e("Your not logged in, please login before trying to chat", 'widget-tinychat' );
		return;
	}
	
	$room = 'chat';
	$parameters = array(
		'room' 		=> 'chat',
		'key'		=> get_option('tinychat_api_key'),
		'nick'		=> $current_user->ID != 0 ? urlencode(html_entity_decode($current_user->display_name)) : '',
		'join'		=> 'auto',
		'change'	=> 'none',
		'api' 		=> 'list',
		'colorbk'	=> get_option('tinychat_background_color'),
	);
	
	if(get_option('tinychat_restricted_broadcast') == '1') {
		$parameters['bcast'] = 'restrict';
	}

	if($current_user->ID != 0) {
		$roles = array_keys($current_user->{$current_user->cap_key});
		$role = array_pop($roles);
	}
	
	if($current_user->ID != 0 && in_array($role, explode(',', get_option('tinychat_mod_groups')))) {
		$parameters['autoop'] = md5( $room . ':' . $_SERVER['REMOTE_ADDR'] . ':' . get_option('tinychat_api_secret') );
	} else {
		$parameters['oper']	= 'none';
		$parameters['owner'] = 'none';
	}
	
	$parameters['room'] = $room;
	
	foreach ( $parameters as $k => $v ) {
		$parameterString .= "{$k}: '{$v}', ";
	}
	
	$parameters = substr( $parameterString, 0, -2 );
	
	?>
	<script type="text/javascript">
	var tinychat = {<?php echo $parameters; ?>};
	</script>
	<script src='http://tinychat.com/js/embed.js'></script>
	<div id='client'></div>
	<?php
}
?>
