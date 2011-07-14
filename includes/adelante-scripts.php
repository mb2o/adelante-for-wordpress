<?php 

/**
 * Stylesheets/JavaScripts In Header
 */
 
function adelante_enqueue_scripts() 
{
	if ( ! is_admin() ) 
    {	
		wp_enqueue_script( 'custom-js', ADELANTE_BASE_URI.'/js/custom.js', array( 'jquery' ), '1.5' );
		wp_enqueue_script( 'jquery.easing' , ADELANTE_BASE_URI.'/js/jquery.easing.js', array( 'jquery'), '1.5' );
		wp_enqueue_script( 'cufon-yui', ADELANTE_BASE_URI.'/js/cufon-yui.js', array( 'jquery' ), '1.5' );
		wp_enqueue_script( 'adelante_heading_font', ADELANTE_BASE_URI.'/js/fonts/'. get_option( 'adelante_heading_font' ). ".js", array( 'jquery' ), '1.5' );
		wp_enqueue_script( 'fancybox', ADELANTE_BASE_URI.'/js/jquery.fancybox-1.3.4.pack.js', array( 'jquery' ), '1.5' );
        wp_enqueue_script( 'twitter', ADELANTE_BASE_URI.'/js/twitter.js', array( 'jquery' ), '1.5' );
        wp_enqueue_script( 'cycle', ADELANTE_BASE_URI.'/js/jquery.cycle.all.min.js', array( 'jquery' ), '1.5' );
        wp_enqueue_script( 'tooltipsy', ADELANTE_BASE_URI.'/js/tooltipsy.min.js', array( 'jquery' ), '1.5' );
        wp_enqueue_script( 'filterable', ADELANTE_BASE_URI.'/js/filterable.pack.js', array( 'jquery' ), '1.5' );
        wp_enqueue_script( 'prettyphoto', ADELANTE_BASE_URI.'/js/prettyphoto/js/jquery.prettyPhoto.js', array( 'jquery' ), '1.5' );
	}
}
add_action( 'wp_print_scripts', 'adelante_enqueue_scripts' );
add_action( 'wp_print_styles', 'adelante_enqueue_scripts' );