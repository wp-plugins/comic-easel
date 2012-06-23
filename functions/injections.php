<?php

// Injected with a poison.
add_action('comic-post-foot', 'ceo_display_edit_link');
add_action('comic-area', 'ceo_display_comic_area');
add_action('comic-post-info', 'ceo_display_comic_chapters');
add_action('comic-post-info', 'ceo_display_comic_locations');
add_action('comic-post-info', 'ceo_display_comic_characters');
add_action('comic-mini-navigation', 'ceo_inject_mini_navigation');
add_action('comic-blog-area', 'ceo_display_comic_post_home');
add_action('wp_head', 'ceo_facebook_comic_thumbnail');
// add_action('comic-post-foot', 'ceo_display_related_comics');

function ceo_display_edit_link() {
	global $post;
	if ($post->post_type == 'comic') {
		echo '<a href="'.get_edit_post_link().'">'.__('Edit Comic.','comiceasel')."</a><br />\r\n";
	}
}

function ceo_display_comic_chapters($post_category) {
	global $post;
	if ($post->post_type == 'comic') {
		$before = '<div class="comic-chapter">Story: ';
		$sep = ', '; 
		$after = '</div>';
		$post_category = get_the_term_list( $post->ID, 'chapters', $before, $sep, $after );
	}
	echo apply_filters('ceo_display_comic_chapters', $post_category);
}

function ceo_display_comic_navigation() {
	global $post, $wp_query;
	if (ceo_pluginfo('navigate_only_chapters')) {
		$first_comic = ceo_get_first_comic_in_chapter_permalink();
		$last_comic = ceo_get_last_comic_in_chapter_permalink();
		$next_comic = ceo_get_next_comic_in_chapter_permalink();
		$prev_comic = ceo_get_previous_comic_in_chapter_permalink();		
	} else {
		$first_comic = ceo_get_first_comic_permalink();
		$last_comic = ceo_get_last_comic_permalink();
		$next_comic = ceo_get_next_comic_permalink();
		$prev_comic = ceo_get_previous_comic_permalink();
	}
	$first_text = __('&lsaquo;&lsaquo; First','comiceasel');
	$last_text = __('Last &rsaquo;&rsaquo;','comiceasel'); 
	$next_text = __('Next &rsaquo;','comiceasel');
	$prev_text = __('&lsaquo; Prev','comiceasel');
	
	?>
	<table id="comic-nav-wrapper">
		<tr class="comic-nav-container">
			<td class="comic-nav"><?php if ( get_permalink() != $first_comic ) { ?><a href="<?php echo $first_comic ?>" class="comic-nav-first<?php if ( get_permalink() == $first_comic ) { ?> comic-nav-inactive<?php } ?>"><?php echo $first_text; ?></a><?php } else { echo $first_text; } ?></td>
			<td class="comic-nav"><?php if ($prev_comic) { ?><a href="<?php echo $prev_comic ?>" class="comic-nav-previous<?php if (!$prev_comic) { ?> comic-nav-inactive<?php } ?>"><?php echo $prev_text; ?></a><?php } else { echo $prev_text; } ?></td>
<?php if (ceo_pluginfo('enable_comment_nav')) { ?>
			<td class="comic-nav"><a href="<?php comments_link(); ?>" class="comic-nav-comments" title="<?php the_title(); ?>"><?php _e('Comments','comiceasel'); ?>(<span class="comic-nav-comment-count"><?php comments_number( '0', '1', '%' ); ?></span>)</a></td>
<?php } ?>
<?php if (ceo_pluginfo('enable_random_nav')) { ?>
			<td class="comic-nav"><a href="<?php bloginfo('url') ?>?random&nocache=1" class="comic-nav-random" title="Random Comic"><?php _e('Random','comiceasel'); ?></a></td>
<?php } ?>
	<td class="comic-nav"><?php if ($next_comic) { ?><a href="<?php echo $next_comic ?>" class="comic-nav-next<?php if (!$next_comic) { ?> comic-nav-inactive<?php } ?>"><?php echo $next_text; ?></a><?php } else { echo $next_text; } ?></td>
	<td class="comic-nav"><?php if ( get_permalink() != $last_comic ) { ?><a href="<?php echo $last_comic ?>" class="comic-nav-last<?php if ( get_permalink() == $last_comic ) { ?> comic-nav-inactive<?php } ?>"><?php echo $last_text; ?></a><?php } else { echo $last_text; } ?></td>
<?php if (ceo_pluginfo('enable_chapter_nav')) { ?>				
			<td class="comic-nav comic-nav-jumpto"><?php ceo_comic_archive_jump_to_chapter(); ?></td>
<?php } ?>
		</tr>
<?php if (ceo_pluginfo('enable_embed_nav')) { ?>
		<tr>
			<td class="comic-nav" colspan="15">
				<?php 
					$post_image_id = get_post_thumbnail_id($post->ID);
					$thumbnail = wp_get_attachment_image_src( $post_image_id, 'full', false);
					if (is_array($thumbnail)) { 
						$thumbnail = reset($thumbnail);
						echo $thumbnail;
					}
				?>
			</td>
		</tr>
<?php } ?> 
	</table>
	<?php
	wp_reset_query();
}

