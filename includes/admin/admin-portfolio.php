<?php

function portfolio_register() 
{
	$labels = array(
		'name' => _x('Portfolio', 'post type general name'),
		'singular_name' => _x('Portfolio Entry', 'post type singular name'),
		'add_new' => _x('Add New', 'portfolio'),
		'add_new_item' => __('Add New Portfolio Entry'),
		'edit_item' => __('Edit Portfolio Entry'),
		'new_item' => __('New Portfolio Entry'),
		'view_item' => __('View Portfolio Entry'),
		'search_items' => __('Search Portfolio Entries'),
		'not_found' =>  __('No Portfolio Entries found'),
		'not_found_in_trash' => __('No Portfolio Entries found in Trash'), 
		'parent_item_colon' => ''
	);
	
	$slug = get_option( 'adelante_portfolio_slug' );
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array( 'slug' => $slug, 'with_front' => true ),
		'query_var' => true,
		'show_in_nav_menus'=> false,
		'supports' => array( 'title', 'thumbnail', 'excerpt', 'editor', 'comments' )
	);
	
	register_post_type( 'portfolio' , $args );
	
	register_taxonomy(
        "portfolio_entries", 
		"portfolio", 
		array(
            "hierarchical" => true,
		    "label" => "Categories", 
		    "singular_label" => "Categories", 
		    "rewrite" => true,
		    "query_var" => true
	    )
    );  
}
add_action('init', 'portfolio_register');


function edit_columns($columns)
{
	$newcolumns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Title",
		"portfolio_entries" => "Categories"
	);
	
	$columns = array_merge($newcolumns, $columns);
	
	return $columns;
}
add_filter("manage_edit-portfolio_columns", "edit_columns");


function custom_columns($column)
{
	global $post;
    if ( $post->post_type == "slider" ) {
	    switch ( $column ) {
		    case "description":
		        the_excerpt();
		        break;
		    case "portfolio_entries":
		        echo get_the_term_list( $post->ID, 'portfolio_entries', '', ', ', '' );
		        break;
	    }
    }
}
add_action("manage_posts_custom_column",  "custom_columns");

?>