<?php

/* -------------------------------------------------- 
    General helper functions 
-------------------------------------------------- */

function remove_value_from_array( &$array, $value )
{
    foreach( $array as $k => $v ){
        if ( $v == $value ) {
            unset( $array[$k] );
            $array = array_values( $array );
            return true;
        }
    }
}


/* -------------------------------------------------- 
    Theme functions 
-------------------------------------------------- */

// Get the general width of the selected framework
function get_framework_size()
{
    $adelante_css_framework = get_option('adelante_css_framework');
    switch ($adelante_css_framework) {
        case 'blueprint' :
            return 950;
        case '1140' :
            return 1140;
        default :
            return 960;
    }
}

// 
function adelante_new_excerpt_more( $excerpt ) 
{
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'adelante_new_excerpt_more');

// 
function adelante_new_comment_author_link( $return ) 
{
	return str_replace($return, "<span></span>$return", $return);
}
add_filter('get_comment_author_link', 'adelante_new_comment_author_link');

// 
function adelante_excerpt( $length, $ellipsis ) 
{
	$text = get_the_content();
	$text = preg_replace( '`\[[^\]]*\]`','', $text );
	$text = strip_tags($text);
	$text = substr( $text, 0, $length );
	$text = substr( $text, 0, strripos( $text, " " ) );
	$text = $text. $ellipsis;
	return $text;
}

// 
function adelante_truncate( $string, $limit, $break = ".", $pad = "..." ) 
{
	if ( strlen( $string ) <= $limit ) return $string;
    if ( false !== ( $breakpoint = strpos( $string, $break, $limit ) ) ) {
        if ( $breakpoint < strlen( $string ) - 1 ) {
	        $string = substr( $string, 0, $breakpoint ). $pad;
        }
    }
    return $string; 
}

// Resize an image using timthumb
function adelante_image_resize( $height, $width, $img_url ) 
{
	$image['url'] = $img_url;
	$image_path = explode($_SERVER['SERVER_NAME'], $image['url']);
	$image_path = $_SERVER['DOCUMENT_ROOT'] . $image_path[1];
	$image_info = @getimagesize($image_path);

	// If we cannot get the image locally, try for an external URL
	if ( ! $image_info )
		$image_info = @getimagesize( $image['url'] );

	$image['width'] = $image_info[0];
	$image['height'] = $image_info[1];
    $croploc = get_option('adelante_images_cropping_location');
    $filter = get_option('adelante_images_filter');
    $filter == 0 ? $filter = '' : $filter = "&f=$filter";
	if ( $img_url != "" ) {
		$img_url = ADELANTE_JS_URI."thumb.php?src=$img_url&w=$width&h=$height&a=$croploc&q=100".$filter;
	}
	
	return $img_url;
}

// Adds a transparent border around an image
function adelante_image_border( $img = null, $size = 5, $opacity = 0.1, $class = '' )
{
    $opac100 = $opacity * 100;
    $border_style = esc_attr("-ms-filter:\"progid:DXImageTransform.Microsoft.Alpha(Opacity=$opac100)\";filter:alpha(opacity=$opac100);-moz-opacity:$opacity;-khtml-opacity:$opacity;opacity:$opacity;");

    $border_top     = '<span class="frameborder '. $class. '" style="height:'. $size. 'px;left:0;right:0;top:0;'. $border_style. '"></span>';
    $border_right   = '<span class="frameborder '. $class. '" style="bottom:'. $size. 'px;right:0;top:'.$size. 'px;width:'.$size.'px;'. $border_style. '"></span>';
    $border_bottom  = '<span class="frameborder '. $class. '" style="height:'. $size. 'px;bottom:0;left:0;right:0;'. $border_style. '"></span>';
    $border_left    = '<span class="frameborder '. $class. '" style="bottom:'. $size. 'px;top:'. $size. 'px;left:0;width:'.$size.'px;'. $border_style. '"></span>';
    
    if ( empty( $img ) ) {
        echo  $border_top. $border_right. $border_bottom. $border_left;    
    }
    else {
        return $img. $border_top. $border_right. $border_bottom. $border_left;    
    }          
}    

// Determine all post types and return as array
function adelante_get_post_types( $_builtin = true, $include_post = true )
{
    $post_types = get_post_types( array( '_builtin' => $_builtin ) ); 
    if ( $include_post ) 
        $post_types['post'] = 'post';
    
    return $post_types;
}    

// Load all files of specific types and return as an array
function adelante_load_files( $folder, $ext = array(), $include_ext = true )
{    
    $files = array();        
    if ( is_dir( $folder ) ) {
        if ( $dh = opendir( $folder ) ) {
            while ( ( $file = readdir( $dh ) ) !== false ) {
                if ( '.' != $file && '..' != $file ) {    
                    $pathinfo = pathinfo( $folder. "/". $file );                       
                    if ( isset( $pathinfo['extension']) && in_array( $pathinfo['extension'], $ext ) ) {
                        $include_ext === true ? $files[] = $file : $files[] = $pathinfo['filename'];
                    }
                }
            }
            closedir($dh);
        }
    }        
    return $files;
}

