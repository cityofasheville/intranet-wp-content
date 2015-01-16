<?php
/**
 * Theme: Flat Bootstrap
 * 
 * The template for displaying Search Results pages.
 *
 * @package flat-bootstrap
 */

get_header(); ?>

<?php get_template_part( 'content', 'header' ); ?>

<div class="container">
<div id="main-grid" class="row">

	<?php get_sidebar(); ?>

	<section id="primary" class="content-area col-md-9">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php // Start the Loop ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php //get_template_part( 'content', 'search' ); ?>
				<?php get_template_part( 'content', 'page-posts' ); ?>

			<?php endwhile; ?>

			<?php get_template_part( 'content', 'index-nav' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->



</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>