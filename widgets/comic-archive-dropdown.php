<?php
/*
Widget Name: Comic Archive Dropdown
Widget URI: http://comiceasel.org/
Description: Display a list of links of the latest comics.
Author: Philip M. Hofer (Frumph)
Version: 1.02
*/

function ceo_comic_archive_jump_to_chapter() {
		$chapters = get_terms( 'chapters', 'orderby=name&order=desc&hide_empty=1' );
		$output = '<form method="get">';
		$output .= '<select onchange="document.location.href=this.options[this.selectedIndex].value;">';
		$level = 1;
		$output .= '<option class="level-0" value="">'.__('&nbsp;Select Story&nbsp;&nbsp;','comiceasel').'</option>';
		if (!is_null($chapters)) {
			foreach($chapters as $chapter) {
				$args = array(
						'numberposts' => 1,
						'post_type' => 'comic',
						'orderby' => 'post_date',
						'order' => 'ASC',
						'post_status' => 'publish',
						'chapters' => $chapter->slug,
						);					
				$qposts = get_posts( $args );
				if (is_array($qposts)) {
					$qposts = reset($qposts);
					$output .='<option class="level-'.$level.'" value="'.get_permalink($qposts->ID).'">'.$chapter->name.'</option>';
				}
				wp_reset_query();
				$level++;
			}
		}
		$output .= '</select>';
		$output .= '<noscript>';
		$output .= '<div><input type="submit" value="View" /></div>';
		$output .= '</noscript>';
		$output .= '</form>';
		echo $output;
}

class ceo_comic_archive_dropdown_widget extends WP_Widget {
	
	function ceo_comic_archive_dropdown_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Display dropdown list of comic chapters.','easel') );
			$this->WP_Widget(__CLASS__, __('Comic Easel - Comic Chapters','easel'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		global $post;
		extract($args, EXTR_SKIP); 
		echo $before_widget;
		$title = empty($instance['title']) ? __('Comic Chapters','easel') : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }; 
		ceo_comic_archive_jump_to_chapter();
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','easel'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
	}
}

add_action( 'widgets_init', create_function('', 'return register_widget("ceo_comic_archive_dropdown_widget");') );

?>