// Configure teaser for current page/post
function adelante_get_teaser()
{
    global $wp_query;

    $start = '<div id="teaser"><div id="teaser-content" class="inner"><div id="teaser-inner">';
    $end = '</div></div></div><div id="teaser-shadow">&nbsp;</div>';

    // Has a Teaser setting been made at post/page level?
    $teaser_text = get_post_meta( $wp_query->queried_object_id, "teaser_text", true );
    $teaser_image = get_post_meta( $wp_query->queried_object_id, "teaser_image_custom", true );
    if($teaser_image!="") $teaser_image='<div class="teaser-image"><img src="'.$teaser_image.'" alt="teaser-image" /></div>';
    
    switch( $teaser_text ) {
        case "disabled":
            return;
        
        case "twitter":
            strlen( get_option( "adelante_twitter_username" ) ) > 0 ? 
            $output = get_option('adelante_twitter_loading_message') :
            $output = "Please specify a Twitter username <a href='". site_url(). "/wp-admin/admin.php?page=adelante#social". "'>here</a>";
            break;
        
        case "custom":
            $custom = get_post_meta( $wp_query->queried_object_id, "teaser_text_custom", true );
            if ( sizeof( $custom ) > 0) {
                $output = $custom;   
            }
            else {
                $output = get_bloginfo( 'description' );
            } 
            break;

        default:
            $adelante_teaser_text = get_option( "adelante_teaser_text" );
            switch( $adelante_teaser_text ) {
                case "twitter":
                    strlen( get_option( "adelante_twitter_username" ) ) > 0 ? 
                    $output = get_option('adelante_twitter_loading_message') :
                    $output = "Please specify a Twitter username <a href='". site_url(). "/wp-admin/admin.php?page=adelante#social". "'>here</a>";
                    break;
                case "custom":
                    $custom = get_option( 'adelante_teaser_custom_text' );
                    if ( strlen( $custom ) > 0) {
                        $output = $custom;   
                    }
                    else {
                        $output = get_bloginfo( 'description' );
                    }                         
                    break;
                case "disabled":
                    return;                        
                default:
                    $output = get_bloginfo( 'description' );
            } 
            break;
    }        

    $adelante_teaser_image = get_option("adelante_teaser_image");
    
    $out = $start;
    if($adelante_teaser_image=='left'||$adelante_teaser_image=='both') $out .= $teaser_image;            
    $out .= $output;
    if($adelante_teaser_image=='right'||$adelante_teaser_image=='both') $out .= $teaser_image;              
    $out .= $end;
    
    echo adelante_remove_autop($out);
    
    if ( $teaser_text == "twitter" || $adelante_teaser_text == "twitter" ) {
?>
        <script>
            getTwitters('teaser-content', { 
                id: '<?php echo get_option("adelante_twitter_username"); ?>', 
                count: 1, 
                enableLinks: true, 
                ignoreReplies: true, 
                clearContents: true,
                template: '<img class="twitterAvatar" src="%user_profile_image_url%" height=24 /> <span class="twitterStatus">%text%</span> <a href="http://twitter.com/%user_screen_name%/statuses/%id_str%/">%time%</a>'
            }); 
        </script>
<?php
    }        
}

// Load featured image of current post
function adelante_featured_image( $height = 218, $width = 576, $src = null, $class = "gallery-item aligncenter" )
{
    global $post;
    
    if ( $width === 576 && get_option( 'adelante_css_framework' ) === '1140' ) {
        $width = 653;    
    }
    
    if ( has_post_thumbnail( $post->ID ) ) {      
        $thumb = get_post_thumbnail_id( $post->ID ); 
        $image = wp_get_attachment_image_src( $thumb, 'full' );
        if ( $image ) {                         
?>
            <figure class="<?php echo $class; ?>" style="height: <?php echo $height ?>px; width: <?php echo $width; ?>px;"><a href="<?php echo isset( $src ) ? $src : "http://". $_SERVER['SERVER_NAME']. $image[0]; ?>" title="<?php the_title(); ?>" rel="gallery"><img class="featured_image alignnone" src="<?php echo adelante_image_resize( $height, $width, "http://". $_SERVER['SERVER_NAME']. $image[0] ); ?>" alt="<?php echo $post->title; ?>" /></a><?php adelante_image_border(null, 5, 0.1); ?></figure>
<?php 
        }
    }
    else {
        if ( 'checked' == get_option('adelante_images_'.$post->post_type.'_placeholder' ) ) :
?>
            <figure class="<?php echo $class; ?>"><a href="<?php echo isset( $src ) ? $src : ADELANTE_BASE_URI."/img/placeholder.png"; ?>" title="<?php the_title(); ?>" rel="gallery"><img class="featured_image" src="<?php echo adelante_image_resize( $height, $width, ADELANTE_BASE_URI."/img/placeholder.png" ); ?>" alt="<?php echo $post->title; ?>" /></a></figure>                
<?php    
        endif;
    }   
}    

