<?php

// Path to the comic files
$comic_path = ceo_pluginfo('comic_path');

// Array to store the directory information
$files_found = array();

$valid_files = array('jpg','bmp','gif','png');

// At this point we need to check if the $comic_path actually exists and if it doesn't create it using the wordpress functions

// Open the directory where comics are 
if ($handle = opendir($comic_path)) {
	
	while (false !== ($file = readdir($handle))) {
		if ( ($file != ".") && ($file != "..")) {
			$info = pathinfo($file);
			$extension = array($info['extension']);
			if (array_intersect($extension,$valid_files)) {
				$files_found[] = $file;
			}
		}
	}
	closedir($handle);
} 

?>

<div class="wrap">
	<h2>Comic library</h2>
	 <strong><?php echo count($files_found); ?> comic images found.</strong>
	<table width="100%">
	<tr>
		<td style="width:300px;" valign="top">
			<form action="" method="post">
			<table class="widefat">
			<thead>
				<tr>
					<th colspan="3"><?php _e('Upload','comiceasel'); ?></th>
				</tr>
			</thead>
			<tr>
				<td>
					Input box.
				</td>
				<td align="right">
					<?php wp_nonce_field('ceo-library-options'); ?>
					<input name="save" type="submit" value="Upload" />
				</td>
			</tr>
			<tr class="alternate">
				<td colspan="2" style="font-weight:700;">
					Upload Path:
				</td>
			</tr>
			<tr>
				<td colspan="2" style="font-size:10px;">
					<?php echo ceo_pluginfo('comic_path'); ?>
				</td>
			</tr>
			<tr class="alternate">
				<td colspan="2" style="font-weight:700;">
					Directory Handle:
				</td>
			</tr>
			<tr>
				<td colspan="2" style="font-size:10px;">
					<?php var_dump($handle); ?>
				</td>
			</tr>
			</table>
			</form>
		</td>
		<td valign="top">
			<form action="" method="post">
			<table class="widefat">
			<thead>
				<tr>
					<th>Filename</th>
					<th><?php _e('Comic Image','comiceasel'); ?></th>
				</tr>
			</thead>
			<tr>
	<?php
		for ($count = 0; $count < count($files_found); $count ++) {
	?>
				<tr>
					<td>
						<?php echo $files_found[$count]; ?>
					</td>
					<td>
						<?php echo ceo_display_comic_by_filename($files_found[$count]); ?>
					</td>
				</tr>
	<?php
		}
	?>
		</table>
		</form>
		</td>
	</tr>
	</table>
</div>

