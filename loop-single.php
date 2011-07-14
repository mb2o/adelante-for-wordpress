<?php while (have_posts()) : the_post();  ?>
	<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<header>
			<h2 class="entry-title"><?php the_title(); ?><?php if ( ! get_option( "adelante_post_featured_image") ) adelante_featured_image(40, 40, null, "gallery-item alignright"); ?></h2>
			<?php adelante_post_meta(); ?>
			<?php if (get_option('adelante_post_author') === 'checked') { ?>
			<p class="byline author vcard">
				Written by <span class="fn"><?php the_author(); ?></span>
			</p>
			<?php } ?>
			<?php if (get_option('adelante_post_tweet') === 'checked') { ?>
			<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script src="http://platform.twitter.com/widgets.js"></script>
			<?php } ?>
		</header>
		<div class="entry-content">
			<?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>
		</div> 
        <div id="tag-list"><?php the_tags('', ' ', ''); ?></div>
		<footer>
			<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'adelante'), 'after' => '</p></nav>' )); ?>	
		</footer>
		<?php comments_template(); ?>
	</article>
<?php endwhile; ?>