// This is used inside ceo_display_comic_area()
function ceo_display_comic_wrapper() {
	global $post, $wp_query;
	if ($post->post_type == 'comic') { ?>
		<div id="comic-wrap" class="comic-id-<?php echo $post->ID; ?>">
			<div id="comic-head">
				<?php ceo_get_sidebar('over-comic'); ?>
			</div>
			<?php ceo_get_sidebar('left-of-comic'); ?>
			<div id="comic">
				<?php echo ceo_display_comic(); ?>
			</div>
			<?php ceo_get_sidebar('right-of-comic'); ?>
			<div id="comic-foot">
				<?php ceo_get_sidebar('under-comic'); ?>
				<?php if (!ceo_pluginfo('disable_default_nav')) ceo_display_comic_navigation(); ?>
			</div>
			<div class="clear"></div>
		</div>
	<?php }
}

function ceo_display_comic_locations() {
	global $post;
	if ($post->post_type == 'comic') {
		$before = '<div class="comic-locations">Location: ';
		$sep = ', '; 
		$after = '</div>';
		$output = get_the_term_list( $post->ID, 'locations', $before, $sep, $after );
		echo apply_filters('ceo_display_comic_locations', $output);
	}
}

function ceo_display_comic_characters() {
	global $post;
	if ($post->post_type == 'comic') {
		$before = '<div class="comic-characters">Characters: ';
		$sep = ', '; 
		$after = '</div>';
		$post_characters = get_the_term_list( $post->ID, 'characters', $before, $sep, $after );
		echo apply_filters('ceo_display_comic_characters', $post_characters);		
	}
}

// add_action('easel-display-the-content-archive-before', 'ceo_inject_thumbnail_into_archive_posts');
// add_action('easel-display-the-content-before', 'ceo_inject_thumbnail_into_archive_posts');

function ceo_inject_thumbnail_into_archive_posts() {
	global $post;
	if ($post->post_type == 'comic') {
		echo '<p>'. str_replace('alt=', 'class="aligncenter" alt=', ceo_display_comic_thumbnail('medium', $post, true, 320)) . '</p>';
	}
}

// Inject into the menubar some mini navigation
function ceo_inject_mini_navigation() {
	global $post;
	if (!ceo_pluginfo('disable_mininav')) {
		$next_comic = $prev_comic = '';
		if ((is_home() || is_front_page()) && !is_paged() && !ceo_pluginfo('disable_comic_on_home_page')) {
			$wp_query->in_the_loop = true; $comicFrontpage = new WP_Query(); $comicFrontpage->query('post_type=comic&showposts=1');
			while ($comicFrontpage->have_posts()) : $comicFrontpage->the_post();
				$next_comic = ceo_get_next_comic_permalink();
				$prev_comic = ceo_get_previous_comic_permalink();
			endwhile;
		} elseif (!empty($post) && $post->post_type == 'comic') {
			$next_comic = ceo_get_next_comic_permalink();
			$prev_comic = ceo_get_previous_comic_permalink();
		}
		if (!empty($next_comic) || !empty($prev_comic)) {
			$next_text = __('&rsaquo;','comiceasel');
			$prev_comic = ceo_get_previous_comic_permalink();
			$prev_text = __('&lsaquo;','comiceasel');
			$output = '<div class="mininav-wrapper">'."\r\n";
			if (!empty($prev_comic))
				$output .= '<span class="mininav-prev"><a href="'.$prev_comic.'">'.$prev_text.'</a></span>';
			if (!empty($next_comic))
				$output .= '<span class="mininav-next"><a href="'.$next_comic.'">'.$next_text.'</a></span>';
			$output .= '</div>'."\r\n";
			echo apply_filters('ceo_inject_mini_navigation', $output);
		}
	}
}

