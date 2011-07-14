<?php if ( $_GET['title'] != 'false' ): ?>
    <header>
        <h1><?php echo isset( $_GET['title'] ) ? $_GET['title'] : $post->post_title; ?></h1>
    <header>
<?php endif; ?>

<?php
    switch( $_GET['columns'] ) {
        case 2:
            $columns = 2; $class = "one_half"; $ppp = 10; 
            is_page_template("page-movie.php") == true ? $height = 150 : $height = 230; 
            is_page_template("page-movie.php") == true ? $width = 260 : $width = 410;          
            break;
        case 3:
            $columns = 3; $class = "one_third"; $ppp = 15;
            is_page_template("page-movie.php") == true ? $height = 120 : $height = 150; 
            is_page_template("page-movie.php") == true ? $width = 170 : $width = 265;
            break;              
        default:
            $columns = 1; $class = ""; $ppp = 5; 
            is_page_template("page-movie.php") == true ? $height = 250 : $height = 250; 
            is_page_template("page-movie.php") == true ? $width = 580 : $width = 900; 
            break;           
    }
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts("paged=$paged&post_type=movie&posts_per_page=$ppp");
    $counter = 0;
    
    if ( have_posts() ) : while( have_posts() ) : the_post();        
?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( array( $class, $counter%$columns == 0 ? 'first' : '' ) ); ?>>
            <?php
                $fi_position = get_post_meta( $post->ID, 'featured_image_position', true ); 
                $fi_disabled = false;
                if ( get_option( "adelante_post_featured_image" ) == 'checked' ) $fi_disabled = true;
            ?> 
            <header>
                <?php if ( ( $fi_position == "top" || $fi_position == "" ) && ! $fi_disabled ) adelante_featured_image( $height, $width ); ?>                                                            
                <h2 class="blog_header"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>            
            </header>
            
            <div class="entry-content">
                <?php if ( $fi_position == 'left' && !$fi_disabled ) adelante_featured_image( 200, 200, null, "gallery-item alignedleft" ); ?>                        
                <?php if ( $fi_position == 'right' && !$fi_disabled ) adelante_featured_image( 200, 200, null, "gallery-item alignedright" ); ?>
                <?php the_excerpt(); ?>
            </div>
                                        
        </article>        

        <?php $counter++; ?>         
        <?php endwhile; ?>
        
        <div class="clearboth"></div>
        <?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi(); ?> 
                
<?php else : ?>

    <div class="notice">
        <p class="bottom">Sorry, no results were found.</p>
    </div>
    <?php get_search_form(); ?> 
    
<?php endif; wp_reset_postdata(); ?>

                      

