<?php

/**
 * COLUMNS
 * Shortcode which creates columns for better content separation 
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @param string $shortcodename the shortcode found, when == callback name
 * @return string $output returns the modified html string 
 */
if ( ! function_exists( 'adelante_column' ) ) 
{
	function adelante_column( $atts, $content = "", $shortcodename = "")
	{	
		$pos = '';
		if ( isset( $atts[0] ) && trim($atts[0] ) == 'first' )  $pos = 'first';
        if ( isset( $atts[0] ) && trim($atts[0] ) == 'last' )  $pos = 'last';
        
		$output  = '<div class="'. $shortcodename. ' '. $pos. '">';
		$output .=  adelante_remove_autop( $content );
		$output .= '</div>';
			
		return $output;
	}
	add_shortcode('one_third'	, 'adelante_column');
	add_shortcode('two_third'	, 'adelante_column');
	add_shortcode('one_fourth'	, 'adelante_column');
	add_shortcode('three_fourth', 'adelante_column');
	add_shortcode('one_half'	, 'adelante_column');
	add_shortcode('one_fifth'	, 'adelante_column');
	add_shortcode('two_fifth'	, 'adelante_column');
	add_shortcode('three_fifth'	, 'adelante_column');
	add_shortcode('four_fifth'	, 'adelante_column');
}

/**
 * HORIZONTAL RULERS
 * Creates a horizontal ruler that provides whitespace for the layout and helps with content separation
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @param string $shortcodename the shortcode found, when == callback name
 * @return string $output returns the modified html string 
 */
if ( ! function_exists( 'adelante_hr' ) ) 
{
	function adelante_hr( $atts, $content = "", $shortcodename = "" )
	{	
		$top = '';
		if ( isset( $atts[0] ) && trim( $atts[0] ) == 'top' )  $top = 'top';
	
		$output = '<div class="'. $shortcodename. '">';
		if ( $top == 'top' ) $output .= '<a href="#top" class="scrollTop">top</a>';
		$output .= '</div>';	
	
		return $output;
	}
	add_shortcode( 'hr', 'adelante_hr' );
}

/**
 * DROPCAPS
 * Empahize the first character of a paragraph or string with the dropcaps shortcode
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @param string $shortcodename the shortcode found, when == callback name
 * @return string $output returns the modified html string 
 */
if(!function_exists('adelante_dropcaps')) 
{
	function adelante_dropcaps($atts, $content = "", $shortcodename = "")
	{	
		// this is a fix that solves the false paragraph removal by wordpress if the dropcaps shortcode is used at the beginning of the content of single posts/pages
		global $post, $adelante_add_p;
		
		$add_p = "";
		if ( isset( $post->post_content ) && strpos( $post->post_content, '[dropcap') === 0 && $adelante_add_p == false && is_singular() )
		{
			$add_p = "<p>";
			$adelante_add_p = true;
		}		
		// this is the actual shortcode
		$output  = $add_p. '<span class="'. $shortcodename. '">';
		$output .= $content;
		$output .= '</span>';	
			
		return $output;
	}	
	add_shortcode('dropcap1', 'adelante_dropcaps');
	add_shortcode('dropcap2', 'adelante_dropcaps');
}

if ( ! function_exists( 'adelante_toggle_container' ) ) 
{
	function adelante_toggle_container( $atts, $content = null )
	{	
		extract( shortcode_atts( array(
            'keep_open' => 'false', 
            'initial_open' => '' 
        ), $atts ) );

		$addClass = '';
		if ( $keep_open == 'false' ) 
            $addClass = 'toggle_close_all ';
		if ( is_numeric( $initial_open ) ) 
            $addClass .= 'toggle_initial_open toggle_initial_open__'. $initial_open;
	
		$output  = '<div class="togglecontainer '. $addClass. '">'. "\n";
	 	$output .= adelante_remove_autop( $content ). "\n";
		$output .= '</div>'. "\n";
		
		return $output;
	}
	add_shortcode('toggle_container', 'adelante_toggle_container');
}

/**
 * QUOTES
 * This shortcode creates blockquote elements with different styles
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @param string $shortcodename the shortcode found, when == callback name
 * @return string $output returns the modified html string 
 */
if( ! function_exists( 'adelante_quote' ) ) 
{
	function adelante_quote( $atts, $content=null, $shortcodename ="" )
	{	
		extract(shortcode_atts(array(	'style' => '', 'float' => ''), $atts));
		
		if($float) $float = ' pullquote_'.$float;
		if($style) $style = ' pullquote_'.$style;
		
		// add blockquotes to the content
		$output  = '<blockquote class="pullquote'.$style.$float.'">';
		$output .= wpautop( adelante_remove_autop( $content ) );
		$output .= '</blockquote>';
		
		return $output;
	}	
	add_shortcode( 'quote', 'adelante_quote' );
}