function ceo_display_comic_post_home() { 
	global $wp_query, $post;
	if ((is_home() || is_front_page()) && !is_paged() && !ceo_pluginfo('disable_comic_blog_on_home_page')) { 
		$wp_query->in_the_loop = true; $comicFrontpage = new WP_Query(); $comicFrontpage->query('post_type=comic&showposts=1');
		while ($comicFrontpage->have_posts()) : $comicFrontpage->the_post();
			if (function_exists('comicpress_display_post')) {
				comicpress_display_post();
			} elseif (function_exists('easel_display_post')) {
				easel_display_post();
			} elseif (function_exists('comic_easel_custom_display_post')) {
				comic_easel_custom_display_post();
			} else ceo_display_comic_post();
		endwhile;
		if (ceo_pluginfo('enable_comments_on_homepage')) {			
			global $withcomments; $withcomments = true;
			comments_template('', true);
		}
		wp_reset_query();
	}
}

function ceo_display_comic_post() {
global $post, $wp_query; ?>
	<div <?php post_class(); ?>>
		<div class="comic-post-head"></div>
		<div class="comic-post-content">
			<div class="comic-post-text post-title">
				<h2 class="comic-post-title entry-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div>
			<div class="comic-post-info">
				<?php do_action('comic-post-info'); ?>

			</div>
				<div class="clear"></div>
				<div class="entry">
					<?php the_content(); ?>
					<div class="clear"></div>
				</div>
				<?php wp_link_pages(array('before' => '<div class="linkpages"><span class="linkpages-pagetext">Pages:</span> ', 'after' => '</div>', 'next_or_number' => 'number')); ?>
				<div class="clear"></div>
				<div class="comic-post-extras">
					<?php 
						do_action('comic-post-extras');
					?>
					<div class="clear"></div>
				</div>
			</div>
			<div class="comic-post-foot"></div>
		</div>
<?php 
}

function ceo_facebook_comic_thumbnail() {
	global $post;
	if (!empty($post) && $post->post_type == 'comic') {
		$post_image_id = get_post_thumbnail_id($post->ID);
		$thumbnail = wp_get_attachment_image_src( $post_image_id, 'thumbnail', false);
		if (is_array($thumbnail)) { 
			$thumbnail = reset($thumbnail);
			echo '<meta property="og:image" content="'.$thumbnail.'" />'."\r\n";
		}
	}
}

function ceo_display_related_comics() {
global $post, $wp_query;
	if ($post->post_type == 'comic') {
		$do_not_duplicate[] = $post->ID;
		ceo_Protect();
		$all_terms = array();
		$character_terms = wp_get_post_terms( $post->ID, 'characters' );
		if (is_array($character_terms) && (count($character_terms) > 0) && !is_wp_error($character_terms)) {
			$all_terms = array_merge( $all_terms, $character_terms );
		}
		$location_terms = wp_get_post_terms( $post->ID, 'locations' );
		if (is_array($location_terms) && (count($location_terms) > 0) && !is_wp_error($location_terms)) {
			$all_terms = array_merge( $all_terms, $location_terms );
		}
		$post_tag_terms = wp_get_post_terms( $post->ID, 'post_tag' );
		if (is_array($post_tag_terms) && (count($post_tag_terms) > 0) && !is_wp_error($post_tag_terms)) {
			$all_terms = array_merge( $all_terms, $post_tag_terms );
		}
		if (is_array($all_terms) && !is_wp_error($all_terms) && (count($all_terms) > 0)) {
			$loop_count = 1;
			shuffle($all_terms);
			foreach ($all_terms as $term) {
				$args = array(
					'numberposts' => 5,
					'post_type' => 'comic',
					'orderby' => 'post_date',
					'order' => 'ASC',
					'post_status' => 'publish',
					$term->taxonomy => $term->slug,
					'post__not_in' => $do_not_duplicate
				);
				$qposts = get_posts( $args );
				if (is_array($qposts) && !is_wp_error($qposts)) {
					foreach ($qposts as $post) {
						$loop_count++;
						if ($loop_count > 4) break;
						$post_output .= $post->post_title."<br />\r\n";
						
					}
				}
				if ($loop_count > 4) break;
			}
			$output = '<br /><h4>'.__('Related Comics')."</h4>\r\n".$post_output;
			ceo_UnProtect();
		}
	}
	echo $output;
}