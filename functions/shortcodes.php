<?php
/* Short Codes go Here */

add_shortcode( 'cast-page', 'ceo_cast_page' );

function ceo_cast_page( $atts, $content = null ) {
	$cast_output = '';
	$characters = get_terms( 'characters', 'orderby=count&hide_empty=0' );
	if (is_array($characters)) {
		foreach ($characters as $character) {
			$cast_output .= '<div class="cast-box">';
			$cast_output .= '<div class="cast-pic character-'.$character->slug.'">';
			$cast_output .= '</div>';
			$cast_output .= '<div class="cast-info cast-info-'.$character->slug.'">';
			$cast_output .= '<h4 class="cast-name">'.$character->name.'</h4>';
			$cast_output .= '<p class="cast-description">';
			$cast_output .= $character->description;
			$cast_output .= '</p>';
			$cast_output .= '<p class="cast-comic-count">';
			$cast_output .= '<i>Total Comics in: <strong>'.$character->count.'</strong></i>';
			$cast_output .= '</p>';
			$cast_output .= '<p class="cast-comic-link">';
			$cast_output .= '<a href="'.get_term_link($character->slug, 'characters').'">';
			$cast_output .= 'List Comics In.';
			$cast_output .= '</a>';
			$cast_output .= '</p>';
			
			$cast_output .= '</div>';
			$cast_output .= '<div style="clear:both;"></div>';
			$cast_output .= '</div>';
		}
	} else {
		$cast_output = 'You do not have any characters yet.';
	}
	return $cast_output;
}



?>