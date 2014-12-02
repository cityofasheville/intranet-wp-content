<?php
add_action( 'widgets_init', 'tinychat_status_load_widgets' );
 
function tinychat_status_load_widgets() {
	register_widget( 'Tinychat_Status_Widget' );
}

class Tinychat_Status_Widget extends WP_Widget {
	function Tinychat_Status_Widget() {
		parent::WP_Widget(false, $name = 'Tinychat Status');	
	}
 
	function widget($args, $instance) {
		extract( $args );
		if(get_option('tinychat_chat_enabled') == '0')
			return;
		
    	$users = tinychat_get_user_list();
		if($users != FALSE && isset($users['users'])) {
			shuffle($users['users']);
			$users = array_slice($users['users'], 0, intval($instance['max_show']) != 0 ? intval($instance['max_show']) : 10 );
		} else {
			$users = array();
    	}
		
    	$title = apply_filters('widget_title', __( 'Video chat room', 'widget-tinychat-status' ));
    	echo $before_widget;
    	?>
			<?php echo $before_title . $title; ?>
			<?php echo $after_title; ?>
			<p class="webchat-status"><?php 
				if(count($users) == 0) {
					_e("No user chatting", 'widget-tinychat-status' ); 
					echo " - <a href='" . get_option('tinychat_chat_url') . "' >join</a>";
				} else {
					printf(__("%d users chatting now", 'widget-tinychat-status'), count($users));
					echo " - <a href='" . get_option('tinychat_chat_url') . "' ><u>join</u></a>";
				}
			?></p>
			<ul>
			<?php foreach($users as $user) {?>
				<div><img src="<?php echo $user['pic'];?>" title="<?php echo $user['name'];?>" class="webchat-img"></div>
			<?php }?>
			</ul>
		<?php 
		echo $after_widget; 
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['max_show'] = strip_tags($new_instance['max_show']);
 
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'max_show' => '') );
		$max_show = strip_tags($instance['max_show']);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('alias'); ?>"><?php _e("Maximum number of users to display", 'widget-tinychat-status' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('max_show'); ?>" 
					name="<?php echo $this->get_field_name('max_show'); ?>" type="text" 
					value="<?php echo attribute_escape($max_show); ?>" />
			</label>
		</p>
		<?php
	}
}
?>