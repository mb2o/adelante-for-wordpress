<?php
/*
Template Name: Movie (Full Width)
*/

get_header();
adelante_get_teaser(); 

?>

<div id="content" class="<?php echo adelante_container_class; ?>">    
    
    <div id="main" class="span-24 grid_24 twelvecol" role="main">
        
        <div class="container">
        
            <?php get_template_part("loop", "movie") ?>                       
            
        </div>
        
    </div><!-- /#main -->
     
</div><!-- /#content -->

<?php get_footer(); ?>
