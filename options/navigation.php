<div id="comiceasel-navigation">

	<form method="post" id="myForm-navigation" enctype="multipart/form-data">
	<?php wp_nonce_field('update-options') ?>

		<div class="comiceasel-options">
		
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="3"><?php _e('Navigation Options','comiceasel'); ?></th>
					</tr>
				</thead>
				<tr class="alternate">
					<th scope="row"><label for="navigate_only_chapters"><?php _e('Navigate through only the chapters and not all comics?','comiceasel'); ?></label></th>
					<td>
						<input id="navigate_only_chapters" name="navigate_only_chapters" type="checkbox" value="1" <?php checked(true, $ceo_options['navigate_only_chapters']); ?> />
					</td>
					<td>
						<?php _e('Enabling this make the navigation only navigate through individual chapters.','comiceasel'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="click_comic_next"><?php _e('Clicking the comic goes to next comic?','comiceasel'); ?></label></th>
					<td>
						<input id="click_comic_next" name="click_comic_next" type="checkbox" value="1" <?php checked(true, $ceo_options['click_comic_next']); ?> />
					</td>
					<td>
						<?php _e('When this is enabled, when the comic is mouse over and clicked it will go to the next comic in the chapter.','comiceasel'); ?>
					</td>
				</tr>
			</table>
				
		</div>
		
		<br />
		<div class="ceo-options-save">
			<div class="ceo-major-publishing-actions">
				<div class="ceo-publishing-action">
					<input name="ceo_save_config" type="submit" class="button-primary" value="Save Settings" />
					<input type="hidden" name="action" value="ceo_save_navigation" />
				</div>
				<div class="clear"></div>
			</div>
		</div>

	</form>

</div>