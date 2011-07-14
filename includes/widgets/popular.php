<?php
/**
 * Popular_Posts Widget Class
 */
class adelante_widget_popular extends WP_Widget 
{
	function adelante_widget_popular() 
    {
		$widget_ops = array('classname' => 'widget_popular_posts', 'description' => __( "Displays the popular posts on your site", 'adelante') );
		$this->WP_Widget('popular_posts', THEME_SLUG.' - '.__('Popular Posts', 'adelante'), $widget_ops);
		$this->alt_option_name = 'widget_popular_posts';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) 
    {
		$cache = wp_cache_get('theme_widget_popular_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Popular Posts', 'adelante') : $instance['title'], $instance, $this->id_base);
		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;
		
		if ( !$desc_length = (int) $instance['desc_length'] )
			$desc_length = 80;
		else if ( $desc_length < 1 )
			$desc_length = 1;
		
		$disable_thumbnail = $instance['disable_thumbnail'] ? '1' : '0';
		$display_extra_type = $instance['display_extra_type'] ? $instance['display_extra_type'] :'time';

		$query = array('showposts' => $number, 'nopaging' => 0, 'orderby'=> 'comment_count', 'post_status' => 'publish', 'caller_get_posts' => 1);
		if(!empty($instance['cat'])){
			$query['cat'] = implode(',', $instance['cat']);
		}
		$r = new WP_Query($query);
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="posts_list">
<?php  while ($r->have_posts()) : $r->the_post(); ?>
			<li>
<?php if ( ! $disable_thumbnail ) :?>
            <figure class="widget-popular-img">
                <a class="thumbnail" href="<?php echo get_permalink() ?>" title="<?php the_title();?>">
<?php if (has_post_thumbnail() ): ?>                    
                    <?php
                        $thumb = get_post_thumbnail_id( $r->post->ID ); 
                        $image = wp_get_attachment_image_src( $thumb, 'full' ); 
                    ?>
                    <img src="<?php echo adelante_image_resize(62, 62, "http://". $_SERVER['SERVER_NAME']. $image[0]); ?>" alt="<?php the_title();?>" title="<?php the_title();?>" />    
<?php else:?>
                    <img src="<?php echo adelante_image_resize(65, 65, ADELANTE_BASE_URI. "/img/empty_thumb.png"); ?>" alt="<?php the_title();?>" title="<?php the_title();?>" />
<?php endif; ?>                   
                </a>
                <?php adelante_image_border(null, 3, 0.1); ?>
             </figure>
<?php endif; ?>
				<div class="post_extra_info">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
<?php if($display_extra_type == 'time'):?>
					<time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time>
<?php else:?>
					<p><?php echo wp_html_excerpt(get_the_excerpt(),$desc_length);?>...</p>
<?php endif; ?>
				</div>
				<div class="clearboth"></div>
			</li>
<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_query();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('theme_widget_popular_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['desc_length'] = (int) $new_instance['desc_length'];
		$instance['disable_thumbnail'] = !empty($new_instance['disable_thumbnail']) ? 1 : 0;
		$instance['display_extra_type'] = $new_instance['display_extra_type'];
		$instance['cat'] = $new_instance['cat'];
		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() 
    {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) 
    {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$disable_thumbnail = isset( $instance['disable_thumbnail'] ) ? (bool) $instance['disable_thumbnail'] : false;
		$display_extra_type = isset( $instance['display_extra_type'] ) ? $instance['display_extra_type'] : 'time';
		$cat = isset($instance['cat']) ? $instance['cat'] : array();
		
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 5;

		if ( !isset($instance['desc_length']) || !$desc_length = (int) $instance['desc_length'] )
			$desc_length = 80;

		$categories = get_categories('orderby=name&hide_empty=0');

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'adelante'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('disable_thumbnail'); ?>" name="<?php echo $this->get_field_name('disable_thumbnail'); ?>"<?php checked( $disable_thumbnail ); ?> />
		<label for="<?php echo $this->get_field_id('disable_thumbnail'); ?>"><?php _e( 'Disable Post Thumbnail?' , 'adelante'); ?></label></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('display_extra_type'); ?>"><?php _e( 'Display Extra infomation type:', 'adelante' ); ?></label>
			<select name="<?php echo $this->get_field_name('display_extra_type'); ?>" id="<?php echo $this->get_field_id('display_extra_type'); ?>" class="widefat">
				<option value="time"<?php selected($display_extra_type,'time');?>><?php _e( 'Time', 'adelante' ); ?></option>
				<option value="description"<?php selected($display_extra_type,'description');?>><?php _e( 'Description', 'adelante' ); ?></option>
			</select>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('desc_length'); ?>"><?php _e('Length of Description to show:', 'adelante'); ?></label>
		<input id="<?php echo $this->get_field_id('desc_length'); ?>" name="<?php echo $this->get_field_name('desc_length'); ?>" type="text" value="<?php echo $desc_length; ?>" size="3" /></p>

		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e( 'Categories:' , 'adelante'); ?></label>
			<select style="height:5.5em" name="<?php echo $this->get_field_name('cat'); ?>[]" id="<?php echo $this->get_field_id('cat'); ?>" class="widefat" multiple="multiple">
				<?php foreach($categories as $category):?>
				<option value="<?php echo $category->term_id;?>"<?php echo in_array($category->term_id, $cat)? ' selected="selected"':'';?>><?php echo $category->name;?></option>
				<?php endforeach;?>
			</select>
		</p>
<?php
	}
}