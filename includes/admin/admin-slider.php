<?php

function slider_register() 
{
	$labels = array(
		'name' => _x('Slider', 'post type general name'),
		'singular_name' => _x('Slider Entry', 'post type singular name'),
		'add_new' => _x('Add New', 'slider'),
		'add_new_item' => __('Add New Slider Item'),
		'edit_item' => __('Edit Slider Item'),
		'new_item' => __('New Slider Item'),
		'view_item' => __('View Slider Item'),
		'search_items' => __('Search Slider Items'),
		'not_found' =>  __('No Slider Items found'),
		'not_found_in_trash' => __('No Slider Items found in Trash'), 
		'parent_item_colon' => ''
	);
	
	$slug = get_option( 'adelante_slider_slug' );
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array( 'slug' => $slug, 'with_front' => true ),
		'query_var' => true,
		'show_in_nav_menus'=> false,
		'supports' => array( 'title', 'thumbnail', 'editor' )
	);
	
	register_post_type( 'slider' , $args );
    add_action( 'admin_menu', 'metabox' );
    add_action( 'save_post', 'save_slider_data' );
}
add_action('init', 'slider_register');

add_filter("manage_edit-slider_columns", "slider_edit_columns");
add_action("manage_posts_custom_column",  "slider_custom_columns");

function slider_edit_columns($columns)
{
	$newcolumns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Alt",
		"slider_entries" => "Image Title",
        "thumbnail" => "Slide" 
	);
	
	$columns = array_merge($newcolumns, $columns);
	
	return $columns;
}

function slider_custom_columns($column)
{
	global $post;
    
    if ($post->post_type == "slider") {
	    switch ($column)
	    {
		    case "description":
		        the_excerpt();
		        break;
		    case "slider_entries":
                the_content();
		        break;
            case 'thumbnail':
                echo the_post_thumbnail(array(318,450));
                break;
	    }
    }
}

    function metabox() 
    {
        add_meta_box( 'sliderdiv', __('Slide'), 'add_slider_metabox', 'slider', 'normal', 'low');
    }
     
    function add_slider_metabox( $post ) 
    {
        global $post;
        $targets = array("_blank", "_self", "_parent", "_top");
        $slider_href_target = get_post_meta( $post->ID, 'slider_href_target', TRUE );      
?>
        <input type="hidden" name="slider_noncename" id="slider_noncename" value="<?php echo wp_create_nonce( 'slider'. $post->ID ); ?>" />
        <div id="slider-options">
            <ul class="options clearfix">
                <li>
                    <label class="settings-label">Slide Link</label>
                    <input name="slider_href" type="text" value="<?php echo get_post_meta( $post->ID, 'slider_href', TRUE ); ?>" class="text" />
                    <span class="note">Specify a location to where this slider item should link</span>
                </li>
                <li>
                    <label class="settings-label">Link Target</label>
                    <select name="slider_href_target"> 
                        <?php
                            foreach( $targets as $target ) {
                                if ( $target == $slider_href_target ) {
                                    $selected = "selected='selected'";
                                } 
                                else {
                                    $selected = "";        
                                }
                                echo"<option $selected value='". $target. "'>". $target."</option>";
                            }
                        ?>
                        ?>
                    </select>
                    <span class="note">Specify a target for this link</span>
                </li>
            </ul>
        </div>       
<?php
    }
    
    function save_slider_data( $post_id ) 
    {   
        // verify this came from the our screen and with proper authorization.
        if ( ! wp_verify_nonce( $_POST['slider_noncename'], 'slider'. $post_id ) ) {
            return $post_id;
        }
        // verify if this is an auto save routine. 
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return $post_id;
        if ( !current_user_can( 'edit_post', $post_id ) )
            return $post_id;    
        $post = get_post( $post_id );
        if ( $post->post_type == 'slider' ) { 
            update_post_meta( $post_id, 'slider_href', esc_attr($_POST['slider_href'] ) );
            update_post_meta( $post_id, 'slider_href_target', esc_attr($_POST['slider_href_target'] ) );
        }
        return $post_id;
    }
?>