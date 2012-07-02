<?php
/* Filters */

add_filter('request', 'ceo_rss_request'); // Add comics to the main RSS
add_filter('the_content','ceo_insert_comic_into_feed'); // Insert the comic image into the rss
add_filter('the_excerpt_rss','ceo_insert_comic_into_feed');
add_filter('the_content_feed', 'ceo_insert_comic_into_archive'); // Insert the comic into the archive and search pages
add_filter('the_excerpt', 'ceo_insert_comic_into_archive');
add_filter('previous_post_rel_link', 'ceo_change_prev_rel_link_two', $link); // change the rel links for comic pages
add_filter('next_post_rel_link', 'ceo_change_next_rel_link_two', $link);
add_filter('pre_get_posts', 'ceo_query_post_type');
add_filter('body_class', 'ceo_body_class');
add_filter('get_terms_args', 'ceo_chapters_find_menu_orderby');
add_filter('get_lastpostmodified', 'ceo_lastpostmodified');

function ceo_rss_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']) && !isset($qv['chapters'])) {
		$qv['post_type'] = array('post', 'comic');
	}
	return $qv;
}

function ceo_insert_comic_into_feed($content) {
	global $post, $wp_query;
	if (is_feed() && ($post->post_type == 'comic') && !post_password_required()) {
		if ((ceo_pluginfo('thumbnail_size_for_rss') !== 'none') && !isset($wp_query->query_vars['chapters'])) {
			$content = '<p>'. ceo_display_comic_thumbnail(ceo_pluginfo('thumbnail_size_for_rss'), $post) . '</p>' . $content;
		}
		if ((ceo_pluginfo('thumbnail_size_for_direct_rss') !== 'none') && isset($wp_query->query_vars['chapters'])) {
			$content = '<p>'. ceo_display_comic_thumbnail(ceo_pluginfo('thumbnail_size_for_direct_rss'), $post) . '</p>' . $content;
		} 		
	}
	return apply_filters('ceo_insert_comic_into_feed', $content);
}

function ceo_insert_comic_into_archive($content) {
	global $wp_query, $post;
	if ((is_archive() || is_search()) && ($post->post_type == 'comic') && !is_single() && !is_feed() && !post_password_required() && (ceo_pluginfo('thumbnail_size_for_archive') !== 'none')) {
		$content = '<p>'.ceo_display_comic_thumbnail(ceo_pluginfo('thumbnail_size_for_archive'), $post) . '</p>' . $content;
	}
	return apply_filters('ceo_insert_comic_into_archive', $content);
}

function ceo_change_prev_rel_link_two($link) {
	global $post, $wp_query;
	if ($post->post_type=='comic' || is_home() || is_front_page()) {
		$link_url = ceo_get_previous_comic_permalink();
		if (!empty($link_url)) {
			$link='<link rel="prev" href="'.$link_url.'" />'."\r\n";
		} else $link = '';
	}
	return $link;
}

function ceo_change_next_rel_link_two($link) {
	global $post, $wp_query;
	if ($post->post_type=='comic' || is_home() || is_front_page()) {
		$link_url = ceo_get_next_comic_permalink();
		if (!empty($link_url)) {
			$link='<link rel="next" href="'.$link_url.'" />'."\r\n";
		} else $link = '';
	}
	return $link;
}

function ceo_query_post_type($query) {
	if (is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
		$post_type = get_query_var('post_type');
		if($post_type) :
			$post_type = $post_type;
		else:
			$post_type = array('post','comic');
			$query->set('post_type',$post_type);
		endif;
		return $query;
	}
}

function ceo_body_class($classes = '') {
	global $post, $wp_query;
	
	if (!empty($post) && $post->post_type == 'comic') {
		$terms = wp_get_object_terms( $post->ID, 'chapters');
		foreach ($terms as $terms) {
			$classes[] = 'story-'.$terms->slug;
		}
	}
	
	return $classes;
}

function ceo_chapters_edit_menu_orderby() {
	//This is a one-off, so that we don't disrupt queries that may not use menu_order.
	remove_filter('get_terms_orderby', 'ceo_chapters_edit_menu_orderby');
	return "menu_order";	
}

function ceo_chapters_find_menu_orderby($args) {
	if ('menu_order' === $args['orderby']) {
		add_filter('get_terms_orderby', 'ceo_chapters_edit_menu_orderby');
	}
	return $args;
}

// Fix for checking all posts whether or not custom post type or not for last modified.
function ceo_lastpostmodified()
{
	$lastpostmodified = wp_cache_get( "lastpostmodified:custom:server", 'timeinfo' );
	if ( $lastpostmodified ) return $lastpostmodified;
	global $wpdb;
	$add_seconds_server = date('Z');
	$lastpostmodified = $wpdb->get_var("SELECT DATE_ADD(post_modified_gmt, INTERVAL '$add_seconds_server' SECOND) FROM $wpdb->posts WHERE post_status = 'publish' ORDER  BY post_modified_gmt DESC LIMIT 1");
	wp_cache_set( "lastpostmodified:custom:server", $lastpostmodified, 'timeinfo', 3600 );
	return $lastpostmodified;
}
