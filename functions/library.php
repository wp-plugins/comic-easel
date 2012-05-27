<?php
/*
*  Get a sidebar and create a generic dynamic sidebar for it, else find the sidebar-*.php in the theme/childtheme
*/

function ceo_get_sidebar($location = '') {
	if (empty($location)) { get_sidebar(); return; }
	if (file_exists(get_stylesheet_directory().'/sidebar-'.$location.'.php')) {
		get_sidebar($location);
	} elseif (is_active_sidebar('sidebar-'.$location)) { ?>
		<div id="sidebar-<?php echo $location; ?>" class="sidebar">
			<?php dynamic_sidebar('sidebar-'.$location); ?>
		</div>
	<?php }
}