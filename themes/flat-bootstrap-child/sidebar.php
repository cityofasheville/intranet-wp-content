<?php
/**
 * Theme: Flat Bootstrap
 * 
 * The Sidebar positioned on the right. If no widgets added, display some as samples.
 *
 * @package flat-bootstrap
 */
?>
	<div id="secondary" class="widget-area col-md-3 column-first" role="complementary">
		<!-- PRC TOOLS AND CONTENT MENU 1.13.15 --> 
		<div class="actions-menus">
			<div class="dropdown">
				<h4>
					<a href="#" class="toggle">
				    <i class="fa fa-cog"></i> My Tools 
				    <span class="caret"></span>
				  </a>
				</h4>
				<?php wp_nav_menu( array( 'theme_location' => 'tools-menu' )); ?> 			  
			</div>

<!-- 			<div class="dropdown">
			  <a href="#" class="toggle">
			    <i class="fa fa-flag"></i> Featured Content 
			    <span class="caret"></span>
			  </a>
				<?php wp_nav_menu( array( 'theme_location' => 'featured-menu' )); ?> 
			</div>
		</div> -->
		<!-- END TOOLS AND CONTENT MENU -->		
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'Sidebar' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<br />
				<?php get_search_form(); ?>
			</aside>

			<aside id="pages" class="widget widget_pages">
				<h2 class="widget-title"><?php _e( 'Site Content', 'flat-bootstrap' ); ?></h2>
				<ul>
					<?php wp_list_pages( array( 'title_li' => '' ) ); ?>
				</ul>
			</aside>

			<aside id="tag_cloud" class="widget widget_tag_cloud">
				<h2 class="widget-title"><?php _e( 'Categories', 'flat-bootstrap' ); ?></h2>
					<?php wp_tag_cloud( array( 'separator' => ' ', 'taxonomy' => 'category' ) ); ?>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->
