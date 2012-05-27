<?php
/* Filters */

add_filter('request', 'ceo_rss_request'); // Add comics to the main RSS
add_filter('the_content_rss','ceo_insert_comic_into_feed'); // Insert the comic image into the rss
add_filter('the_excerpt_rss','ceo_insert_comic_into_feed');
add_filter('the_content', 'ceo_insert_comic_into_archive'); // Insert the comic into the archive and search pages
add_filter('the_excerpt', 'ceo_insert_comic_into_archive');
add_filter('previous_post_rel_link', 'ceo_change_prev_rel_link_two', $link); // change the rel links for comic pages
add_filter('next_post_rel_link', 'ceo_change_next_rel_link_two', $link);

function ceo_rss_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type'])) {
		$qv['post_type'] = array('post', 'comic');
	}
	return $qv;
}

function ceo_insert_comic_into_feed($content) {
	global $wp_query, $post;
	if (is_feed() && $post->post_type == 'comic') {
		$content = '<p>'. ceo_display_comic_thumbnail('full', $post) . '</p>' . $content;
	}
	return apply_filters('ceo_insert_comic_into_feed', $content);
}

function ceo_insert_comic_into_archive($content) {
	global $wp_query, $post;
	if (is_archive() || is_search() && ($post->post-type == 'comic') && !is_single() && !is_feed()) {
		$content = '<p>'.ceo_display_comic_thumbnail('medium', $post) . '</p>' . $content;
	}
	return apply_filters('ceo_insert_comic_into_archive', $content);
}

function ceo_change_prev_rel_link_two($object) {
	global $post, $wp_query;
	if ($post->post_type=='comic' || is_home()) $link='<link rel="previous" href="'.ceo_get_previous_comic_permalink().'" />'."\r\n";
	return $link;
}

function ceo_change_next_rel_link_two($object) {
	global $post;
	if ($post->post_type=='comic') $link='<link rel="next" href="'.ceo_get_next_comic_permalink().'" />'."\r\n";
	return $link;
}


