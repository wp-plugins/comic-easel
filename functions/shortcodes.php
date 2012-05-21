<?php
/* Short Codes go Here */

add_shortcode( 'cast-page', 'ceo_cast_page' );

function ceo_cast_page( $atts, $content = null ) {
	$cast_output = '';
	$characters = get_terms( 'characters', 'orderby=count&hide_empty=1' );
	if (is_array($characters)) {
		foreach ($characters as $character) {
			$cast_output .= '<div class="cast-box">';
			$cast_output .= '<div class="cast-pic character-'.$character->slug.'">';
			$cast_output .= '</div>';
			$cast_output .= '<div class="cast-info cast-info-'.$character->slug.'">';
			$cast_output .= '<h4 class="cast-name"><a href="'.get_term_link($character->slug, 'characters').'">'.$character->name.'</a></h4>';
			$cast_output .= '<p class="cast-description">';
			$cast_output .= $character->description;
			$cast_output .= '</p>';
			$cast_output .= '<p class="cast-character-stats">';
			$cast_output .= '<i>'.__('Comics:','comiceasel').'</i> <strong>'.$character->count.'</strong><br />';
			$args = array(
					'numberposts' => 1,
					'post_type' => 'comic',
					'orderby' => 'post_date',
					'order' => 'ASC',
					'post_status' => 'publish',
					'characters' => $character->slug,
					);					
			$qposts = get_posts( $args );
			if (!empty($qposts)) {
				$first_seen = $qposts[0]->post_title;
				$first_seen_id = $qposts[0]->ID;
				$cast_output .= '<i>'.__('First Appearance:','comiceasel').'</i> <a href="'.get_permalink($first_seen_id).'">'.$first_seen.'</a><br />';
			}
			wp_reset_query();
			$cast_output .= '</p>';
			$cast_output .= '</div>';
			$cast_output .= '<div style="clear:both;"></div>';
			$cast_output .= '</div>';
		}
	} else {
		$cast_output = __('You do not have any characters yet.','comiceasel');
	}
	return $cast_output;
}



?>