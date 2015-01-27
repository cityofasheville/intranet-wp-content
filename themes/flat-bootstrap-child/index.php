<?php
/**
 * Theme: Flat Bootstrap
 * 
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package flat-bootstrap
 */

get_header(); ?>

<?php get_template_part( 'content', 'header' ); ?>

<div class="container">
	<div class="row">
	<?php get_sidebar(); ?>	
	<section id="primary" class="content-area col-md-9">
	<main id="main" class="site-main" role="main">
	

	<!-- START TOP CAROUSEL PRC 1.13.15 -->
	<?php 
	 $number = 0; 
	 query_posts(array('cat=4'),('posts_per_page=5')); 
	 if(have_posts()):  
	?>	
		<div class="">
			<div class="slide-nav">
				<ol class="carousel-indicators">
					<?php while(have_posts()): the_post(); ?>
						<li data-target="#myCarousel" data-slide-to="<?php echo $number++; ?>"></li>
					<?php endwhile; ?>
				</ol>	
				<div class="slide-directions">			
					<div class="slide-left">
						<i class="fa fa-caret-square-o-left"></i>
					</div>
					<div class="slide-right">
						<i class="fa fa-caret-square-o-right"></i>  
					</div>
				</div>
			</div>				
			<div class="slider">

				<div id="myCarousel" class="carousel slide">
				  <!-- Carousel items -->
				  <div class="carousel-inner">
				    <?php while(have_posts()): the_post(); ?>
				    <div class="item">
				    <div class="col-md-12">
				    	<h3><?php the_title(); ?></h3>
						<div class="byline">
						    <span>by <?php the_author(); ?></span>
						  	<span><?php the_time('F jS, Y'); ?></span>
						</div>				    	
				    </div>
				    <!-- CHECK IF POST HAS THUMBNAIL -->
				    <?php if ( has_post_thumbnail() ): ?>
					<div class="column-first carousel-image col-md-12">
						<div>
							<div class="image-container">
								<?php the_post_thumbnail('large'); ?>
							</div>
							<div class="text-overlay">
								<?php the_excerpt(); ?>
							</div>
						</div>
					</div>
					<!-- IF POST DOESN"T HAVE A THUMBNAIL  -->
			    	<?php else: ?>
						<div class="col-md-10">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; ?>				      
				    </div>
				    <?php endwhile; ?>
				  </div>
				  <!-- Carousel nav -->
<!-- 				  <a class="carousel-control left" href="#myCarousel" data-slide="prev"> 
				  	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				  </a>
				  <a class="carousel-control right" href="#myCarousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				  </a> -->			  
				</div>
				<?php endif; wp_reset_query(); ?>
			</div>			
			<!-- END TOP CAROUSEL PRC 1.13.15 -->


			
			<h2><i class="fa fa-newspaper-o"></i> Recent News</h2>
			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?> 
				<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-md-12">
					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>
				</div>
				<?php endwhile; ?>

				<?php get_template_part( 'content', 'index-nav' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div>
	</section><!-- #primary -->
	</div>		
</div><!-- .container -->


<script>
jQuery(document).ready(function(){
  jQuery(".carousel-indicators li:first").addClass("active");
  jQuery(".carousel-inner .item:first").addClass("active");
});
</script>

<?php get_footer(); ?>