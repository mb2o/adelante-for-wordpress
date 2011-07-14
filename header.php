<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
	
    <meta name="disable_cufon" content="<?php echo get_option('adelante_disable_cufon'); ?>">
    
	<?php echo get_adelante_stylesheets(); ?>
	
    <?php 
        if ( is_single() ) {
            $css = get_post_meta( $post->ID, 'css', true );
            if ( ! empty( $css ) ) { ?>
                <style>
                    <?php echo $css; ?>
                </style>
            <?php }
        } 
    ?>

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php site_url(); ?>/feed/">

    <!--[if IE 6]>
    <script src="<?php echo ADELANTE_JS_URI; ?>/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>
        DD_belatedPNG.fix('#logo');
    </script>
    <![endif]-->    
    
	<script src="<?php echo ADELANTE_JS_URI; ?>libs/modernizr-2.0.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script>window.jQuery || document.write("<script src='<?php echo ADELANTE_JS_URI; ?>libs/jquery-1.5.2.min.js'>\x3C/script>")</script>

    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
    
    <?php if (get_option('adelante_css_framework') === '1140') { ?>
	    <script src="<?php echo ADELANTE_JS_URI; ?>css3-mediaqueries.js"></script>
    <?php } ?>	
	
    <?php set_javascript_globals(); ?>
    
    <?php if (get_option('adelante_google_analytics') !== "") { ?>
	    <script>
		    var _gaq=[["_setAccount","<?php echo get_option('adelante_google_analytics'); ?>"],["_trackPageview"]];
		    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		    g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
		    s.parentNode.insertBefore(g,s)}(document,"script"));
	    </script>
            <?php } ?>
</head>
<body>
	
    <?php if ( get_option( 'adelante_css_framework' ) === '1140' ) : ?>
        <div class="row">
    <?php endif; ?>  
    
        <div id="top" class="<?php echo adelante_container_class; ?>">                 
            <a id="logo" href="<?php site_url(); ?>/">
                <img src="<?php echo ADELANTE_BASE_URI; ?>/img/logo.png" alt="<?php bloginfo( 'name' ); ?>">
            </a>
     
            <nav id="nav-main" role="navigation" class="slidemenu">
                <?php wp_nav_menu( array( 'theme_location' => 'primary_navigation' ) ); ?>
            </nav>          
        </div>
        
        <div id="wrap" role="document">     
	        
	        <?php if ( get_option( 'adelante_css_framework') === '1140' ) : ?>
		        <div class="row">
            <?php endif; ?>
            
                <?php if ( is_front_page() ) : ?>
                    <div id="page-heading">
                        <div id="page-heading-gradient">
                            <div id="page-heading-pattern">
                                <div class="inner <?php echo adelante_container_class; ?>">                                      
                                    <div id="slider-wrapper"><!-- BEGIN slider -->
                                        <div class="slider-frame">
                                            <div class="slider-nav slider-prev"></div>                                                   
                                            <?php 
                                                $subject = get_option('adelante_slider_subject'); 
                                                switch( $subject ) {
                                                    case 'posts':          
                                                        echo adelante_posts_slider( get_framework_size() ); 
                                                        break;
                                                    default: 
                                                        echo adelante_image_slider( get_framework_size() );                                                       
                                                        break;
                                                } 
                                            ?>
                                            <div class="slider-nav slider-next"></div> 
                                            <div class="slider-title"><p></p></div>                                                                               
                                        </div>                                       
                                        <div class="slider-shadow"></div>        
                                    </div><!-- END slider -->                                                   
                                </div>
                            </div>
                        </div>    
                    </div>
                <?php endif; ?>
                    