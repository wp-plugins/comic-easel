<?php

// Injected with a poison.
add_action('comic-post-foot', 'ceo_display_edit_link');
	
function ceo_display_edit_link() {
	global $post;
	if ($post->post_type == 'comic') {
		edit_post_link(__('<br />Edit Comic.','comiceasel'), '', ''); 
	}
}

add_action('comic-post-info', 'ceo_display_comic_chapters');

// TODO: Make this actually output a chapter set that the comic is in, instead of the post-type
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

// var_dump(ceo_pluginfo('disable_comic_on_home_page'));


add_action('comic-area', 'ceo_display_comic_area');

if (!function_exists('ceo_display_comic_navigation')) {
	function ceo_display_comic_navigation() {
		global $post, $wp_query;
		$first_comic = ceo_get_first_comic_permalink();
		$first_text = __('&lsaquo;&lsaquo; First','easel');
		$last_comic = ceo_get_last_comic_permalink();
		$last_text = __('Last &rsaquo;&rsaquo;','easel'); 
		$next_comic = ceo_get_next_comic_permalink();
		$next_text = __('Next &rsaquo;','easel');
		$prev_comic = ceo_get_previous_comic_permalink();
		$prev_text = __('&lsaquo; Prev','easel');
		?>
		<table id="comic-nav-wrapper">
			<tr class="comic-nav-container">
				<td class="comic-nav comic-nav-first <?php if ( get_permalink() == $first_comic ) { ?>comic-nav-inactive<?php } ?>"><?php if ( get_permalink() != $first_comic ) { ?><a href="<?php echo $first_comic ?>"><?php echo $first_text; ?></a><?php } else { echo $first_text; } ?></td>
				<td class="comic-nav comic-nav-previous <?php if (!$prev_comic) { ?>comic-nav-inactive<?php } ?>"><?php if ($prev_comic) { ?><a href="<?php echo $prev_comic ?>"><?php echo $prev_text; ?></a><?php } else { echo $prev_text; } ?></td>
				<td class="comic-nav comic-nav-next <?php if (!$next_comic) { ?>comic-nav-inactive<?php } ?>"><?php if ($next_comic) { ?><a href="<?php echo $next_comic ?>"><?php echo $next_text; ?></a><?php } else { echo $next_text; } ?></td>
				<td class="comic-nav comic-nav-last <?php if ( get_permalink() == $last_comic ) { ?>comic-nav-inactive<?php } ?>"><?php if ( get_permalink() != $last_comic ) { ?><a href="<?php echo $last_comic ?>"><?php echo $last_text; ?></a><?php } else { echo $last_text; } ?></td>
				<td class="comic-nav comic-nav-jumpto"><?php ceo_comic_archive_jump_to_chapter(); ?></td>
			</tr>
		</table>
		<?php
	}
}

// This is used inside ceo_display_comic_area()
function ceo_display_comic_wrapper() {
	global $post, $wp_query;
	if (is_home() && ceo_pluginfo('disable_comic_on_home_page')) return;
	if ($post->post_type == 'comic') { ?>
		<div id="comic-wrap" class="comic-id-<?php echo $post->ID; ?>">
			<div id="comic-head"></div>
			<div id="comic">
				<?php echo ceo_display_comic(); ?>
			</div>
			<div id="comic-foot">
				<?php ceo_display_comic_navigation(); ?>
			</div>
			<div class="clear"></div>
		</div>
	<?php }
}

add_action('comic-post-info', 'ceo_display_comic_locations');

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

add_action('comic-post-info', 'ceo_display_comic_characters');

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

add_action('comic-mini-navigation', 'ceo_inject_mini_navigation');

function ceo_inject_mini_navigation() {
	global $post;
	$next_comic = $prev_comic = '';

	if (is_home() && !is_paged()) {
		$wp_query->in_the_loop = true; $comicFrontpage = new WP_Query(); $comicFrontpage->query('post_type=comic&showposts=1');
		while ($comicFrontpage->have_posts()) : $comicFrontpage->the_post();
			$next_comic = ceo_get_next_comic_permalink();
			$prev_comic = ceo_get_previous_comic_permalink();
		endwhile;
	} else {
		if ($post->post_type == 'comic') {
			$next_comic = ceo_get_next_comic_permalink();
			$prev_comic = ceo_get_previous_comic_permalink();
		}
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

add_action('comic-blog-area', 'ceo_display_comic_post_home');

function ceo_display_comic_post_home() { 
	global $wp_query;
	if (is_home() && !ceo_pluginfo('disable_comic_blog_on_home_page')) { 
		if (!is_paged())  { 
			ceo_Protect();
			$wp_query->in_the_loop = true; $comicFrontpage = new WP_Query(); $comicFrontpage->query('post_type=comic&showposts=1');
			while ($comicFrontpage->have_posts()) : $comicFrontpage->the_post();
				if (function_exists('comicpress_display_post')) {
					comicpress_display_post();
				} elseif (function_exists('easel_display_post')) {
					easel_display_post();
				} else ceo_display_comic_post();
			endwhile;
			if (ceo_pluginfo('enable_comments_on_homepage')) {
				$withcomments = 1;
				comments_template('', true);
			}
			ceo_UnProtect();
		}
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
?>
