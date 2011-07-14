<?php

// http://www.dagondesign.com/articles/wordpress-hook-for-entire-page-using-output-buffering/

function adelante_callback($buffer) 
{
	if (class_exists('All_in_One_SEO_Pack')) { 
		$temp = preg_replace('/<!-- All in One[^>]+?>\s+/', '', $buffer);
		return preg_replace('/<!-- \/all in one seo pack -->\n/', '', $temp);
	} else {
		return $buffer;
	}
}


function adelante_buffer_start() 
{
	ob_start('adelante_callback');
}
add_action('wp_head', 'adelante_buffer_start', -999);


function adelante_buffer_end() 
{
	ob_end_flush();
}
add_action('wp_footer', 'adelante_buffer_end');
