<?php
	/* Syndication, RSS, Archive & Search additions */
	
function ceo_rss_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type'])) {
		$qv['post_type'] = array('post', 'comic');
	}
	return $qv;
}

add_filter('request', 'ceo_rss_request');

function ceo_insert_comic_into_feed($content) {
	global $wp_query, $post;
	if (is_feed() && $post->post_type == 'comic') {
		$content = '<p>'. ceo_display_comic_thumbnail('full', $post) . '</p>' . $content;
	}
	return apply_filters('ceo_insert_comic_into_feed', $content);
}

add_filter('the_content_rss','ceo_insert_comic_into_feed');
add_filter('the_excerpt_rss','ceo_insert_comic_into_feed');

function ceo_insert_comic_into_archive($content) {
	global $wp_query, $post;
	if (is_archive() || is_search && ($post->post-type == 'comic')) {
		$content = '<p>'.ceo_display_comic_thumbnail('medium', $post) . '</p>' . $content;
	}
	return apply_filters('ceo_insert_comic_into_archive', $content);
}

add_filter('the_content', 'ceo_insert_comic_into_archive');
add_filter('the_excerpt', 'ceo_insert_comic_into_archive');

?>