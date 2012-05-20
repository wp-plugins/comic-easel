<p class="alignleft">
	<h2><?php _e('Comic Easel - Config','comiceasel'); ?></h2>
</p>
<div class="clear"></div>
<?php
$tab = '';
if (isset($_GET['tab'])) $tab = wp_filter_nohtml_kses($_GET['tab']);

/* <div id="eadmin-headericon" style="background: url('<?php echo ceo_pluginfo('plugin_url') ?>/images/comic_easel_small.png') no-repeat; width: 200px; height: 200px; "></div> */
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'easel_reset') {
	delete_option('easel-options');
	global $ceo_pluginfo;
	$ceo_pluginfo = array();
	ceo_load_options('reset');
	?>
			<div id="message" class="updated"><p><strong><?php _e('Easel Settings RESET!','easel'); ?></strong></p></div>
	<?php
}

$ceo_options = get_option('comiceasel-config');
	if ( isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'update-options') ) {
		
		if ($_REQUEST['action'] == 'ceo_save_options') {
/*
			foreach (array(
				'layout',
				'scheme'
					) as $key) {
							if (isset($_REQUEST[$key])) 
								$easel_options[$key] = wp_filter_nohtml_kses($_REQUEST[$key]);
			}
*/
			foreach (array(
				'add_dashboard_frumph_feed_widget',
				'disable_comic_on_home_page',
				'disable_comic_blog_on_home_page'
			) as $key) {
				if (!isset($_REQUEST[$key])) $_REQUEST[$key] = 0;
				$easel_options[$key] = (bool)( $_REQUEST[$key] == 1 ? true : false );
			}
			
			$tab = 'General';
			update_option('comiceasel-config', $easel_options);
		}
		if ($tab) { ?>
			<div id="message" class="updated"><p><strong><?php _e('Comic Easel Settings SAVED!','comiceasel'); ?></strong></p></div>
			<script>function hidemessage() { document.getElementById('message').style.display = 'none'; }</script>
		<?php }
	} 
	$ceo_options = get_option('comiceasel-config');
?>
<div class="wrap">

	<div id="comiceasel-config">
		<form method="post" id="myForm-comiceasel" enctype="multipart/form-data">
		<?php wp_nonce_field('update-options') ?>

			<div class="easel-options">
			
				<table class="widefat">
					<thead>
						<tr>
							<th colspan="3"><?php _e('Configuration','comiceasel'); ?></th>
						</tr>
					</thead>
					<tr class="alternate">
						<th scope="row"><label for="add_dashboard_frumph_feed_widget"><?php _e('Enable Dashboard Feed to Frumph.NET','comiceasel'); ?></label></th>
						<td>
							<input id="add_dashboard_frumph_feed_widget" name="add_dashboard_frumph_feed_widget" type="checkbox" value="1" <?php checked(true, $ceo_options['add_dashboard_frumph_feed_widget']); ?> />
						</td>
						<td>
							<?php _e('This is a feed that shows what is happening on Frumph.NET','comiceasel'); ?>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="disable_comic_on_home_page"><?php _e('Disable Comic on the Home Page?','comiceasel'); ?></label></th>
						<td>
							<input id="disable_comic_on_home_page" name="disable_comic_on_home_page" type="checkbox" value="1" <?php checked(true, $ceo_options['disable_comic_on_home_page']); ?> />
						</td>
						<td>
							<?php _e('Checking this will stop the display of the comic and comic area on the home page','comiceasel'); ?>
						</td>
					</tr>
					<tr class="alternate">
						<th scope="row"><label for="disable_comic_blog_on_home_page"><?php _e('Display Comic Post on the Home Page?','comiceasel'); ?></label></th>
						<td>
							<input id="disable_comic_blog_on_home_page" name="disable_comic_blog_on_home_page" type="checkbox" value="1" <?php checked(true, $ceo_options['disable_comic_blog_on_home_page']); ?> />
						</td>
						<td>
							<?php _e('Enabling this will display the comic post on the home page.','comiceasel'); ?>
						</td>
					</tr>
				</table>
					
			</div>
			
			<br />
			<div class="ceo-options-save">
				<div class="ceo-major-publishing-actions">
					<div class="ceo-publishing-action">
						<input name="ceo_save_options" type="submit" class="button-primary" value="Save Settings" />
						<input type="hidden" name="action" value="ceo_save_options" />
					</div>
					<div class="clear"></div>
				</div>
			</div>

		</form>

	</div>
</div>