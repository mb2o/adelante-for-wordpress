<?php

// Define constants
define('THEME_SLUG', 'Adelante');

define('ADELANTE_BASE', TEMPLATEPATH);
define('ADELANTE_BASE_URI', get_template_directory_uri() );
define('ADELANTE_STYLESHEET', ADELANTE_BASE. '/css/styles');
define('ADELANTE_STYLESHEET_URI', ADELANTE_BASE_URI . '/css/styles');
define('ADELANTE_JS', ADELANTE_BASE . '/js/' );
define('ADELANTE_JS_URI', ADELANTE_BASE_URI . '/js/' );
define('ADELANTE_INCLUDES', ADELANTE_BASE . '/includes/');
define('ADELANTE_INCLUDES_URI', ADELANTE_BASE_URI . '/includes/');
define('ADELANTE_PLUGINS', ADELANTE_INCLUDES . '/plugins/');
define('ADELANTE_PLUGINS_URI', ADELANTE_INCLUDES_URI . '/plugins/');
define('ADELANTE_WIDGETS', ADELANTE_INCLUDES . '/widgets/');
define('ADELANTE_WIDGETS_URI', ADELANTE_INCLUDES_URI . '/widgets/');

// Load various script files
include_once(ADELANTE_INCLUDES.'adelante-activation.php');	
include_once(ADELANTE_INCLUDES.'adelante-functions.php');
include_once(ADELANTE_INCLUDES.'adelante-admin.php');	
include_once(ADELANTE_INCLUDES.'adelante-options.php');
include_once(ADELANTE_INCLUDES.'adelante-post-options.php');	
include_once(ADELANTE_INCLUDES.'adelante-scripts.php');      
include_once(ADELANTE_INCLUDES.'adelante-ob.php');	
include_once(ADELANTE_INCLUDES.'adelante-cleanup.php');
include_once(ADELANTE_INCLUDES.'adelante-htaccess.php');
include_once(ADELANTE_INCLUDES.'adelante-shortcodes.php');   
include_once(ADELANTE_INCLUDES.'admin/admin-shortcodes.php');

// Load custom post types
include_once(ADELANTE_INCLUDES.'admin/admin-portfolio.php');
include_once(ADELANTE_INCLUDES.'admin/admin-slider.php');

// Load widgets
$widgets = adelante_load_files( ADELANTE_WIDGETS, array("php"), false );
foreach ( $widgets as $widget ) {
    require_once (ADELANTE_WIDGETS. $widget. ".php");
    register_widget( "adelante_widget_$widget" );
}

// Load plugins
include_once( ADELANTE_PLUGINS. 'wp-pagenavi.php' );
include_once( ADELANTE_PLUGINS. 'syntaxhighlighter/syntaxhighlighter.php' );

// Set the value of the main container class depending on the selected grid framework
$adelante_css_framework = get_option('adelante_css_framework');
if (!defined('adelante_container_class')) {
	switch ($adelante_css_framework) {
		case 'blueprint':
			define('adelante_container_class', 'span-24');
		case '960gs_12':
			define('adelante_container_class', 'container_12');
		case '960gs_16':
			define('adelante_container_class', 'container_16');
		case '960gs_24':
			define('adelante_container_class', 'container_24');
		case '1140':
			define('adelante_container_class', 'container');
		default:
			define('adelante_container_class', '');
	}
}

// Load all stylesheets
function get_adelante_stylesheets() 
{
    $css_uri = get_template_directory_uri();
    $adelante_theme = get_option( "adelante_theme" );
    $adelante_css_framework = get_option('adelante_css_framework');
    $styles = '';
    
    $themes = adelante_load_files( ADELANTE_STYLESHEET, array( "css" ), false );
    if ( isset ( $_GET['theme'] ) && in_array( $_GET['theme'], $themes ) ) {
        update_option("adelante_theme", $_GET['theme']);
        $adelante_theme = $_GET['theme'];    
    }
    
	if ( $adelante_css_framework === 'blueprint' ) {
		$styles .= "<link rel=\"stylesheet\" href=\"$css_uri/css/blueprint/screen.css\">\n";
	} 
    elseif ( $adelante_css_framework === '960gs_12' || $adelante_css_framework === '960gs_16' ) {
		$styles .= "<link rel=\"stylesheet\" href=\"$css_uri/css/960/reset.css\">\n";
		$styles .= "\t<link rel=\"stylesheet\" href=\"$css_uri/css/960/text.css\">\n";
		$styles .= "\t<link rel=\"stylesheet\" href=\"$css_uri/css/960/960.css\">\n";
	} 
    elseif ( $adelante_css_framework === '960gs_24' ) {
		$styles .= "<link rel=\"stylesheet\" href=\"$css_uri/css/960/reset.css\">\n";
		$styles .= "\t<link rel=\"stylesheet\" href=\"$css_uri/css/960/text.css\">\n";
		$styles .= "\t<link rel=\"stylesheet\" href=\"$css_uri/css/960/960_24_col.css\">\n";
	} 
    elseif ( $adelante_css_framework === '1140' ) {
		$styles .= "<link rel=\"stylesheet\" href=\"$css_uri/css/1140/1140.css\">\n";
	}

	if (class_exists('RGForms')) {
		$styles .= "\t<link rel=\"stylesheet\" href=\"" . plugins_url(). "/gravityforms/css/forms.css\">\n";
	}
    
    $styles .= "\t<link rel=\"stylesheet\" href=\"$css_uri/css/styles/main.css\">\n";
    $styles .= "\t<link rel=\"stylesheet\" href=\"$css_uri/css/styles/$adelante_theme.css\">\n";
    $styles .= "\t<link rel=\"stylesheet\" href=\"". ADELANTE_BASE_URI. "/js/prettyphoto/css/prettyPhoto.css\">\n";
    
	if ( $adelante_css_framework === 'blueprint' ) {
		$styles .= "\t<!--[if lt IE 8]><link rel=\"stylesheet\" href=\"$css_uri/css/blueprint/ie.css\"><![endif]-->\n";
	} 
    elseif ( $adelante_css_framework === '1140' ) {
		$styles .= "\t<!--[if lt IE 8]><link rel=\"stylesheet\" href=\"$css_uri/css/1140/ie.css\"><![endif]-->\n";
	}

	return $styles;
}
	
