<?php

function ceo_display_comic($size = 'full') {
	global $post;
    if ( post_password_required() ) { 
		return __('This information is password protected.','comiceasel');
    }
	$output = '';
	$post_image_id = get_post_thumbnail_id($post->ID);
	if ($post_image_id) {
		$output = '';
		$thumbnail = wp_get_attachment_image_src( $post_image_id, $size, false);
		$thumbnail = reset($thumbnail);
		$hovertext = ceo_the_hovertext();
		$next_comic = ceo_get_next_comic_permalink();
		if (ceo_pluginfo('click_comic_next') && !empty($next_comic)) {
			$output .= '<a href="'.$next_comic.'">';
		}
		$output .= '<img src="'.$thumbnail.'" alt="'.$hovertext.'" title="'.$hovertext.'" />';
		if (ceo_pluginfo('click_comic_next') && !empty($next_comic)) {
			$output .= '</a>';
		}
	}
	if (get_post_meta( $post->ID, 'comic-gallery', true )) {
		$columns = get_post_meta( $post->ID, 'comic-gallery-columns', true );
		if (empty($columns)) $columns = 5;
		$args = array(
				'id'         => $post->ID,
				'columns'    => $columns,
				'exclude'    => $post_image_id
				);
		$output .= gallery_shortcode($args);
	}
	if ($output) { 
		return apply_filters('ceo_comics_display_comic', $output);
	} else
		return __('No Gallery or featured image Found.', 'comiceasel');
}

function ceo_the_hovertext($override_post = null) {
	global $post;
	$post_to_use = !is_null($override_post) ? $override_post : $post;
	$hovertext = esc_attr( get_post_meta( $post_to_use->ID, 'comic-hovertext', true ) );
	if (empty($hovertext)) $hovertext = esc_attr( get_post_meta($post_to_use->ID, 'hovertext', true) ); // check if using old hovertext
	return (empty($hovertext)) ? get_the_title($post_to_use->ID) : $hovertext;
}

// We use this type of query so that $post is set, it's already set with is_single - but needs to be set on the home page
function ceo_display_comic_area() {
	global $wp_query, $post;
	if (is_single()) {
		ceo_display_comic_wrapper();
	} else {
		if ((is_home() || is_front_page()) && !is_paged() && !ceo_pluginfo('disable_comic_on_home_page'))  {
			ceo_Protect();
			$comic_args = array(
					'showposts' => 1,
					'posts_per_page' => 1,
					'post_type' => 'comic'
					);
			$wp_query->in_the_loop = true; $comicFrontpage = new WP_Query(); $comicFrontpage->query($comic_args);
			while ($comicFrontpage->have_posts()) : $comicFrontpage->the_post();
				ceo_display_comic_wrapper();
				break;
			endwhile;
			ceo_UnProtect();
		}
	}
}

// Do the thumbnail display functions here.
function ceo_display_comic_thumbnail($thumbnail_size = 'thumbnail', $override_post = null) {
	global $post;
	$thumbnail = $output = '';
	$post_to_use = !empty($override_post) ? $override_post : $post;
	
	if ( has_post_thumbnail($post_to_use->ID) ) {
		$output =  '<a href="'.get_permalink($post_to_use->ID).'" rel="bookmark" title="'.get_the_title().'">'.get_the_post_thumbnail($post_to_use->ID, $thumbnail_size).'</a>'."\r\n";
	} else {
//			$output = "No Thumbnail Found.";
	}
	return apply_filters('easel_display_comic_thumbnail', $output);
}
