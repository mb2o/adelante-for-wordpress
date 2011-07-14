<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post();  ?>

    <?php 
        $tagline = get_post_meta( $post->ID, 'movie_tagline', true ); 
        if ( ! empty( $tagline ) ):
    ?>
            <script>
                $(function(){
                    $("#teaser-content").html("<div id=\"teaser-inner\"><?php echo $tagline; ?></div>");
                    Cufon.replace('#teaser-content', { 
                        hover: 'true' 
                    });    
                });
            </script>
    <?php endif; ?>

	<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<header>       
			<h2 class="entry-title"><?php the_title(); ?>&nbsp;<?php $year = get_post_meta( $post->ID, 'movie_year', true ); echo !empty( $year )?"($year)":""; ?><?php if ( ! get_option( "adelante_post_featured_image") ) adelante_featured_image(40, 40, null, "gallery-item alignright"); ?></h2>
			<?php adelante_post_meta(); ?>  
			<?php if ( get_option('adelante_post_author') == 'checked' ) { ?>
			<p class="byline author vcard">
				Written by <span class="fn"><?php the_author(); ?></span>
			</p>
			<?php } ?>
			<?php if ( get_option('adelante_post_tweet') == 'checked' ) { ?>
			<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
                <script src="http://platform.twitter.com/widgets.js"></script>
			<?php } ?>
		</header>
		<div class="entry-content">               
            <?php                
                $director_link = get_the_term_list($post->ID, 'director', '', ', ', '');
                $genre_link = get_the_term_list($post->ID, 'movie_genre', '', ', ', '');
                $actor_link = get_the_term_list($post->ID, 'actor', '', ', ', '');
                $writer_link = get_the_term_list($post->ID, 'writer', '', ', ', '');
                $tags = get_the_tag_list( '', ', ', '' );
            ?>                           
            <element class="movie-frame">
                <div class="movie-info">
                    <p>Genre: <?php echo $genre_link; ?><br>
                       Runtime: <?php $runtime = get_post_meta( $post->ID, 'movie_runtime', true ); echo !empty($runtime)?"$runtime minutes":"-"; ?></p>
                    <p></p>
                    <p>Director: <?php echo $director_link; ?><br>
                       Writer: <?php echo $writer_link; ?><br>
                       Starring: <?php echo $actor_link; ?></p>
                    <p></p>
                    <p><?php the_content(); ?></p>
                    <div class="clearboth"></div>
                    <p>Rating: <b><?php echo get_post_meta( $post->ID, 'movie_rating', true ); ?></b> / 10</p>

                    <p>Links: <?php echo do_shortcode('[lightbox width="80%" height="90%" type="external" theme="dark_rounded" link="'.get_post_meta( $post->ID, 'movie_uri', true ).'" title="TheMovieDb"]TheMovieDb[/lightbox]'); ?> | <?php echo do_shortcode('[lightbox width="80%" height="90%" type="external" theme="dark_rounded" link="http://www.imdb.com/title/'.get_post_meta( $post->ID, 'movie_imdbid', true ).'/" title="Internet Movie Database"]Internet Movie Database[/lightbox]'); ?></p>

                    <p>Budget: <?php echo get_post_meta( $post->ID, 'movie_budget', true ); ?><br>
                       Revenue: <?php echo get_post_meta( $post->ID, 'movie_revenue', true ); ?><br>
                       Tags: <?php echo $tags; ?></p>
                    
                    <?php  
                        $url = parse_url( get_post_meta( $post->ID, 'movie_url', true ) );                   
                        parse_str( $url['query'] );
                        if ( isset( $v ) ) :
                    ?>      
                            <h4><?php echo do_shortcode('[lightbox type="youtube" theme="dark_rounded" link="'. get_post_meta( $post->ID, 'movie_url', true ). '" title="'. $post->post_title. '" description="Trailer" height="350" width="580"]Watch the trailer[/lightbox]') ?></h4>      
                    <?php else : ?>
                            <h4>No trailer</h4>
                    <?php            
                        endif; 
                    ?>                    
                </div>                                       
            </element>
		</div>
		<footer>	
			
		</footer>
		<?php comments_template(); ?>
	</article>

<?php endwhile; // End the loop ?>

