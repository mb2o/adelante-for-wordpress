<?php get_header(); ?>
		<div id="content" class="<?php echo adelante_container_class; ?>">	
			<div id="main" class="<?php echo get_option('adelante_main_class'); ?>">
				<div class="container">
					<h2>Search Results for <?php echo get_search_query(); ?></h2>				
					<?php get_template_part('loop', 'search'); ?>
				</div>
			</div><!-- /#main -->
			<aside id="sidebar" class="<?php echo get_option('adelante_sidebar_class'); ?>" role="complementary">
				<div class="container">
					<?php get_sidebar(); ?>
				</div>
			</aside><!-- /#sidebar -->
		</div><!-- /#content -->
<?php get_footer(); ?>
