<?php
/*
Widget Name: Scheduled Posts
Widget URI: http://comiceasel.com/
Description: Display a list of comic posts that are due to be scheduled.
Author: Philip M. Hofer (Frumph)
Author URI: http://frumph.net/
Version: 1.03
*/

class ceo_scheduled_comics_widget extends WP_Widget {
	
	function ceo_scheduled_comics_widget($skip_widget_init = false) {
		if (!$skip_widget_init) {
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Display a list of comics that are scheduled to be published.','comiceasel') );
			$this->WP_Widget(__CLASS__, __('Comic Easel - Scheduled Posts','comiceasel'), $widget_ops);
		}
	}
	
	function widget($args, $instance) {
		Protect();
		extract($args, EXTR_SKIP); 
		echo $before_widget;
		$title = empty($instance['title']) ? __('Scheduled Comics','comiceasel') : apply_filters('widget_title', $instance['title']); 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }; 
		$scheduled_posts = get_posts('post_status=future&numberposts=-1&post_type=comic');
		if (empty($scheduled_posts)) {
			echo '<ul><li>'.__('None','comiceasel').'</li></ul>';
		} else { ?>
			<ul>
			<?php foreach($scheduled_posts as $post) : ?>
				<li><span class="scheduled-post-date"><?php echo date('m/d/Y',strtotime($post->post_date)); ?></span> <span class="scheduled-post-title"><?php echo $post->post_title; ?></span></li>
			<?php endforeach; ?>
			</ul>
		<?php } 
		echo $after_widget;
		UnProtect();
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
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','comiceasel'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("ceo_scheduled_comics_widget");') );

?>