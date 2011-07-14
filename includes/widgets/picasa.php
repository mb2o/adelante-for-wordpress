<?php
/**
 * picasa Widget Class
 */
class adelante_widget_picasa extends WP_Widget 
{
	function adelante_widget_picasa() 
    {
		$widget_ops = array( 'classname' => 'widget_picasa', 'description' => __( 'Displays photos from Picasa', 'adelante' ) );
		$this->WP_Widget( 'picasa', THEME_SLUG.' - '. __('Picasa', 'adelante'), $widget_ops );
	}

    function picasa_widget_square( $dim )
    {
        return ( $dim == 32 ) || ( $dim == 48 ) || ( $dim == 64 ) || ( $dim == 128 ) || ( $dim == 160 );
    }
    
	function widget( $args, $instance ) 
    {
		extract( $args );
        
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? 'Photos on Picasa' : $instance['title'], $instance, $this->id_base );
		$username = $instance['username'];
        $columns = $instance['columns'];
        $items = $instance['items'];
        $width = $instance['width'];
        
		if ( ! empty( $username ) ) {
			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
		    
            if ( file_exists( ABSPATH. WPINC . '/rss.php' ) )
                require_once( ABSPATH. WPINC . '/rss.php' );
            else
                require_once( ABSPATH. WPINC . '/rss-functions.php' );

            $output = "<div class=picasa_wrap align=center>";

            $rss = fetch_rss( "http://picasaweb.google.com/data/feed/base/user/$username?kind=album&alt=rss&hl=en_US&access=public&max-results=$items" );
            if ( is_array( $rss->items ) ) {
                $i = 0;
                $album = rand( 0, sizeof( $rss->items ) - 1 );
                foreach( $rss->items as $item ) {
                    $title = $item['title'];
                    $title = str_replace( "'", "", $title );
                    $title = str_replace( '"', "", $title );
                    $link = $item['link'];
                    
                    preg_match( '/.*src="(.*?)".*/', $item['description'], $sub );
                    $path = $sub[1];
                    $path = str_replace("s160-", "s$width-", $path );

                    if ( $i == $album ) {
                        $rss2 = fetch_rss( str_replace( "entry", "feed", $item['guid'] ). "&kind=photo" );
                        if ( ! $rss2 ) continue;
                        $j = 0;
                        foreach( $rss2->items as $item2 ) {
                            $title = $item2['title'];
                            $title = str_replace( "'", "", $title);
                            $title = str_replace( '"', "", $title);
                            preg_match( '/.*src="(.*?)".*/', $item2['description'], $sub );
                            $path = $sub[1];
                            $path = str_replace( "s288", "s$width-c", $path );
                            $array[$j++] = "<figure class='picasa-widget-img'><a href=". $item2['link']. " target=_blank>". adelante_image_border("<img src=". 
                                            $path. " alt='$title' title='$title'>", 3, 0.1). "</a></figure>";
                        }
                        srand((float)microtime()*1000000);
                        shuffle( $array );
                        for( $k = 0; $k < $items; $k++ ) {
                            $output .= $array[$k];
                            if ( $items != 1 )
                                if ( ( $k + 1 ) % $columns == 0 )
                                    $output .= "<div class=\"clearboth\"></div>";
                                else
                                    $output .= "";
                            else
                                $output .= "<div class=\"clearboth\"></div>";
                        }
                    }

                    $i++;
                }
            }
            echo "$output</div>". $after_widget ; 
        ?>
		    <div class="clearboth"></div>
		<?php
		}
	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
        
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
        $instance['columns'] = (int) $new_instance['columns'];
        $instance['items'] = (int) $new_instance['items'];
		$instance['width'] = (int) $new_instance['width'];
        
		return $instance;
	}

	function form( $instance ) 
    {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$username = isset($instance['username']) ? esc_attr($instance['username']) : '';
        $columns = isset($instance['columns']) ? absint($instance['columns']) : 3;
		$items = isset($instance['items']) ? absint($instance['items']) : 9;
        $width = isset($instance['width']) ? absint($instance['width']) : 75;
?>
		<p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'adelante'); ?></label>
		    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>		
		<p>
            <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:', 'adelante'); ?></label>
		    <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" />
        </p>        
        <p>
            <label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of columns:', 'adelante'); ?></label>
            <input id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('columns'); ?>" type="text" value="<?php echo $columns; ?>" size="3" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width of photos:', 'adelante'); ?></label>
            <input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" size="3" /> px
        </p>        		
        <p>
            <label for="<?php echo $this->get_field_id('items'); ?>"><?php _e('Number of photos:', 'adelante'); ?></label>
            <input id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo $items; ?>" size="3" />
        </p>      		
<?php
	}
}