// Load metadata of current post
function adelante_post_meta( $wrap = "time" )
{
    $year = get_the_time('Y'); 
    $month = get_the_time('m');
?>
    <<?php echo $wrap; ?>>Posted: <a href="<?php echo get_month_link( $year, $month ); ?>"><?php the_time( 'M j Y' ) ?></a> by <?php the_author_posts_link(); ?>        
<?php 
    if ( count( ( $categories = get_the_category() ) ) > 1 || $categories[0]->cat_ID != 1 ) : ?> in <?php the_category( ', ' ) ?>
<?php endif; ?> with <?php comments_popup_link( '0 Comments', '1 Comment', '% Comments' ); ?></<?php echo $wrap; ?>>
<?php 
} 

// Load slider images
function adelante_image_slider( $width = 960 ) 
{
    global $post;
    $height = get_option('adelante_slider_height');
    $i = 1;
    adelante_buffer_start();
    
    echo '<ul>';
        query_posts( array( 'post_type' => 'slider', 'posts_per_page' => get_option('adelante_slider_slide_count') ) );
        if ( have_posts() ) while ( have_posts() ) : the_post();
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            $href = get_post_meta( $post->ID, 'slider_href', true );
            $target = get_post_meta( $post->ID, 'slider_href_target', true );
            $alt = get_post_meta( $post->ID, 'slider_alt', true );            
            $img = adelante_image_resize( $height, $width, $thumbnail[0] );                          
        ?>
            <li id="slide-<?php echo $i++; ?>" class="slide clearfix">
            <?php    
                if ( ! empty( $href ) ) {                
                    echo '<a href="'. $href. '" target="'. $target. '"><img class="featured_image image" src="'. $img. '" alt="'. $post->post_title. '" title="'. $post->post_content. '" /></a>';                      
                }
                else {
                    echo '<a href=""><img class="featured_image image" src="'. $img. '" alt="'. $post->post_title. '" title="'. $post->post_content. '" /></a>';
                }
            ?> 
            </li> 
        <?php                          
            endwhile;
        else{
            echo '<a href="'.site_url().'/wp-admin/post-new.php?post_type=slider"><img class="image" src="'. adelante_image_resize( $height, $width, get_template_directory_uri(). "/img/placeholder.png" ). 
                    '" alt="placeholder" title="Please add items to your slider by clicking on this slide" /></a>';                      
        }            
    echo '</ul>';
    
    wp_reset_query();        
    $output = ob_get_contents();
    adelante_buffer_end();
    
    return $output;         
}    

// Load slider posts
function adelante_posts_slider( $width = 960 ) 
{
    global $post;
    $i = 1; $height = get_option('adelante_slider_height'); 
    
    // Check what post types to include in slider
    $post_types = adelante_get_post_types( false, false );
    foreach ( $post_types as $post_type ) {
        $inc = get_option( 'adelante_slider_'. $post_type );
        if ( $inc == 'checked' ) $types[] = $post_type;
    }

    adelante_buffer_start();
    
    // Start outputting
    echo '<ul>';
        $args = array( 'post_type' => $types );
        $ppp = get_option('adelante_slider_post_count');
        if ( $ppp > 0 ) $args['posts_per_page'] = $ppp;        
        query_posts( $args );
        if ( have_posts() ) while ( have_posts() ) : the_post();
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
        ?>
            <li id="slide-<?php echo $i++; ?>" class="slide clearboth">
                <div class="thumb clearfix">
                    <a href="<?php the_permalink(); ?>">
                        <?php if( ! empty( $thumbnail[0] ) ) { ?>
                            <figure class="gallery-item aligncenter"><img class="featured_image post" src="<?php echo adelante_image_resize($height-21, $width-410, $thumbnail[0]);?>" alt="<?php the_title(); ?>" /><?php adelante_image_border(null, 10, 0.05); ?></figure>
                        <?php } else { ?>
                            <figure class="gallery-item aligncenter"><img class="featured_image post" src="<?php echo adelante_image_resize( $height-21, $width-410, get_template_directory_uri(). "/img/placeholder.png" ); ?>" alt="placeholder" /></figure>
                        <?php } ?>
                    </a>
                    <div class="postsnip">
                        <h2><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></h2>
                        <?php the_excerpt(); ?>
                        <p></p><div class="clearboth"></div>
                        <a class="adelante-button white" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read More...</a>
                    </div>
                </div>
               
            </li>            
        <?php                  
            endwhile;
        else{
            $output .= '<figure class="gallery-item aligncenter"><a href="'.site_url().'/wp-admin/post-new.php?post_type=slider"><img class="post" src="'. adelante_image_resize( $height-21, $width-410, get_template_directory_uri(). "/img/placeholder.png" ). 
                    '" alt="placeholder" title="Please add items to your slider by clicking on this slide" /></a></figure>';                      
        }
    echo '</ul>'; 
           
    wp_reset_query();
    $output = ob_get_contents();
    adelante_buffer_end();

    return $output;          
}    

?>