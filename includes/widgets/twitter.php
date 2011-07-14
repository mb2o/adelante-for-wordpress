<?php
/**
 * Twitter Widget Class
 */
class adelante_widget_twitter extends WP_Widget 
{
	function adelante_widget_twitter() 
    {
		$widget_ops = array('classname' => 'widget_twitter', 'description' => __( 'Displays a list of twitter feeds', 'adelante' ) );
		$this->WP_Widget('twitter', THEME_SLUG.' - '.__('Twitter', 'adelante'), $widget_ops);
		
		if ( is_active_widget(false, false, $this->id_base) ){
			add_action( 'wp_print_scripts', array(&$this, 'add_twitter_script') );
		}		
	}

	function add_twitter_script()
    {
		wp_enqueue_script( 'twitter-widget', ADELANTE_INCLUDES_URI . '/js/twitter.js', array('jquery'));
	}
	
	function widget( $args, $instance ) 
    {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Tweets', 'adelante') : $instance['title'], $instance, $this->id_base);
		$username= $instance['username'];
		
		$user_array = explode(',',$username);
		foreach($user_array as $key => $user){
			$user_array[$key] = '"'.$user.'"';
		}
		
		$query= empty($instance['query'])?'null':'"'.$instance['query'].'"';
		$count = (int)$instance['count'];
		if($count < 1){
			$count = 1;
		}
		
		if ( !empty( $user_array )|| $query!="null" ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
				
		$id = rand(1,1000);
		?>
		
		<script>
			jQuery(document).ready(function($) {
				 $("#twitter_wrap_<?php echo $id;?>").tweet({
					username: [<?php echo implode( ',', $user_array );?>],
					count: <?php echo $count;?>,
					query: <?php echo $query;?>,
					avatar_size: 32,
					seconds_ago_text: '<?php _e('about %d seconds ago','adelante');?>',
					a_minutes_ago_text: '<?php _e('about a minute ago','adelante');?>',
					minutes_ago_text: '<?php _e('about %d minutes ago','adelante');?>',
					a_hours_ago_text: '<?php _e('about an hour ago','adelante');?>',
					hours_ago_text: '<?php _e('about %d hours ago','adelante');?>',
					a_day_ago_text: '<?php _e('about a day ago','adelante');?>',
					days_ago_text: '<?php _e('about %d days ago','adelante');?>',
					view_text: '<?php _e('view tweet on twitter','adelante');?>'
				 });
			});
		</script>
		<div id="twitter_wrap_<?php echo $id;?>"<?php if ( $avatar_size != 'null' ):?> class="with_avatar"<?php endif;?>><div class="twitter_bird"></div></div>
		<div class="clearboth"></div>
		<?php
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['count'] = (int) $new_instance['count'];
		$instance['query'] = strip_tags($new_instance['query']);
		return $instance;
	}

	function form( $instance ) 
    {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$username = isset($instance['username']) ? esc_attr($instance['username']) : '';
		$query = isset($instance['query']) ? esc_attr($instance['query']) : '';
		$count = isset($instance['count']) ? absint($instance['count']) : 3;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:', 'adelante'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></p>
		
		<div class="updated settings-error below-h2">
            <p><?php _e("Note: Use ',' to specify multi user.<br> (e.g <code>user1,user2</code>)", 'adelante');?></p>
        </div>

		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('How many tweets to display?', 'adelante'); ?></label>
		<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>
		
		<p><label for="<?php echo $this->get_field_id('query'); ?>"><?php _e('Query (optional):', 'adelante'); ?></label>
		<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('query'); ?>" name="<?php echo $this->get_field_name('query'); ?>"><?php echo $query; ?></textarea>
		
		<p>
			<?php _e("Query uses <a href='http://dev.twitter.com/pages/using_search' target='_blank'>Twitter's Search API</a>, so you can display any tweets you like.", 'adelante');?>
		</p>
<?php
	}
}


/*
Example                     Finds tweets...
twitter search              containing both "twitter" and "search". This is the default operator
"happy hour"                containing the exact phrase "happy hour"
love OR hate                containing either "love" or "hate" (or both)
beer -root                  containing "beer" but not "root"
#haiku                      containing the hashtag "haiku"
from:twitterapi             sent from the user @twitterapi
to:twitterapi               sent to the user @twitterapi
place:opentable:2           about the place with OpenTable ID 2
place:247f43d441defc03      about the place with Twitter ID 247f43d441defc03
@twitterapi                 mentioning @twitterapi
superhero since:2011-05-09  containing "superhero" and sent since date "2011-05-09" (year-month-day).
twitterapi until:2011-05-09 containing "twitterapi" and sent before the date "2011-05-09".
movie -scary :)             containing "movie", but not "scary", and with a positive attitude.
flight :(                   containing "flight" and with a negative attitude.
traffic ?                   containing "traffic" and asking a question.
hilarious filter:links      containing "hilarious" and with a URL.
news source:tweet_button    containing "news" and entered via the Tweet Button
*/