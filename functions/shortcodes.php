<?php
/* Short Codes go Here */

add_shortcode( 'cast-page', 'ceo_cast_page' );
add_shortcode( 'comic-archive', 'ceo_comic_archive_multi');
// [comic-archive list="default"]

function ceo_cast_page( $atts, $content = null ) {
	$cast_output = '';
	$characters = get_terms( 'characters', 'orderby=count&order=desc&hide_empty=1' );
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

function ceo_comic_archive_multi(  $atts, $content = null ) {
extract( shortcode_atts( array(
				'list' => 0,
				'style' => 0,
				'chapter' => 0,
				'thumbnail' => 0,
				'order' => 'ASC'
				), $atts ) );
	switch ($list) {
		case 1:
// TODO make other list styles ;/
		break;
		case 0:
		default:
			if ($chapter) {
				ceo_archive_list_single($chapter, $order, $thumbnail);
			} else {
				ceo_archive_list_all($order, $thumbnail);
			}
		break;
	}
}

function ceo_archive_list_single($chapter = 0, $order = 'ASC', $thumbnail = 0) {
	$output = '';
	// get chapter from ID#
	$single_chapter = get_term_by('term_id', $chapter, 'chapters');
	if (is_null($single_chapter)) { echo "Invalid Chapter Specified"; return; }
	$output .= '<div class="comic-archive-chapter-wrap">';
	$output .= '<h3 class="comic-archive-chapter">'.$single_chapter->name.'</h3>';
	$output .= '<div class="comic-archive-chapter-description">'.$single_chapter->description.'</div>';
	$args = array(
			'numberposts' => -1,
			'post_type' => 'comic',
			'orderby' => 'post_date',
			'order' => $order,
			'post_status' => 'publish',
			'chapters' => $single_chapter->slug
		);					
	$qposts = get_posts( $args );
	$archive_count = 0;
	$output .= '<ul class="comic-archive-wrap">';
	if ($thumbnail) {
			$output .= '<div class="comic-archive-thumbnail">'.get_the_post_thumbnail($qposts[0]->ID, 'thumbnail').'</div>';
	}
	foreach ($qposts as $qpost) {
		$archive_count++;
		$output .= '<li class="comic-list comic-list-'.$archive_count.'"><span class="comic-archive-date">'.get_the_time('M d, Y', $qpost->ID).'</span><span class="comic-archive-title"><a href="'.get_permalink($qpost->ID).'" rel="bookmark" title="'.__('Permanent Link:','comiceasel').' '.$qpost->post_title.'">'.$qpost->post_title.'</a></span></li>';
	}
	$output .= '</ul>';
	$output .= '<div style="clear:both;"></div></div>';
	wp_reset_query();
	echo apply_filters('ceo_archive_list_single', $output);
}

function ceo_archive_list_all($order = 'ASC', $thumbnail = 0) {
	$output = '';
	$all_chapters = get_terms('chapters');
	if (is_null($all_chapters)) { echo 'There are no chapters available.'; return; }
	$output = '';
	foreach ($all_chapters as $chapter) {
		if ($chapter->count) {
			$output .= '<div class="comic-archive-chapter-wrap">';
			$output .= '<h3 class="comic-archive-chapter">'.$chapter->name.'</h3>';
			$output .= '<div class="comic-archive-chapter-description">'.$chapter->description.'</div>';			
			$args = array(
					'numberposts' => -1,
					'post_type' => 'comic',
					'orderby' => 'post_date',
					'order' => $order,
					'post_status' => 'publish',
					'chapters' => $chapter->slug
					);					
			$qposts = get_posts( $args );
			$archive_count = 0;
			if ($thumbnail) {
				$output .= '<div class="comic-archive-thumbnail">'.get_the_post_thumbnail($qposts[0]->ID, 'thumbnail').'</div>';
			}
			$output .= '<div class="comic-archive-list-wrap">';
			$css_alt = false;
			foreach ($qposts as $qpost) {
				$archive_count++;
				if ($css_alt) { $alternate = ' comic-list-alt'; $css_alt = false; } else { $alternate = ''; $css_alt=true; }
				$output .= '<div class="comic-list comic-list-'.$archive_count.$alternate.'"><span class="comic-archive-date">'.get_the_time('M j, Y', $qpost->ID).'</span><span class="comic-archive-title"><a href="'.get_permalink($qpost->ID).'" rel="bookmark" title="'.__('Permanent Link:','comiceasel').' '.$qpost->post_title.'">'.$qpost->post_title.'</a></span></div>';
			}
			$output .= '</div>';
			$output .= '<div style="clear:both;"></div></div>';
		}
	}
	wp_reset_query();
	echo apply_filters('ceo_archive_list_all', $output);
}


// $all_chapters = get_terms('chapters');
// var_dump($all_chapters);

?>