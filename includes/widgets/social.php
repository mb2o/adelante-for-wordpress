<?php
/**
 * Social Icon Widget Class
 */
class adelante_widget_social extends WP_Widget {

	var $sites = array(
		'AIM','Apple','Bebo','Blogger','Brightkite','Cargo','Delicious','Designfloat',
		'Designmoo','Deviantart','Digg','Dopplr','Dribbble','Email','Ember','Evernote',
		'Facebook','Flickr','Forrst','Friendfeed','Gamespot','GitHub','Google','GoogleVoice','GoogleWave',
		'GoogleTalk','Gowalla','Grooveshark','iLike','lastFm','LinkedIn','Mixx','MobileMe',
		'Mynameise','MySpace','Netvibes','Newsvine','Openid','Orkut','Pandora','Paypal','Picasa',
		'Playstation','Plurk','Posterous','qik','Readernaut','Reddit','Roboto','RSS','Sharethis',
		'Skype','StumbleUpon','Technorati','Tumblr','Twitter','Viddler','Vimeo','Virb','Wordpress',
		'Xing','Yahoo','YahooBuzz','Yelp','YouTube','Zootool'
	);
	var $packages = array(
		'komodomedia_16' => array(
			'name'=>'Social Network Icon Pack 16px',
			'path'=>'komodomedia_16/{:name}_16.png',
		),
		'komodomedia_32' => array(
			'name'=>'Social Network Icon Pack 32px',
			'path'=>'komodomedia_32/{:name}_32.png',
		),
	);
	
	
	function adelante_widget_social() {
		$widget_ops = array('classname' => 'widget_social', 'description' => 'Displays a list of Social Icon icons');
		$this->WP_Widget('social', THEME_SLUG.' - Social', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$alt = isset($instance['alt'])?$instance['alt']:'';
		$animation = isset($instance['animation'])?$instance['animation']:'fade';
		$package = $instance['package'];
		$custom_count = $instance['custom_count'];
		$output = '';
		if( !empty($instance['enable_sites']) ){
			foreach($instance['enable_sites'] as $site){
				$path = str_replace('{:name}',strtolower($site),$this->packages[$package]['path']);
				$link = isset($instance[$site])?$instance[$site]:'#';
				if(file_exists(ADELANTE_BASE . '/img/social/'.$path)){
					$output .= '<a href="'.$link.'" rel="nofollow" target="_blank"><img src="'.ADELANTE_BASE_URI.'/img/social/'.$path.'" alt="'.$alt.' '.$site.'" title="'.$alt.' '.$site.'"/></a>';
				}
			}
		}
		if( $custom_count > 0){
			for($i=1; $i<= $custom_count; $i++){
				$name = isset($instance['custom_'.$i.'_name'])?$instance['custom_'.$i.'_name']:'';
				$icon = isset($instance['custom_'.$i.'_icon'])?$instance['custom_'.$i.'_icon']:'';
				$link = isset($instance['custom_'.$i.'_url'])?$instance['custom_'.$i.'_url']:'#';
				if(!empty($icon)){
					$output .= '<a href="'.$link.'" rel="nofollow" target="_blank"><img src="'.$icon.'" alt="'.$alt.' '.$name.'" title="'.$alt.' '.$name.'"/></a>';
				}
			}
		}
		if ( !empty( $output ) ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
		?>
		<div class="social_wrap social_animation_<?php echo $animation;?> <?php echo $package;?>">
			<?php echo $output; ?>
		</div>
		<?php
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['alt'] = strip_tags($new_instance['alt']);
		$instance['package'] = strip_tags($new_instance['package']);
		$instance['animation'] = strip_tags($new_instance['animation']);
		$instance['enable_sites'] = $new_instance['enable_sites'];
		$instance['custom_count'] = (int) $new_instance['custom_count'];

		if(!empty($instance['enable_sites'])){
			foreach($instance['enable_sites'] as $site){
				$instance[$site] = isset($new_instance[$site])?strip_tags($new_instance[$site]):'';
			}
		}
		for($i=1;$i<=$instance['custom_count'];$i++){
			$instance['custom_'.$i.'_name'] = strip_tags($new_instance['custom_'.$i.'_name']);
			$instance['custom_'.$i.'_url'] = strip_tags($new_instance['custom_'.$i.'_url']);
			$instance['custom_'.$i.'_icon'] = strip_tags($new_instance['custom_'.$i.'_icon']);
		}
		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$alt = isset($instance['alt']) ? esc_attr($instance['alt']) : 'Follow Us on';
		$animation = isset($instance['animation']) ? $instance['animation'] : 'fade';
		$package = isset($instance['package']) ? $instance['package'] : '';
		$enable_sites = isset($instance['enable_sites']) ? $instance['enable_sites'] : array();
		foreach($this->sites as $site){
			$$site = isset($instance[$site]) ? esc_attr($instance[$site]) : '';
		}

		$custom_count = isset($instance['custom_count']) ? absint($instance['custom_count']) : 0;
		for($i=1;$i<=10;$i++){
			$custom_name = 'custom_'.$i.'_name';
			$$custom_name = isset($instance[$custom_name]) ? $instance[$custom_name] : '';
			$custom_url = 'custom_'.$i.'_url';
			$$custom_url = isset($instance[$custom_url]) ? $instance[$custom_url] : '';
			$custom_icon = 'custom_'.$i.'_icon';
			$$custom_icon = isset($instance[$custom_icon]) ? $instance[$custom_icon] : '';
		}
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'adelante'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Icon Alt Title:', 'adelante'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" name="<?php echo $this->get_field_name('alt'); ?>" type="text" value="<?php echo $alt; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('package'); ?>"><?php _e( 'Icon Package:' , 'adelante'); ?></label>
			<select name="<?php echo $this->get_field_name('package'); ?>" id="<?php echo $this->get_field_id('package'); ?>" class="widefat">
				<?php foreach($this->packages as $name => $value):?>
				<option value="<?php echo $name;?>"<?php selected($package,$name);?>><?php echo $value['name'];?></option>
				<?php endforeach;?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e( 'Icon Hover Animation:', 'adelante' ); ?></label>
			<select name="<?php echo $this->get_field_name('animation'); ?>" id="<?php echo $this->get_field_id('animation'); ?>" class="widefat">
				<option value="fade"<?php selected($animation,'fade');?>><?php _e( 'Fade', 'adelante' ); ?></option>
				<option value="scale"<?php selected($animation,'scale');?>><?php _e( 'Scale', 'adelante' ); ?></option>
				<option value="bounce"<?php selected($animation,'bounce');?>><?php _e( 'Bounce', 'adelante' ); ?></option>
				<option value="combo"<?php selected($animation,'combo');?>><?php _e( 'Combo', 'adelante' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('enable_sites'); ?>"><?php _e( 'Enable Social Icon:', 'adelante' ); ?></label>
			<select name="<?php echo $this->get_field_name('enable_sites'); ?>[]" style="height:10em" id="<?php echo $this->get_field_id('enable_sites'); ?>" class="social_icon_select_sites widefat" multiple="multiple">
				<?php foreach($this->sites as $site):?>
				<option value="<?php echo $site;?>"<?php echo in_array($site, $enable_sites)? 'selected="selected"':'';?>><?php echo $site;?></option>
				<?php endforeach;?>
			</select>
		</p>
		
		<p>
			<em><?php _e("Note: Please input FULL URL <br/>(e.g. <code>http://www.example.com</code>)", 'adelante');?></em>
		</p>
		<div class="social_icon_wrap">
		<?php foreach($this->sites as $site):?>
		<p class="social_icon_<?php echo $site;?>" <?php if(!in_array($site, $enable_sites)):?>style="display:none"<?php endif;?>>
			<label for="<?php echo $this->get_field_id( $site ); ?>"><?php echo $site.' '.__('URL:', 'adelante')?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( $site ); ?>" name="<?php echo $this->get_field_name( $site ); ?>" type="text" value="<?php echo $$site; ?>" />
		</p>
		<?php endforeach;?>
		</div>

		<p><label for="<?php echo $this->get_field_id('custom_count'); ?>"><?php _e('How many custom icons to add?', 'adelante'); ?></label>
		<input id="<?php echo $this->get_field_id('custom_count'); ?>" class="social_icon_custom_count" name="<?php echo $this->get_field_name('custom_count'); ?>" type="text" value="<?php echo $custom_count; ?>" size="3" /></p>

		<div class="social_custom_icon_wrap">
		<?php for($i=1;$i<=10;$i++): $custom_name='custom_'.$i.'_name';$custom_url='custom_'.$i.'_url'; $custom_icon='custom_'.$i.'_icon'; ?>
			<div class="social_icon_custom_<?php echo $i;?>" <?php if($i>$custom_count):?>style="display:none"<?php endif;?>>
				<p><label for="<?php echo $this->get_field_id( $custom_name ); ?>"><?php printf(__('Custom %s Name:', 'adelante'),$i);?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $custom_name ); ?>" name="<?php echo $this->get_field_name( $custom_name ); ?>" type="text" value="<?php echo $$custom_name; ?>" /></p>
				<p><label for="<?php echo $this->get_field_id( $custom_url ); ?>"><?php printf(__('Custom %s URL:', 'adelante'),$i);?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $custom_url ); ?>" name="<?php echo $this->get_field_name( $custom_url ); ?>" type="text" value="<?php echo $$custom_url; ?>" /></p>
				<p><label for="<?php echo $this->get_field_id( $custom_icon ); ?>"><?php printf(__('Custom %s Icon:', 'adelante'),$i);?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $custom_icon ); ?>" name="<?php echo $this->get_field_name( $custom_icon ); ?>" type="text" value="<?php echo $$custom_icon; ?>" /></p>
			</div>

		<?php endfor;?>
		</div>


		
<?php
	}
}