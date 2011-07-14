<?php
/**
 * Contact Form Widget Class
 */
class adelante_widget_contactform extends WP_Widget 
{
	function adelante_widget_contactform() 
    {
		$widget_ops = array('classname' => 'widget_contact_form', 'description' => __( 'Display an email contact form.', 'adelante') );
		$this->WP_Widget('contact_form', THEME_SLUG.' - '.__('Contact Form', 'adelante'), $widget_ops);
		
		if ( is_active_widget(false, false, $this->id_base) ){
			add_action( 'wp_print_scripts', array(&$this, 'add_script') );
		}
	}
	
	function add_script()
    {
		wp_enqueue_script( 'jquery-tools-validator');
	}
	
	function widget( $args, $instance ) 
    {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Email Us', 'adelante') : $instance['title'], $instance, $this->id_base);
		$email= $instance['email'];
		

		if ( empty( $success ) ) {
			$success = __('Your message was successfully sent. <strong>Thank You!</strong>','adelante');
		}

		echo $before_widget;
		if ( $title )
			echo $before_title. $title. $after_title;
		
		?>
		<p style="display:none;"><?php _e('Your message was successfully sent. <strong>Thank You!</strong>','adelante');?></p>
		<form class="contact_form" action="<?php echo ADELANTE_INCLUDES_URI;?>sendmail.php" method="post">
			<p>
                <input placeholder="Name" type="text" required="required" id="contact_name" name="contact_name" class="text_input" value="" size="22" tabindex="5" />
			</p>			
			<p>
                <input placeholder="Email address" type="email" required="required" id="contact_email" name="contact_email" class="text_input" value="" size="22" tabindex="6"  />
			</p>			
			<p>
                <textarea placeholder="Your message" required="required" name="contact_content" class="textarea" cols="20" rows="3" tabindex="7"></textarea>
            </p>			
			<p>                
                <input type="submit" class="adelante-button white" value="Send" />
            </p>
			
            <input type="hidden" value="<?php echo $email;?>" name="contact_to"/>
		</form>
        
        <script>                
            /* ------- Contact form submission ------- */            
            $('.widget_contact_form .adelante-button').live('click', function(){
                $.ajax({
                    url: '<?php echo ADELANTE_INCLUDES_URI;?>sendmail.php',
                    type: 'POST',
                    data: $('form.contact_form').serialize(),
                    success: function(result){
                        $('.widget_contact_form').html(result);
                    }
                });                
                return false;
            })
        </script>
        
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['email'] = strip_tags($new_instance['email']);

		return $instance;
	}

	function form( $instance ) 
    {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$email = isset($instance['email']) ? esc_attr($instance['email']) :get_bloginfo('admin_email');
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Your Email:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" /></p>
		
<?php
	}

}
