<?php

function adelante_head() {    
    echo '<link rel="stylesheet" href="' . ADELANTE_INCLUDES_URI . 'css/admin.css" />' . "\n";  
    echo '<script src="'. ADELANTE_INCLUDES_URI. 'js/rangeinput.js'. '"></script>';
    echo '<script src="'. ADELANTE_INCLUDES_URI. 'js/mcolorpicker.js'. '"></script>'; 
    echo '<script src="'. ADELANTE_INCLUDES_URI. 'js/custom.js'. '"></script>';
}
add_action( 'admin_head', 'adelante_head' );
    
// show an admin notice to update if tagline hasn't been changed
// you want to change this or remove it because it's used as the description in the RSS feed
if ( get_option( 'blogdescription' ) === 'Just another WordPress site' ) 
{ 
	add_action( 'admin_notices', create_function('', "echo '<div class=\"error\"><p>". sprintf(__('Please update your <a href="%s">site tagline</a>', 'adelante' ), admin_url( 'options-general.php' ) ) . "</p></div>';" ) );
};

// Set the post revisions to 5 unless the constant was set in wp-config.php to avoid DB bloat
if ( ! defined( 'WP_POST_REVISIONS' ) ) 
    define( 'WP_POST_REVISIONS', 5 );

// Allow for more tags in TinyMCE including iframes
function adelante_change_mce_options($options) 
{
	$ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';	
	if (isset($initArray['extended_valid_elements'])) 
    {
		$options['extended_valid_elements'] .= ',' . $ext;
	} 
    else 
    {
		$options['extended_valid_elements'] = $ext;
	}
	return $options;
}
add_filter('tiny_mce_before_init', 'adelante_change_mce_options');