<?php
	/* Syndication, RSS additions */
	
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

?>