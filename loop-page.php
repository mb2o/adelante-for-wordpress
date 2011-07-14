<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post();  ?>

	<?php if (function_exists('yoast_breadcrumb')) { if (is_page() && $post->post_parent) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } } ?>
	<?php if (! is_front_page()) :?>
    <?php if ( $_GET['title'] != 'false' ): ?>
        <?php echo isset( $_GET['title'] ) ? '<h1>'. $_GET['title']. '</h1>' : the_title('<h1>', '</h1>');?>
    <?php endif; ?>
	<?php endif; ?>
	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'adelante'), 'after' => '</p></nav>' )); ?>

<?php endwhile; // End the loop ?>

