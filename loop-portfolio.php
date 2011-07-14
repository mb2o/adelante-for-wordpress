<?php if ( $_GET['title'] != 'false' ): ?>
        <h1><?php echo isset( $_GET['title'] ) ? $_GET['title'] : $post->post_title; ?></h1>
<?php endif; ?>

<ul id="portfolio-filter">
    <li><a href="#all" title="">All</a></li>
    <?php
        $terms = get_terms( "portfolio_entries" );         
        if ( count( $terms ) > 0 ) {
            foreach ( $terms as $term ) {
    ?>            
                <li><a href="#<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>       
    <?php              
            }
        }
    ?>
</ul>

<ul id="portfolio-list">
    <?php
        switch( $_GET['columns'] ) {
            case 1:
                $columns = 1; $height = 350; $width = 900; $ppp = 50;
                if ( get_option( 'adelante_css_framework' ) === '1140' ) { $width = 1000; }
                break;
            case 2:
                $columns = 2; $height = 230; $width = 410; $ppp = 50;
                if ( get_option( 'adelante_css_framework' ) === '1140' ) { $width = 480; $height = 250; }            
                break;
            case 4:
                $columns = 4; $height = 125; $width = 194; $ppp = 50;
                if ( get_option( 'adelante_css_framework' ) === '1140' ) { $width = 228; $height = 140; }
                break;            
            default:
                $columns = 3; $height = 150; $width = 265; $ppp = 50;
                if ( get_option( 'adelante_css_framework' ) === '1140' ) { $width = 310; $height = 200; }            
        }
        
        $counter = 0;
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;    
        query_posts( "paged=$paged&post_type=portfolio&posts_per_page=$ppp" );  

        if ( have_posts() ) : while( have_posts() ) :  the_post();
            $postTerms = array();
            $terms = wp_get_post_terms( $post->ID, "portfolio_entries" );
            foreach($terms as $term){
                $postTerms[] = $term->slug;
            }                
    ?>      
        <li style="width: <?php echo $width; ?>px;" id="post-<?php the_ID(); ?>" data-id="post-<?php the_ID(); ?>" <?php echo post_class( array( implode(" ", $postTerms)) ); ?>>           
            <?php adelante_featured_image( $height, $width ); ?>                                                             
            <h3 class="blog_header"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>            

            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div>
        </li>
    
        <?php $counter++; ?>         
        <?php endwhile; ?>       
    
    </ul>                       
    
    <?php else : ?>

        <div class="notice">
            <p class="bottom">Sorry, no results were found.</p>
        </div>
        <?php get_search_form(); ?> 
        
    <?php 
        endif; 
        wp_reset_postdata(); 
    ?>


<div class="clearboth"></div>
<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi(); ?> 
        
<script>

$(function(){
   
   $('#portfolio-list').filterable();
    
});

</script>