// Set the maximum 'Large' image width to the maximum grid width
if ( ! isset( $content_width ) ) {
    switch ( $adelante_css_framework ) {
        case 'blueprint' :
	        $content_width = 950;
        case '960gs_12' :
	        $content_width = 940;
        case '960gs_16' :
	        $content_width = 940;
        case '960gs_24' :
	        $content_width = 940;
        case '1140' :
	        $content_width = 1140;
        default :
	        $content_width = 950;
    }
}
// tell the TinyMCE editor to use editor-style.css
// if you have issues with getting the editor to show your changes then use the following line:
// add_editor_style('editor-style.css?' . time());
//add_editor_style('editor-style.css');

add_theme_support('post-thumbnails');

// http://codex.wordpress.org/Post_Formats
// add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

add_theme_support( 'automatic-feed-links' );

add_theme_support('menus');
register_nav_menus(
	array(
	  'primary_navigation' => 'Primary Navigation',
	  //'utility_navigation' => 'Utility Navigation'
	)
);

// remove container from menus
function adelante_nav_menu_args($args = '')
{
	$args['container'] = false;
	return $args;
}
add_filter('wp_nav_menu_args', 'adelante_nav_menu_args');

// create widget areas: homepage, sidebar, footer
$sidebars = array(
    'Homepage',
    'Sidebar', 
    'Footer Column #1', 
    'Footer Column #2', 
    'Footer Column #3', 
    'Footer Column #4', 
    'Footer Column #5'
);
foreach ($sidebars as $sidebar) {
	register_sidebar(array('name'=> $sidebar,
		'before_widget' => '<article id="%1$s" class="widget %2$s"><div class="inner">',
		'after_widget' => '</div></article>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

function set_javascript_globals()
{              
?>
    <script>
         /* <![CDATA[ */
            var adelante_globals = {
                elemsToBlur: [<?php echo get_option("adelante_theme_blur"); ?>],
                elemsToCufon: [<?php echo get_option("adelante_theme_cufon"); ?>],
                elemsToToggle: [<?php echo get_option("adelante_theme_toggle"); ?>],
                elemsToPreload: [<?php echo get_option("adelante_theme_preload"); ?>],
                slider_fx: '<?php echo get_option("adelante_slider_effects"); ?>',
                slider_timeout: <?php echo get_option("adelante_slider_timeout"); ?>,
                slider_speed: <?php echo get_option("adelante_slider_speed"); ?>  
            }
         /* ]]> */                                        
    </script>
<?php
} 

// add to robots.txt
// http://codex.wordpress.org/Search_Engine_Optimization_for_WordPress#Robots.txt_Optimization
add_action('do_robots', 'adelante_robots');
function adelante_robots() 
{
	echo "Disallow: /cgi-bin\n";
	echo "Disallow: /wp-admin\n";
	echo "Disallow: /wp-includes\n";
	echo "Disallow: /wp-content/plugins\n";
	echo "Disallow: /plugins\n";
	echo "Disallow: /wp-content/cache\n";
	echo "Disallow: /wp-content/themes\n";
	echo "Disallow: /trackback\n";
	echo "Disallow: /feed\n";
	echo "Disallow: /comments\n";
	echo "Disallow: /category/*/*\n";
	echo "Disallow: */trackback\n";
	echo "Disallow: */feed\n";
	echo "Disallow: */comments\n";
	echo "Disallow: /*?*\n";
	echo "Disallow: /*?\n";
	echo "Allow: /wp-content/uploads\n";
	echo "Allow: /assets";
}

// Maintenance Mode
function adelante_maintenance_mode() 
{
    if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
        $img = ADELANTE_BASE_URI.'/img/admin-tools.png';
        $header = "<h1>Oh Oh, Maintenance</h1>";
        $text = "<p>We are currently undergoing maintenance.<br/>Please come back soon.</p>";
        
        wp_die("<div style=\"position:relative;\"><img style=\"position:absolute; top:-60px; right:10px;\" src=$img height=100 width=100 />$header$text</div>");
    }
}
//add_action('get_header', 'adelante_maintenance_mode');
remove_action('get_header', 'adelante_maintenance_mode');