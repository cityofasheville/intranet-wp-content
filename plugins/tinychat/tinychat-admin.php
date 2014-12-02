<?php
// Hook for adding admin menus
add_action('admin_menu', 'tinychat_add_pages');
add_action('admin_head', 'tinychat_admin_css');
// action function for above hook
function tinychat_add_pages() {
    // Add a new top-level menu:
    add_menu_page(__('Settings','menu-tinychat'), __('Tinychat','menu-tinychat'), 'manage_options', 'tinychat-settings-page', 'tinychat_settings_page' );
    add_submenu_page('tinychat-settings-page', __('List users','menu-tinychat'), __('List users','menu-tinychat'), 'manage_options', 'tinychat-listusers-page', 'tinychat_listusers_page');
}

function tinychat_admin_css() {
	?>
	<style type="text/css">
		#mod_groups {
			height: auto;
		}
	</style>
	<?php	
}

function tinychat_settings_page() {
	//must check that the user has the required capability 
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	$opt_val = get_option( $opt_name );
	
	if( isset($_POST['form-submit']) && $_POST['form-submit'] == '1' ) {
		$opt_val = $_POST['chat_enabled'];
		update_option('tinychat_chat_enabled', $opt_val);
		
		$opt_val = $_POST['chat_url'];
		update_option('tinychat_chat_url', $opt_val);
		
		$opt_val = $_POST['api_key'];
		update_option('tinychat_api_key', $opt_val);
		
		$opt_val = $_POST['api_secret'];
		update_option('tinychat_api_secret', $opt_val);
		
		$opt_val = $_POST['background_color'];
		update_option('tinychat_background_color', $opt_val);
		
		if(isset($_POST['restricted_broadcast']) && $_POST['restricted_broadcast'] == '1')
			update_option('tinychat_restricted_broadcast', 1);
		else
			update_option('tinychat_restricted_broadcast', 0);
			
		if(isset($_POST['allow_guests']) && $_POST['allow_guests'] == '1')
			update_option('tinychat_allow_guests', 1);
		else
			update_option('tinychat_allow_guests', 0);
			
		if(isset($_POST['mod_groups']) && is_array($_POST['mod_groups'])) {
			$opt_val = implode(',', $_POST['mod_groups']);
			update_option('tinychat_mod_groups', $opt_val);
		}
		?>
		<div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
		<?php
    }
    
    $chat_enabled = get_option('tinychat_chat_enabled') != false ? (get_option('tinychat_chat_enabled') == '1' ? true : false) : false;
    $chat_url = get_option('tinychat_chat_url') != false  ? get_option('tinychat_chat_url') : '';
	$api_key = get_option('tinychat_api_key') != false  ? get_option('tinychat_api_key') : '';
    $api_secret = get_option('tinychat_api_secret') != false  ? get_option('tinychat_api_secret') : '';
    $background_color = get_option('tinychat_background_color') != false  ? get_option('tinychat_background_color') : '';
    $restricted_broadcast = get_option('tinychat_restricted_broadcast') != false  ? (get_option('tinychat_restricted_broadcast') == '1' ? true : false) : false;
    $mod_groups = get_option('tinychat_mod_groups') != false  ? explode(',', get_option('tinychat_mod_groups')) : array();
    
    ?>
	<div class="wrap">
	<h2><?php echo __( 'Tinychat Settings', 'menu-tinychat' ); ?></h2>
    
	<form name="form1" method="post" action="">
		<input type="hidden" name="form-submit" value="1"/>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e("Chat Enabled:", 'menu-tinychat' ); ?></th>
				<td>
					<fieldset>
						<label for="chat_enabled">
							<input name="chat_enabled" type="checkbox" id="chat_enabled" value="1" <?php echo $chat_enabled ? 'checked="checked"' : ''?> />
							<?php _e("Enabled", 'menu-tinychat' ); ?>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="chat_url"><?php _e("Chat url:", 'menu-tinychat' ); ?></label></th>
				<td><input type="text" class="regular-text" value="<?php echo $chat_url?>" id="chat_url" name="chat_url"></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="api_key"><?php _e("Api Key:", 'menu-tinychat' ); ?></label></th>
				<td><input type="text" class="regular-text" value="<?php echo $api_key?>" id="api_key" name="api_key"></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="api_secret"><?php _e("Api Secret:", 'menu-tinychat' ); ?></label></th>
				<td><input type="text" class="regular-text" value="<?php echo $api_secret?>" id="api_secret" name="api_secret"></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="background_color"><?php _e("Background Color:", 'menu-tinychat' ); ?></label></th>
				<td><input type="text" class="regular-text" value="<?php echo $background_color?>" id="background_color" name="background_color"></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e("Allow guests:", 'menu-tinychat' ); ?></th>
				<td>
					<fieldset>
						<label for="allow_guests">
							<input name="allow_guests" type="checkbox" id="allow_guests" value="1" <?php echo $allow_guests ? 'checked="checked"' : ''?> />
							<?php _e("Allow", 'menu-tinychat' ); ?>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e("Restrict Broadcast:", 'menu-tinychat' ); ?></th>
				<td>
					<fieldset>
						<label for="restricted_broadcast">
							<input name="restricted_broadcast" type="checkbox" id="restricted_broadcast" value="1" <?php echo $restricted_broadcast ? 'checked="checked"' : ''?> />
							<?php _e("Restrict", 'menu-tinychat' ); ?>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e("Moderator Roles:", 'menu-tinychat' ); ?></th>
				<td>
					<select multiple="multiple" name="mod_groups[]" id="mod_groups" style="height: auto;">
						<?php tinychat_roles_options($mod_groups); ?>
					</select>
				</td>
			</tr>
		</table>
		
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
		</p>
	</form>
	</div>

	<?php
}

function tinychat_roles_options($selected = array()) {
	$r = '';
	$editable_roles = get_editable_roles();
	foreach($editable_roles as $role => $details ) {
		$name = translate_user_role($details['name'] );
		$r .= "\n\t<option value='" . esc_attr($role) . "'";
		if ( in_array($role,$selected) )
			$r .= " selected='selected'";
		$r .= ">$name</option>";
			
	}
	echo $r;
}

// mt_tools_page() displays the page content for the Test Tools submenu
function tinychat_listusers_page() {
    $users = array();
	if(get_option('tinychat_chat_enabled') == '1')
    	$users = tinychat_get_user_list();
		
	if($users == FALSE)
		$users = array();
	?>

    <div class="wrap">
		<h2><?php echo __( 'Tinychat list users', 'menu-tinychat' ); ?></h2>
		<table width='100%' border='0' cellspacing='0' cellpadding='0' class='widefat fixed'>
			<thead>
				<tr>
					<th class='manage-column' style='width: 25%'><?php _e("Nickname", 'menu-tinychat' ); ?></th>
					<th class='manage-column' style='width: 25%'><?php _e("IP Address", 'menu-tinychat' ); ?></th>
					<th class='manage-column' style='width: 25%'><?php _e("Broadcasting", 'menu-tinychat' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($users['users'] as $user) { ?>
				<tr>
					<td style='width: 25%'>
						<?php echo $user['name']; ?>
					</td>
					<td style='width: 25%'>
						<?php echo $user['ip']; ?>
					</td>
					<td style='width: 25%'>
						<?php echo $user['broadcasting'] == '0' ? '' : __( 'Broadcasting', 'menu-tinychat' ); ?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
    <?php 
}

?>
