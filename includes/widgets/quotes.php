<?php
/**
 * Quotes Widget Class
 */
class adelante_widget_quotes extends WP_Widget 
{
	function adelante_widget_quotes() 
    {
		$widget_ops = array( 
            'classname' => 'widget_quotes', 
            'description' => __( 'Displays random quotes', 'adelante' ),
            'source' => array(
                "geek" => array(
                    "esr", "humorix_misc", "humorix_stories", "joel_on_software", "macintosh", "math", "mav_flame", "osp_rules", 
                    "paul_graham", "prog_style", "subversion"
                ),
                "general" => array(
                    "codehappy", "fortune", "liberty", "literature", "misc", "murphy", 
                    "oneliners", "riddles", "rkba", "shlomif", "shlomif_fav", "stephen_wright" 
                ),
                "pop" => array(
                    "calvin", "forrestgump", "friends", "futurama", "holygrail", "powerpuff", "simon_garfunkel", "simpsons_cbg", 
                    "simpsons_chalkboard", "simpsons_homer", "simpsons_ralph", "south_park", "starwars", "starwars", "xfiles"
                ),
                "religious" => array(
                    "bible", "contentions", "osho"
                ),
                "scifi" => array(
                    "cryptonomicon", "discworld", "dune", "hitchhiker"
                )
            )
        );
		$this->WP_Widget( 'quotes', THEME_SLUG.' - '. __('Quotes', 'adelante'), $widget_ops );
	}

	function widget( $args, $instance ) 
    {   
        extract( $args );
        
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? 'Quote' : $instance['title'], $instance, $this->id_base );
		$min_lines = $instance['min_lines'];
        $max_lines = $instance['max_lines'];
        $max_characters = $instance['max_characters'];
        $source = $instance['source'];
        $refresh = $instance['refresh'];
    
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		         
        $uri = "http://iheartquotes.com/api/v1/random?format=json";
        if (!empty($min_lines)) $uri .= "&min_lines=$min_lines";
        if (!empty($max_lines)) $uri .= "&max_lines=$max_lines";
        if (!empty($max_characters)) $uri .= "&max_characters=$max_characters";
        if (!empty($source)) $uri .= "&source=". implode("+", $source);
        
        echo '<div class="quote_wrap aligncenter"></div>'. $after_widget;       
    ?>
		<div class="clearboth"></div>
        <script>
            $.getJSON('<?php echo ADELANTE_INCLUDES_URI. "ajax/get_quote.php"; ?>', { uri: '<?php echo $uri; ?>' }, function(json) {                   
                $('.quote_wrap').html("<blockquote>" + json.quote + "</blockquote>").fadeIn(1000);
            });
            var refreshId = setInterval(function(){
                $('.quote_wrap blockquote').slideUp(500).remove();
                $.getJSON('<?php echo ADELANTE_INCLUDES_URI. "ajax/get_quote.php"; ?>', { uri: '<?php echo $uri; ?>' }, function(json) {                   
                    $('.quote_wrap').html("<blockquote>" + json.quote + "</blockquote>").fadeIn(1000);
                });               
            }, '<?php echo 1000*$refresh; ?>');

        </script>
<?php
	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
        
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['min_lines'] = (int) $new_instance['min_lines'];
        $instance['max_lines'] = (int) $new_instance['max_lines'];
        $instance['max_characters'] = (int) $new_instance['max_characters'];
		$instance['source'] = $new_instance['source'];
        $instance['refresh'] = (int) $new_instance['refresh'];
        
		return $instance;
	}

	function form( $instance ) 
    {      
		$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Random Quotes';
		$min_lines = isset($instance['min_lines']) ? absint($instance['min_lines']) : 1;
        $max_lines = isset($instance['max_lines']) ? absint($instance['max_lines']) : 4;
		$max_characters = isset($instance['max_characters']) ? absint($instance['max_characters']) : 350;
        $source = isset($instance['source']) ? $instance['source'] : array();
        $refresh = isset($instance['refresh']) ? absint($instance['refresh']) : 30;
?>
		<p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'adelante'); ?></label>
		    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>		
		<p>
            <label for="<?php echo $this->get_field_id('min_lines'); ?>"><?php _e('Min. number of lines:', 'adelante'); ?></label>
		    <input id="<?php echo $this->get_field_id('min_lines'); ?>" name="<?php echo $this->get_field_name('min_lines'); ?>" type="text" value="<?php echo $min_lines; ?>" size="3" />
        </p>        
        <p>
            <label for="<?php echo $this->get_field_id('max_lines'); ?>"><?php _e('Max. number of lines:', 'adelante'); ?></label>
            <input id="<?php echo $this->get_field_id('max_lines'); ?>" name="<?php echo $this->get_field_name('max_lines'); ?>" type="text" value="<?php echo $max_lines; ?>" size="3" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('max_characters'); ?>"><?php _e('Max. number of characters:', 'adelante'); ?></label>
            <input id="<?php echo $this->get_field_id('max_characters'); ?>" name="<?php echo $this->get_field_name('max_characters'); ?>" type="text" value="<?php echo $max_characters; ?>" size="3" />
        </p>        		
        <p>
            <label for="<?php echo $this->get_field_id('source'); ?>"><?php _e('Obtain quotes from:', 'adelante'); ?></label>
            <select class="widefat" style="height:5.5em" id="<?php echo $this->get_field_id('source'); ?>" name="<?php echo $this->get_field_name('source'); ?>[]" multiple="multiple"> 
                <?php foreach($this->widget_options["source"]["general"] as $src):?>
                    <option value="<?php echo $src;?>"<?php echo in_array($src, $source)? ' selected="selected"':'';?>><?php echo $src;?></option>
                <?php endforeach;?>
            </select>  
        </p> 
        <p>
            <label for="<?php echo $this->get_field_id('refresh'); ?>"><?php _e('Auto-refresh every:', 'adelante'); ?></label>
            <input id="<?php echo $this->get_field_id('refresh'); ?>" name="<?php echo $this->get_field_name('refresh'); ?>" type="text" value="<?php echo $refresh; ?>" size="3" /> sec.
        </p>      		
<?php
	}
}

