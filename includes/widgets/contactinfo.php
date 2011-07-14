<?php
/**
 * Contact Info Widget Class
 */
class adelante_widget_contactinfo extends WP_Widget 
{

	function adelante_widget_contactinfo() 
    {
		$widget_ops = array('classname' => 'widget_contact_info', 'description' => __( 'Displays a list of contact info.', 'adelante') );
		$this->WP_Widget('contact_info',THEME_SLUG.' - '. __('Contact Info', 'adelante'), $widget_ops);		
	}
	
	function widget( $args, $instance ) 
    {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Contact Us', 'striking_front') : $instance['title'], $instance, $this->id_base);
		$text = $instance['text'];
		$phone = $instance['phone'];
		$cellphone = $instance['cellphone'];
		$email= $instance['email'];
		$address = $instance['address'];
		$city = $instance['city'];
		$state = $instance['state'];
		$zip = $instance['zip'];
		$name = $instance['name'];
        
		if(!empty($city) && !empty($state)){
			$city = $city.',&nbsp;'.$state;
		}elseif(!empty($state)){
			$city = $state;
		}
		
		
		echo $before_widget;
		if ( $title)
			echo $before_title . $title . $after_title;
		
		?>
			<div class="contact_info_wrap">
			<?php if(!empty($text)):?><p><?php echo $text;?></p><?php endif;?>
			
			<?php if(!empty($phone)):?><p><span class="icon_text icon_phone"><?php echo $phone;?></span></p><?php endif;?>
			<?php if(!empty($cellphone)):?><p><span class="icon_text icon_cellphone"><?php echo $cellphone;?></span></p><?php endif;?>
			<?php if(!empty($email)):?><p><a href="mailto:<?php echo $email;?>" class="icon_text icon_email"><?php echo $email;?></a></p><?php endif;?>
			<?php if(!empty($address)):?><p><span class="icon_text icon_home"><?php echo $address;?></span></p><?php endif;?>
			<?php if(!empty($city)||!empty($zip)):?><p class="contact_address">
				<?php if(!empty($city)):?><span><?php echo $city;?></span><?php endif;?>
				<?php if(!empty($zip)):?><span class="contact_zip"><?php echo $zip;?></span><?php endif;?>
			</p><?php endif;?>
			<?php if(!empty($name)):?><p><span class="icon_text icon_id"><?php echo $name;?></span></p><?php endif;?>
			</div>
		<?php
		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['phone'] = strip_tags($new_instance['phone']);
		$instance['cellphone'] = strip_tags($new_instance['cellphone']);
		$instance['email'] = strip_tags($new_instance['email']);
		$instance['address'] = strip_tags($new_instance['address']);
		$instance['city'] = strip_tags($new_instance['city']);
		$instance['state'] = strip_tags($new_instance['state']);
		$instance['zip'] = strip_tags($new_instance['zip']);
		$instance['name'] = strip_tags($new_instance['name']);

		return $instance;
	}

	function form( $instance ) 
    {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$text = isset($instance['text']) ? esc_attr($instance['text']) : '';
		$phone = isset($instance['phone']) ? esc_attr($instance['phone']) : '';
		$cellphone = isset($instance['cellphone']) ? esc_attr($instance['cellphone']) : '';
		$email = isset($instance['email']) ? esc_attr($instance['email']) : '';
		$address = isset($instance['address']) ? esc_attr($instance['address']) : '';
		$city = isset($instance['city']) ? esc_attr($instance['city']) : '';
		$state = isset($instance['state']) ? esc_attr($instance['state']) : '';
		$zip = isset($instance['zip']) ? esc_attr($instance['zip']) : '';
		$name = isset($instance['name']) ? esc_attr($instance['name']) : '';
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Introduce text:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo $phone; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('cellphone'); ?>"><?php _e('Cell phone:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('cellphone'); ?>" name="<?php echo $this->get_field_name('cellphone'); ?>" type="text" value="<?php echo $cellphone; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo $address; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('city'); ?>"><?php _e('City:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('city'); ?>" name="<?php echo $this->get_field_name('city'); ?>" type="text" value="<?php echo $city; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('state'); ?>"><?php _e('State:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('state'); ?>" name="<?php echo $this->get_field_name('state'); ?>" type="text" value="<?php echo $state; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('zip'); ?>"><?php _e('Zip:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('zip'); ?>" name="<?php echo $this->get_field_name('zip'); ?>" type="text" value="<?php echo $zip; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Name:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo $name; ?>" /></p>
		
<?php
	}

}