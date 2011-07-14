<?php
/**
 * Flickr Widget Class
 */
class adelante_widget_flickr extends WP_Widget 
{
	function adelante_widget_flickr() 
    {
		$widget_ops = array('classname' => 'widget_flickr', 'description' => __( 'Displays photos from Flickr', 'adelante' ) );
		$this->WP_Widget('flickr', THEME_SLUG.' - '.__('Flickr', 'adelante'), $widget_ops);
	}

	function widget( $args, $instance ) 
    {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Photos on flickr' : $instance['title'], $instance, $this->id_base);
		$type = empty( $instance['type'] ) ? 'user' : $instance['type'];
		$flickr_id = $instance['flickr_id'];
		$count = (int)$instance['count'];
		$display = empty( $instance['display'] ) ? 'latest' : $instance['display'];

		if($count < 1){
			$count = 1;
		}
		
		if ( !empty( $flickr_id ) ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
		?>
		<div class="flickr_wrap">
			<script src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $count; ?>&amp;display=<?php echo $display; ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type;?>&amp;<?php echo $type;?>=<?php echo $flickr_id; ?>"></script>
		</div>
		<div class="clearboth"></div>
		<?php
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['type'] = strip_tags($new_instance['type']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);
		$instance['count'] = (int) $new_instance['count'];
		$instance['display'] = strip_tags($new_instance['display']);
		
		return $instance;
	}

	function form( $instance ) 
    {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$type = isset($instance['type']) ? esc_attr($instance['type']) : 'user';
		$flickr_id = isset($instance['flickr_id']) ? esc_attr($instance['flickr_id']) : '';
		$count = isset($instance['count']) ? absint($instance['count']) : 3;
		$display = isset( $instance['display'] ) ? $instance['display'] : 'latest';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e( 'Type:', 'adelante' ); ?></label>
			<select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" class="widefat">
				<option value="user"<?php selected($type,'user');?>>User</option>
				<option value="group"<?php selected($type,'group');?>>Group</option>
			</select>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Flickr ID (<a href="http://www.idgettr.com" target="_blank">idGettr</a>):', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of photo to show:', 'adelante'); ?></label>
		<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>
		
		<p><label for="<?php echo $this->get_field_id('display'); ?>"><?php _e('Method for display your photos:', 'adelante'); ?></label>
		<select id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>">
			<option<?php if($display == 'latest') echo ' selected="selected"'?> value="latest"><?php _e('Latest', 'adelante'); ?></option>
			<option<?php if($display == 'random') echo ' selected="selected"'?> value="random"><?php _e('Random', 'adelante'); ?></option>
		</select>
<?php
	}
}
