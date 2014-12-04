<?php
/**
 * Theme: Flat Bootstrap
 * 
 * The "sidebar" for the bottom of the page (before the widgetized footer area). If no 
 * widgets added AND preivewing the theme, then display some widgets as samples. Once the
 * theme is actually in use, it will be empty until the user adds some actual widgets.
 *
 * @package flat-bootstrap
 */
?>

<?php 
global $xsbf_theme_options;

/* If page bottom "sidebar" has widgets, then display them */
$sidebar_pagebottom = get_dynamic_sidebar( 'Page Bottom' );
if ( $sidebar_pagebottom ) :
?>
	<div id="sidebar-pagebottom" class="sidebar-pagebottom">
		<?php echo apply_filters( 'xsbf_pagebottom', $sidebar_pagebottom ); ?>
	</div><!-- .sidebar-pagebottom -->

<?php
/* Otherwise, if user is previewing this theme, then show an example */
elseif ( $xsbf_theme_options['sample_widgets'] ) :
?>
	

<?php endif;?>