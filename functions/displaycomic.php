<?php

function ceo_display_comic($size = 'full') {
	global $post;
	$post_image_id = get_post_thumbnail_id($post->ID);
	if ($post_image_id) {
		$thumbnail = wp_get_attachment_image_src( $post_image_id, $size, false);
		$thumbnail = reset($thumbnail);
		$hovertext = ceo_the_hovertext();
		$output = '<img src="'.$thumbnail.'" alt="'.$hovertext.'" title="'.$hovertext.'" />';
		return apply_filters('ceo_comics_display_comic', $output);
	} else
		return "No Comic (featured image) Found.  Set One.";
}

function ceo_the_hovertext($override_post = null) {
	global $post;
	$post_to_use = !is_null($override_post) ? $override_post : $post;
	$hovertext = get_post_meta( $post_to_use->ID, "hovertext", true );
	return (empty($hovertext)) ? get_the_title($post_to_use->ID) : $hovertext;
}


function ceo_display_comic_area() {
	global $wp_query, $post;
	if (is_single()) {
		ceo_display_comic_wrapper();
	} else {
		if (is_home() && !is_paged() && ceo_pluginfo('display_comic_on_home'))  {
			ceo_Protect();
			$comic_args = array(
					'posts_per_page' => 1,
					'post_type' => 'comic'
					);
			$wp_query->in_the_loop = true; $comicFrontpage = new WP_Query(); $comicFrontpage->query($comic_args);
			while ($comicFrontpage->have_posts()) : $comicFrontpage->the_post();
				ceo_display_comic_wrapper();
			endwhile;
			ceo_UnProtect();
		}
	}
}

function ceo_display_comic_post_home() { 
	global $wp_query;
	if (is_home() && ceo_pluginfo('display_comic_post_on_home')) { 
		if (!is_paged())  { 
			ceo_Protect();
			$posts = &query_posts('post_type=comic&showposts=1');
			while (have_posts()) : the_post();
				ceo_display_comic_post();
			endwhile;
			if (ceo_pluginfo('enable_comments_on_homepage')) {
				$withcomments = 1;
				comments_template('', true);
			}
			ceo_UnProtect();
			?>
			<div id="blogheader"></div>	
		<?php }
	}
}

// Do the thumbnail display functions here.
if (!function_exists('ceo_display_comic_thumbnail')) {
	function ceo_display_comic_thumbnail($override_post = null, $type = 'thumbnail') {
		global $post;
		$thumbnail = '';
		$post_to_use = !empty($override_post) ? $override_post : $post;
		
		if ( has_post_thumbnail($post_to_use->ID) ) {
			$output =  "<a href=\"".get_permalink($post_to_use->ID)."\" rel=\"bookmark\" title=\"Permanent Link to ".get_the_title()."\">".get_the_post_thumbnail($post_to_use->ID, 'thumbnail')."</a>\r\n";
		} else {
			$output = "No Thumbnail Found.";	
		}
		return apply_filters('easel_display_comic_thumbnail', $output);
	}
}

function ceo_display_comic_post() {
global $post, $wp_query; ?>
	<div <?php post_class(); ?>>
		<div class="comic-post-head"></div>
		<div class="comic-post-content">
			<div class="comic-post-info">
				<?php do_action('comic-post-info'); ?>
				<div class="comic-post-text post-title">
						<h2 class="comic-post-title entry-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
				</div>
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
						do_action('easel-post-extras');
					?>
					<div class="clear"></div>
				</div>
			</div>
			<div class="comic-post-foot"></div>
		</div>
<?php 
}