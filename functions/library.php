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

function ceo_change_prev_rel_link_two($object) {
	global $post;
//	if ($post->post_type=='comic') $link='<link rel="previous" href="'.ceo_get_previous_comic_permalink().'" />'."\r\n";
	if ($post->post_type == 'comic') $link=false;
	return $link;
}

add_filter('previous_post_rel_link', 'ceo_change_prev_rel_link_two', $link);

function ceo_change_next_rel_link_two($object) {
	global $post;
//	if ($post->post_type=='comic') $link='<link rel="next" href="'.ceo_get_next_comic_permalink().'" />'."\r\n";
	if ($post->post_type == 'comic') $link=false;
	return $link;
}

add_filter('next_post_rel_link', 'ceo_change_next_rel_link_two', $link);