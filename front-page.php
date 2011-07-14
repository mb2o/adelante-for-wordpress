<?php
get_header();
adelante_get_teaser();  
?>

<div id="content" class="<?php echo adelante_container_class; ?>">    
    
    <div id="main" class="span-24 grid_24 twelvecol" role="main">
        
        <div class="container">
            <?php include('front-page-widget.php'); ?>
            <?php get_template_part('loop', 'page'); ?>
        </div>
        
    </div><!-- /#main -->
    
</div><!-- /#content -->

<?php get_footer(); ?>