/**
 * WIDGET
 * This shortcode creates a widget shortcode that creates widgets within the content area
 *
 * @param array $atts array of attributes
 * @return string $output returns the modified html string 
 */
function adelante_widget( $atts ) 
{    
    global $wp_widget_factory;
    
    extract(shortcode_atts(array(
        'widget_name' => FALSE,
        'widget_class_name' => FALSE
    ), $atts));
   
   	
   	foreach( $atts as $key => $value )
   	{
   		$instance[$key] = $value;
   	}
       
    $id = $widget_class_name;
    
    $widget_name = esc_html( $widget_name );
    
    if ( ! is_a( $wp_widget_factory->widgets[$widget_name], 'WP_Widget' ) ):
        $wp_class = 'WP_Widget_'. ucwords( strtolower( $class ) );
        
        if ( ! is_a( $wp_widget_factory->widgets[$wp_class], 'WP_Widget' ) ):
            return '<p>'. sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    
    ob_start();
    the_widget( $widget_name, $instance, array( 'widget_id' => 'arbitrary-instance-'. $id,
        'before_widget' => '<div class="widget '. $widget_class_name. '">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));
    $output = ob_get_contents() ;
    ob_end_clean();
    return $output;
    
}
add_shortcode( 'widget', 'adelante_widget' ); 

/**
 * IconBox
 * This shortcode creates a div with icon heading + text
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @param string $shortcodename the shortcode found, when == callback name
 * @return string $output returns the modified html string 
 */
if ( ! function_exists( 'adelante_iconbox' ) )
{
	function adelante_iconbox( $atts, $content = null )
	{	
		extract( shortcode_atts( array( 
            'title' => '', 
            'icon' => '' 
        ), $atts ) );

		if ( ! empty( $icon ) && strpos( '/', $icon ) === false ) {
            $icon = ADELANTE_BASE_URI . '/img/icons/iconbox/'. $icon;
        }		
		if ( ! empty( $icon ) ) {
            $icon = "<img src='$icon' alt='' />";
        }

		return '<div class="iconbox"><div class="iconbox_icon">'. $icon. '</div><div class="iconbox_content"><h3 class="iconbox_content_title">'. $title. "</h3>". wpautop( adelante_remove_autop( $content ) ). '</div></div>';
	}
	add_shortcode( 'iconbox', 'adelante_iconbox' );
			
}

if ( ! function_exists( 'adelante_togglebox' ) )
{
    function adelante_togglebox( $atts, $content = null )
    {    
        extract( shortcode_atts( array( 
            'title' => '', 
            'class' => '' 
        ), $atts ) );

        return '<h4 class="togglebox_title '.$class.'"><a href="#">'.$title.'</a></h4><div class="togglebox_content">'. wpautop( adelante_remove_autop( $content ) ). '</div>';
    }
    add_shortcode( 'togglebox', 'adelante_togglebox' );
}

/**
 * Buttons
 * The button shortcode enables you to place fully styled buttons on the page with a simple shortcode
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @return string $output returns the modified html string 
 * 
 *
 *	Optional arguments:
 *	 - size: small, large
 *	 - style: info, alert, tick, download, note
 *	 - color: red, green, black, grey OR custom hex color (e.g #000000)
 *	 - border: border color (e.g. red or #000000)
 *	 - text: black (for light color background on button) 
 *	 - class: custom class
 *	 - link: button link (e.g http://www.google.de)
 *	 - window: true/false
 *	 
 */ 
if ( ! function_exists( 'adelante_button' ) ) 
{
	function adelante_button( $atts, $content = null ) 
    {
	   	extract( shortcode_atts( array(	
            'size' => '',
	   		'style' => '',
	   		'color' => '',   									
	   		'border' => '',   									
	   		'text' => '',   									
	   		'class' => '',
	   		'link' => '#',
	   		'window' => '' 
        ), $atts ) );
	
	   	// Set custom background and border color
	   	$color_output = '';
	   	if ( $color ) 
        {	   	
	   	    if ( $color == "red" OR 
                 $color == "orange" OR
                 $color == "green" OR
                 $color == "aqua" OR
                 $color == "teal" OR
                 $color == "purple" OR
                 $color == "pink" OR
                 $color == "silver") 
            {
		   		$class .= " ". $color;
	   		} 
            else 
            {
			   	if ( $border ) 
			   		$border_out = $border;
			   	else
			   		$border_out = $color;			   		
		   		
                $color_output = 'style="background-color:'. $color. ';border-color:'. $border_out. '"';		   		
		   		$class .= " custom";
	   		}
	   	}
        	
		$class_output = '';	
        
		if ( $text ) 
            $class_output .= ' '. $text;	
		if ( $class ) 
            $class_output .= ' '. $class;	
		if ( $size ) 
            $class_output .= ' '. $size;		
		if ( $window ) 
            $window = 'target="_blank" ';			   	
	   	
        $output = '<a '. $window. 'href="'. $link. '" class="adelante-button '. $class_output. '" '. $color_output. '><span class="adelante-'. $style. '">'. adelante_remove_autop( $content ). '</span></a>';
	   	
        return $output;
	}
	add_shortcode('button', 'adelante_button');
}

/**
 * ICONLINKS
 * The button shortcode enables you to place fully styled buttons on the page with a simple shortcode
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @return string $output returns the modified html string 
 * 
 *
 * Optional arguments:
 *  - style: download, note, tick, info, alert
 *  - url: the url for your link 
 *  - icon: add an url to a custom icon
 */
if ( ! function_exists( "adelante_iconlink" ) ) 
{
	function adelante_iconlink($atts, $content = null) 
	{
	   	extract(shortcode_atts(array( 'style' => 'info', 'url' => '', 'icon' => ''), $atts));  
	   	
	   	$custom_icon = '';
	   	if ( $icon ) 
            $custom_icon = 'style="background:url('.$icon.') no-repeat left 40%;"'; 
	
	   return '<span class="adelante-ilink"><a class="'. $style. '" href="'. $url. '" '. $custom_icon. '>'. adelante_remove_autop( $content ). '</a></span>';
	}
	
	add_shortcode('iconlink', 'adelante_iconlink');
}

/**
 * INFOBOXES
 * The button shortcode enables you to place fully styled buttons on the page with a simple shortcode
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @return string $output returns the modified html string 
 * 
 *
 * Optional arguments:
 *  - type: all files in img/icons folder
 *  - size: medium, large
 *  - style: rounded
 *  - border: none, full
 *  - icon: none OR full URL to a custom icon 
*/
if ( ! function_exists( "adelante_infobox" ) ) 
{
	function adelante_infobox( $atts, $content = null ) 
	{
        extract( shortcode_atts( array(	
            'type' => 'none',
	        'size' => '',
            'color' => '#666',
            'bgcolor' => '#f3f3f3',
            'bordercolor' => '#d1d1d1',
	        'style' => '',
	        'border' => 'full'
        ), $atts ) ); 
	   	
	   	$custom = $custom_class = '';								
	  	
	  	if ( $type == "none") {
            $custom = ' style="background-image:none;"'; 
            $custom_class = 'custom_icon_none'; 
        }
		 										
	   	return '<div style="background-color: '. $bgcolor. '; color: '. $color. ';border-color: '. $bordercolor. ';" class="clearboth adelante-box '. $type. ' '. $size. ' '. $custom_class. ' '. $style. ' '. $border. '"><span class="adelante-innerbox" '. $custom.'>'. adelante_remove_autop($content). '</span></div>';
	}
	add_shortcode('infobox', 'adelante_infobox');
}

/**
 * INFOBOXES
 * The button shortcode enables you to place fully styled buttons on the page with a simple shortcode
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @return string $output returns the modified html string 
 * 
 *
 * Optional arguments:
 *  - type: all files in img/icons folder
 *  - size: medium, large
 *  - style: rounded
 *  - border: none, full
 *  - icon: none OR full URL to a custom icon 
*/
if ( ! function_exists( "adelante_sproutebox" ) ) 
{
    function adelante_sproutebox( $atts, $content = null ) 
    {
        extract( shortcode_atts( array(    
            'type' => 'info',
            'title' => ''
        ), $atts ) ); 
        
        $output .= '<div class="sproutebox '. $type. '">';
        $output .= ! empty( $title ) ? '<div class="title">'. $title. '</div>' : '';
        $output .= '<div>'. adelante_remove_autop( $content ). '</div>';
        $output .= '</div>';                                   
        
        return $output;
    }
    add_shortcode('sproutebox', 'adelante_sproutebox');
}

/**
* Imagebox
* This shortcode 
* 
* @param array $atts array of attributes
* @return string $output returns an html string
* 
* Optional arguments:
*  - num: number of words to be returned
*  - elem: element that will act as a wrapper around the returned content 
*/
if ( ! function_exists( "adelante_imagebox" ) ) 
{
    function adelante_imagebox( $atts, $content = null )
    {
        extract( shortcode_atts( array(    
            'image_title' => '',
            'image_src' => '#',
            'header' => '',
            'button_caption' => '',
            'button_href' => '#',
            'button_class' => '',
            'target' => '_blank'        
        ), $atts ) );
            
        return '<div class="imagebox"><figure class="imagebox_icon"><img src="'.adelante_image_resize(146, 90, $image_src).'" alt="'. $image_title. '" /></figure><h3 class="imagebox_content_title">'. $header. '</h3><div class="imagebox_content">'. wpautop( adelante_remove_autop( $content ) ). '</div><a class="imagebox-button adelante-button '.$button_class.'" href="'. $button_href. '" target="'.$target.'">'. $button_caption. '</a></div>';
    }
    add_shortcode('imagebox', 'adelante_imagebox');       
}

if ( ! function_exists( "adelante_widgetbox" ) ) 
{
    function adelante_widgetbox( $atts, $content = null )
    {
        extract( shortcode_atts( array(    
            'title' => '',
            'icon' => ''       
        ), $atts ) );
        
        if ($icon == "none") { $img = ""; }
        else { $img = '<img class="icon" src="'.adelante_image_resize(40, 40, ADELANTE_BASE_URI . '/img/icons/iconbox/'. $icon).'" alt="" />';}
            
        return '<article class="widgetbox"><div class="inner"><h3>'. $title. $img. '</h3><div>'. do_shortcode($content). '</div></div></article>';
    }
    add_shortcode('widgetbox', 'adelante_widgetbox');       
}

/**
 * Lorem Ipsum
 * This shortcode enables you to place some random text on your page
 *
 * @param array $atts array of attributes
 * @return string $output returns an html string 
 * 
 * Optional arguments:
 *  - num: number of words to be returned
 *  - elem: element that will act as a wrapper around the returned content 
*/
if ( ! function_exists( "adelante_lorem" ) ) 
{
    function adelante_lorem( $atts ) 
    {
        extract( shortcode_atts( array(
              'num' => '0',
              'elem' => 'p'
        ), $atts ) );    
        
        $s = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum leo velit, sollicitudin in tristique nec, tempor imperdiet ipsum. Vestibulum a purus arcu. Mauris ac diam a ipsum ullamcorper porttitor. Aliquam hendrerit dolor vitae orci malesuada fringilla. Mauris eu lectus odio. Nam ligula dolor, auctor et pharetra sed, placerat at urna. Fusce interdum congue elit, non vulputate ligula rhoncus vitae. In eget sapien vestibulum odio convallis commodo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed molestie erat at augue elementum adipiscing. Aliquam adipiscing ante vitae augue mollis facilisis. Nullam facilisis leo vitae lectus hendrerit vel vulputate nibh sagittis. Mauris non tellus nunc. Sed a enim enim, non porttitor leo.';
        
        if ( $num == 0 ) {
            return '<'. $elem. ' class="lorem">'. $s. '</'. $elem. '>';    
        } 
        if ( $num > 0 ) {
            $arrTemp = explode(' ', $s, $num + 1);
            array_pop( $arrTemp );
            $out = implode( ' ', $arrTemp );
            return '<'. $elem. ' class="lorem">'. $out. '...</'. $elem. '>';    
        }    
    }
    add_shortcode( 'lorem', 'adelante_lorem' );    
}

/**
 * Private Content
 * This shortcode shows or hides a piece of your page based on your privileges
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element 
 * @return string $output returns the modified html string 
 *
 * Optional arguments:
 *  - elem: element that will act as a wrapper around the returned content
 *  - class: custom class to add to the provided element
*/
if ( ! function_exists( "adelante_private_content" )) 
{
    function adelante_private_content( $atts, $content = null ) 
    {    
        extract( shortcode_atts( array(
            'capability' => 'edit_posts',
            'elem' => 'div',
            'class' => '',        
        ), $atts));
        
        if ( current_user_can( $capability ) )
            return '<'. $elem. ' class="private-content '. $class. '">' . adelante_remove_autop( $content ) . '</'. $elem. '>';
        return '';
    }
    add_shortcode('private', 'adelante_private_content');
}

/**
 * Google Maps
 * This shortcode shows an image of the provided location
 *
 * @param array $atts array of attributes
 * @return string $output returns the modified html string 
 *
 * Optional arguments:
 *  - center: element that will act as a wrapper around the returned content
 *  - size: custom class to add to the provided element
 *  - maptype: custom class to add to the provided element
 *  - markers: custom class to add to the provided element
 *  - sensor: custom class to add to the provided element
 *  - zoom: custom class to add to the provided element
 *  - style: custom class to add to the provided element
*/
if ( ! function_exists( "adelante_google_map" )) 
{
    function adelante_google_map( $atts ) 
    {
        extract( shortcode_atts( array(
            'center' => '',
            'size' => '580x400',
            'maptype' => 'hybrid',
            'sensor' => 'false',
            'zoom' => '15'
        ), $atts ) );

        $size = explode("x", $size);
        $center = urlencode( $center ); 
        $rnd = rand(0, 99999);   
        ob_start(); 
?>        
        <script src="http://maps.google.com/maps/api/js?sensor=<?php echo $sensor; ?>"></script><script src="<?php echo ADELANTE_JS_URI. "gmap3.min.js"; ?>"></script><div id="gmap1-<?php echo $rnd; ?>" style="width: <?php echo $size[0]; ?>px; height: <?php echo $size[1]; ?>px;"></div><script>$(function(){$('#gmap1-<?php echo $rnd; ?>').gmap3({action: 'addMarker',address: "<?php echo $center; ?>",map:{center: true,zoom: <?php echo $zoom; ?>,mapTypeId: google.maps.MapTypeId.<?php echo strtoupper($maptype); ?>}});});</script>
<?php
        $output = ob_get_contents(); ob_end_clean();        
        return adelante_remove_autop( $output );
    }
    add_shortcode('map', 'adelante_google_map');    
}

//
if ( ! function_exists( "adelante_tooltip" ) )
{
    function adelante_tooltip( $atts, $content = null )
    {
        extract( shortcode_atts( array(
            'tiptext' => ''
        ), $atts ) );
        
        return '<a class="hastip" title="'. $tiptext. '">'. adelante_remove_autop( $content ). '</a>';
    } 
    add_shortcode('tooltip', 'adelante_tooltip');   
}

// 
if ( ! function_exists( "adelante_lightbox" )) 
{
    function adelante_lightbox( $atts, $content = null  ) 
    {
        extract( shortcode_atts( array(
            'type' => 'image',
            'theme' => 'dark_rounded',
            'link' => '#',
            'title' => '',
            'description' => '',
            'height' => '',
            'width' => '',
            'flashvars' => ''  
        ), $atts ) );

        $output = '';
        $id = rand(0, 99999);
        
        switch( $type ) {
            case "ajax":
                $output .= '<a id="pp-'.$id.'" href="'.$link.'?ajax=true&width='.$width.'&height='.$width.'" rel="prettyPhoto" alt="'. 
                            $title. '" title="'.$description.'">'.adelante_remove_autop( $content ).'</a>';
                break;
            case "image":
                $output .= '<a id="pp-'.$id.'" href="'.$link.'?width='.$width.'&amp;height='.$height.'" rel="prettyPhoto" alt="'. 
                            $title. '" title="'.$description.'">'.adelante_remove_autop( $content ).'</a>';
                break;
            case "external":
                $output .= '<a id="pp-'.$id.'" href="'.$link.'?iframe=true&width='.$width.'&height='.$height.'" rel="prettyPhoto" alt="'. 
                            $title. '" title="'.$description.'">'.adelante_remove_autop( $content ).'</a>';
                break;
            case "inline":
                $output .= '<a id="pp-'.$id.'" href="'.$link.'" rel="prettyPhoto" alt="'. $title. '" title="'.$description.'">'.adelante_remove_autop( $content ).'</a>';
                break;                                                                                                               
            default:
                $output .= '<a id="pp-'.$id.'" href="'.$link.'?width='.$width.'&amp;height='.$height.'" rel="prettyPhoto" alt="'. 
                            $title. '" title="'.$description.'">'.adelante_remove_autop( $content ).'</a>';
                break;
        }   

        $output .= '<script>';
        $output .= "$('#pp-$id').prettyPhoto({theme:'".$theme."'});";               
        $output .= '</script>';
                
        return $output;
    }
    add_shortcode('lightbox', 'adelante_lightbox');    
}

/**
*  Create a video shortcode based on several input parameters
* 
*  
*/
if ( ! function_exists( "adelante_video" ) )
{
    function adelante_video( $atts )
    {
        if ( isset( $atts['type'] ) )
        {
            switch( $atts['type'] )
            {
                case 'html5':
                    return video_html5( $atts );
                    break;
                    
                case 'flash':
                    return video_flash( $atts );
                    break;
                    
                case 'youtube':
                    return video_youtube( $atts );
                    break;
                    
                case 'vimeo':
                    return video_vimeo( $atts );
                    break;
                    
                case 'dailymotion':
                    return video_dailymotion( $atts );
                    break;
                    
                case 'hulu':
                    return video_hulu( $atts );
                    break;
                    
                case 'viddler':
                    return video_viddler( $atts );
                    break;
            }
        }
        return '';
    }
    add_shortcode( 'video', 'adelante_video' );
}

function video_html5( $atts )
{
    extract( shortcode_atts( array(
        'mp4' => '',
        'webm' => '',
        'ogg' => '',
        'width' => 580,
        'height' => 318,
        'preload' => false,
        'autoplay' => false,
    ), $atts ) );

    if ( $height && ! $width ) 
        $width = intval( $height * 16 / 9 );
    if ( ! $height && $width ) 
        $height = intval( $width * 9 / 16 );

    // MP4 Source
    if ($mp4) 
    {
        $mp4_source = '<source src="'.$mp4.'" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'>';
        $mp4_link = '<a href="'.$mp4.'">MP4</a>';
    }
    // WebM Source
    if ($webm) 
    {
        $webm_source = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\'>';
        $webm_link = '<a href="'.$webm.'">WebM</a>';
    }
    // Ogg Source
    if ($ogg) 
    {
        $ogg_source = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\'>';
        $ogg_link = '<a href="'.$ogg.'">Ogg</a>';
    }
    if ($preload) 
    {
        $preload_attribute = 'preload="auto"';
        $flow_player_preload = ',"autoBuffering":true';
    } 
    else 
    {
        $preload_attribute = 'preload="none"';
        $flow_player_preload = ',"autoBuffering":false';
    }
    if ($autoplay) 
    {
        $autoplay_attribute = "autoplay";
        $flow_player_autoplay = ',"autoPlay":true';
    } 
    else 
    {
        $autoplay_attribute = "";
        $flow_player_autoplay = ',"autoPlay":false';
    }
    $uri = ADELANTE_BASE_URI;

    $output = <<<HTML
<div class="video_frame video-js-box">
    <video class="video-js" width="{$width}" height="{$height}" {$poster_attribute} controls {$preload_attribute} {$autoplay_attribute}>
        {$mp4_source}
        {$webm_source}
        {$ogg_source}
        <object class="vjs-flash-fallback" width="{$width}" height="{$height}" type="application/x-shockwave-flash"
            data="http://releases.flowplayer.org/swf/flowplayer-3.2.5.swf">
            <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.5.swf" />
            <param name="allowfullscreen" value="true" />
            <param name="wmode" value="opaque" />
            <param name="flashvars" value='config={"clip":{"url":"$mp4" $flow_player_autoplay $flow_player_preload ,"wmode":"opaque"}}' />
            {$image_fallback}
        </object>
    </video>
    <p class="vjs-no-video"><strong>Download Video:</strong>
        {$mp4_link}
        {$webm_link}
        {$ogg_link}
    </p>
</div>
HTML;

    return '[raw]'. $output. '[/raw]';
}

function video_flash( $atts ) 
{
    extract( shortcode_atts( array(
        'src' => '',
        'width' => 318,
        'height' => 580,
        'play' => 'false',
        'flashvars' => '',
    ), $atts ) );
    
    if ( $height && ! $width ) 
        $width = intval( $height * 16 / 9 );
    if ( ! $height && $width ) 
        $height = intval( $width * 9 / 16 );

    $uri = ADELANTE_BASE_URI;
    if ( ! empty( $src ) )
    {
        return <<<HTML
<div class="video_frame">
<object width="$width" height="$height" type="application/x-shockwave-flash" data="{$src}">
    <param name="movie" value="$src" />
    <param name="allowFullScreen" value="true" />
    <param name="allowscriptaccess" value="always" />
    <param name="expressInstaller" value="$uri/swf/expressInstall.swf"/>
    <param name="play" value="$play"/>
    <param name="wmode" value="opaque" />
    <embed src="$src" type="application/x-shockwave-flash" wmode="opaque" allowscriptaccess="always" allowfullscreen="true" width="{$width}" height="{$height}" />
</object>
</div>
HTML;
    }
}

function video_vimeo($atts) 
{
    extract( shortcode_atts( array(
        'clip_id' => '',
        'width' => 580,
        'height' => 318,
        'title' => 'false',
    ), $atts ) );

    if ( $height && ! $width ) 
        $width = intval( $height * 16 / 9 );
    if ( ! $height && $width ) 
        $height = intval( $width * 9 / 16 );
    
    if ( $title != 'false' )
    {
        $title = 1;
    }
    else
    {
        $title = 0;
    }

    if ( ! empty( $clip_id ) && is_numeric( $clip_id ) )
    {
        return <<<HTML
<div class='video_frame'>
    <iframe src='http://player.vimeo.com/video/$clip_id?title=$title&amp;byline=0&amp;portrait=0' width='$width' height='$height' frameborder='0'></iframe>
</div>
HTML;
    }
}

function video_youtube( $atts ) 
{
    extract( shortcode_atts( array(
        'clip_id' => '',
        'width' => 580,
        'height' => 318,
    ), $atts));
    
    if ( $height && ! $width ) 
        $width = intval( $height * 16 / 9 );
    if ( ! $height && $width ) 
        $height = intval( $width * 9 / 16 );
    
    if ( ! empty( $clip_id )  )
    {
        return <<<HTML
<div class='video_frame'>
    <iframe src='http://www.youtube.com/embed/$clip_id' width='$width' height='$height' frameborder='0'></iframe>
</div>
HTML;
    }
}

function video_dailymotion( $atts ) 
{
    extract( shortcode_atts( array(
        'clip_id' => '',
        'width' => false,
        'height' => false,
    ), $atts ) );
    
    if ( $height && ! $width ) 
        $width = intval( $height * 16 / 9 );
    if ( ! $height && $width ) 
        $height = intval( $width * 9 / 16 );
    if ( !$height && ! $width )
    {
        $height = 318;
        $width = 580;
    }

    if ( ! empty( $clip_id ) )
    {
        return <<<HTML
<div class='video_frame'>
    <iframe src=http://www.dailymotion.com/embed/video/$clip_id?width=$width&theme=none&foreground=%23F7FFFD&highlight=%23FFC300&background=%23171D1B&start=&animatedTitle=&iframe=1&additionalInfos=0&autoPlay=0&hideInfos=0' width='$width' height='$height' frameborder='0'></iframe>
</div>
HTML;
    }
}                              

function video_hulu( $atts )
{
    extract( shortcode_atts( array(
        'clip_id' => '',
        'width' => 318,
        'height' => 580,
        'flashvars' => 'ap=1',
    ), $atts ) );
    
    if ( $height && ! $width ) 
        $width = intval( $height * 16 / 9 );
    if ( ! $height && $width ) 
        $height = intval( $width * 9 / 16 );

    if ( ! empty( $clip_id ) )
    {
        return <<<HTML
<div class="video_frame">
    <object width="$width" height="$height">
        <param name="movie" value="http://www.hulu.com/embed/$clip_id"/>
        <param name="flashvars" value="$flashvars"/>
        <embed src="http://www.hulu.com/embed/$clip_id" type="application/x-shockwave-flash" width="$width" height="$height" flashvars="$flashvars" />
    </object>
</div>
HTML;
    }    
}

function video_viddler( $atts )
{
    extract( shortcode_atts( array(
        'clip_id' => '',
        'width' => 318,
        'height' => 580
    ), $atts ) );
    
    if ( $height && ! $width ) 
        $width = intval( $height * 16 / 9 );
    if ( ! $height && $width ) 
        $height = intval( $width * 9 / 16 );

    if ( ! empty( $clip_id ) )
    {
        return <<<HTML
<div class="video_frame">
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="$width" height="$height" id="viddlerplayer-$clip_id">
    <param name="movie" value="http://www.viddler.com/player/$clip_id/"/>
    <param name="allowScriptAccess" value="always"/>
    <param name="wmode" value="transparent"/>
    <param name="allowFullScreen" value="true"/>
    <embed src="http://www.viddler.com/player/$clip_id/" width="$width" height="$height" type="application/x-shockwave-flash" wmode="transparent" allowScriptAccess="always" allowFullScreen="true" name="viddlerplayer-$clip_id"/>
    </object> 
</div>
HTML;
    }    
}

if ( ! function_exists( "adelante_chart" ))
{
    function adelante_chart( $atts ) 
    {
        extract( shortcode_atts( array(
            'data' => '',
            'colors' => '',
            'size' => '400x200',
            'bg' => 'bg,s,ffffff',
            'title' => '',
            'labels' => '',
            'advanced' => '',
            'type' => 'pie'
        ), $atts ) );
     
        switch ($type) {
            case 'line' :
                $charttype = 'lc'; 
                break;
            case 'xyline' :
                $charttype = 'lxy'; 
                break;
            case 'sparkline' :
                $charttype = 'ls'; 
                break;
            case 'meter' :
                $charttype = 'gom'; 
                break;
            case 'scatter' :
                $charttype = 's'; 
                break;
            case 'venn' :
                $charttype = 'v'; 
                break;
            case 'pie' :
                $charttype = 'p3'; 
                break;
            case 'pie2d' :
                $charttype = 'p'; 
                break;
            default :
                $charttype = $type;
                break;
        }
     
        if ($title) 
            $string .= '&chtt='. $title. '';
        if ($labels) 
            $string .= '&chl='. $labels. '';
        if ($colors) 
            $string .= '&chco='. $colors. '';
            
        $string .= '&chs='. $size. '';
        $string .= '&chd=t:'. $data. '';
        $string .= '&chf='. $bg. '';
     
        return '<img title="'. $title. '" src="http://chart.apis.google.com/chart?cht='. $charttype. ''. $string. $advanced. '" alt="'. $title. '" />';
    }
    add_shortcode('chart', 'adelante_chart');    
}


if ( ! function_exists( "adelante_code" ))
{
    function adelante_code( $atts, $content = null )
    {
        extract( shortcode_atts( array(
            'theme' => 'default'
            ,'version' => 3
            ,'lang' => ''
            ,'collapse' => 0
            ,'classname' => ''
            ,'title' => ''
            ,'toolbar' => 0
            ,'wraplines' => 1
        ), $atts ) );
        
        return "[$lang theme=\"$theme\" shversion=\"$version\" collapse=\"$collapse\" classname=\"$classname\" title=\"$title\" toolbar=\"$toolbar\" wraplines=\"$wraplines\"]". adelante_remove_autop( $content ). "[/$lang]";
    } 
    add_shortcode('code', 'adelante_code');     
}


if ( ! function_exists( "adelante_blog" ))
{
    function adelante_blog( $atts, $content = null ) 
    {
        global $wp_filter;
        $the_content_filter_backup = $wp_filter['the_content'];
        extract( shortcode_atts( array(
            'count' => 3,
            'cat' => '',
            'image' => 'true',
            'meta' => 'true',
            'full' => 'false',
            'height' => 218,
            'width' => 576,
            'posttype' => 'post'
        ), $atts ) );
        
        $query = array(
            'posts_per_page' => (int)$count,
            'post_type' => $posttype,
        );
        if ( $cat )
        {
            $query['cat'] = $cat;
        }
        $query['showposts'] = $count;
            
        ob_start();
        $r = new WP_Query( $query );
        if ( $r->have_posts()):
            while ( $r->have_posts()) : $r->the_post();
    ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
                    <?php $fi_position = get_post_meta( $r->post->ID, 'featured_image_position', true ); ?>                 
                    <header>
                        <?php if ( $image == 'true' && ($fi_position == "top" || $fi_position == "" ) ) adelante_featured_image((int)$height, (int)$width); ?>
                        <h2 class="blog_header clearboth"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php if ( $meta == 'true'  ): ?><?php adelante_post_meta(); ?><?php endif; ?>                
                    </header> 
                    <div class="entry-content">
                        <?php if ( $fi_position == 'left' ) adelante_featured_image( 200, 200, null, "gallery-item alignedleft" ); ?>                        
                        <?php if ( $fi_position == 'right' ) adelante_featured_image( 200, 200, null, "gallery-item alignedright" ); ?>   
                        <?php if ( $full == 'true'  ) : ?>
                                <?php the_content('Continue&hellip;'); ?>
                        <?php else : ?>
                                <?php the_excerpt(); ?>
                        <?php endif; ?>
                    </div>                   
                </article>
    <?php
            endwhile;
        endif;
        
        $output = ob_get_contents();  
        ob_end_clean();

        wp_reset_postdata();
        $wp_filter['the_content'] = $the_content_filter_backup;
        return '[raw]'. $output. '[/raw]';
    }
    add_shortcode( 'blog', 'adelante_blog' );    
}


function my_formatter( $content ) 
{
    $new_content = '';
    $pattern_full = '{(\[raw\].*?\[/raw\])}is';
    $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
    $pieces = preg_split( $pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE );

    foreach ( $pieces as $piece ) 
    {
        if ( preg_match( $pattern_contents, $piece, $matches ) ) 
        {
            $new_content .= $matches[1];
        } 
        else 
        {
            $new_content .= wptexturize( wpautop( $piece ) );
        }
    }

    return $new_content;
}
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_content', 'wptexturize' );
add_filter( 'the_content', 'my_formatter', 99 );


/**
 * Removes wordpress autop and invalid nesting of <p> tags, as well as <br> tags
 *
 * @param string $content html content by the wordpress editor
 * @return string $content
 */
if ( ! function_exists("adelante_remove_autop" ) ) 
{
	function adelante_remove_autop( $content ) 
	{ 
		$content = do_shortcode( shortcode_unautop( $content ) ); 
		$content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);
		return $content;
	}
}

// Enable shortcodes in widget areas
add_filter('widget_text', 'do_shortcode');