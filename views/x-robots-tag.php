<?php
if (!defined('ABSPATH')) {
	exit;
}
?>
<tr valign="top">
	<th scope="row">X-Robots-Tag
		<p class="description"><?php _e('The X-Robots-Tag HTTP header is used to indicate how a web page is to be indexed within public search engine results. The header is effectively equivalent to <code>&lt;meta name="robots" content="..."&gt;</code>.', 'http-headers'); ?></p>
		<hr>
		<p class="description"><?php _e('Read more at', 'http-headers'); ?>
			<a target="_blank" href="https://developers.google.com/search/docs/advanced/robots/robots_meta_tag"><?php _e('Google Search Central', 'http-headers'); ?></a>
		</p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">X-Robots-Tag</legend>
			<?php
			$x_robots_tag = get_option('hh_x_robots_tag', 0);
			foreach ($bools as $k => $v)
			{
				?><p><label><input type="radio" class="http-header" name="hh_x_robots_tag" value="<?php echo $k; ?>"<?php checked($x_robots_tag, $k); ?> /> <?php echo $v; ?></label></p><?php
			}
			?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-rob' ); ?>
		<?php do_settings_sections( 'http-headers-rob' ); ?>
		<?php
		$items = array(
			'all' => 'bool',
			'noindex' => 'bool',
			'nofollow' => 'bool',
			'none' => 'bool',
			'noarchive' => 'bool',
			'nosnippet' => 'bool',
			'max-snippet' => 'number',
			'max-image-preview' => 'setting',
			'max-video-preview' => 'number',
			'notranslate' => 'bool',
			'noimageindex' => 'bool',
			'unavailable_after' => 'datetime',
		);
		?>
		<table>
			<?php
			$x_robots_tag_value = get_option('hh_x_robots_tag_value');
			if (!$x_robots_tag_value)
			{
				$x_robots_tag_value = array();
			}
			foreach ($items as $item => $type)
			{
				?>
				<tr>
					<td><label for="hh_x_robots_tag_value_<?php echo $item; ?>"><?php echo $item; ?></label></td>
					<td><?php
						switch ($type) {
							case 'bool':
								?><input type="checkbox" class="http-header-value" name="hh_x_robots_tag_value[<?php echo $item; ?>]"
								         id="hh_x_robots_tag_value_<?php echo $item; ?>"<?php echo $x_robots_tag == 1 ? NULL : ' readonly'; ?>
								         value="1"<?php checked(array_key_exists($item, $x_robots_tag_value), 1, true); ?>><?php
								break;
							case 'number':
								?><input type="number" class="http-header-value" name="hh_x_robots_tag_value[<?php echo $item; ?>]"
								         id="hh_x_robots_tag_value_<?php echo $item; ?>"
								         size="6" min="-1" step="1"<?php echo $x_robots_tag == 1 ? NULL : ' readonly'; ?>
								         value="<?php echo array_key_exists($item, $x_robots_tag_value) && strlen($x_robots_tag_value[$item]) > 0 ? (int) $x_robots_tag_value[$item] : NULL; ?>"><?php
								break;
							case 'setting':
								?><select class="http-header-value" name="hh_x_robots_tag_value[<?php echo $item; ?>]"
								          id="hh_x_robots_tag_value_<?php echo $item; ?>"<?php echo $x_robots_tag == 1 ? NULL : ' readonly'; ?>>
									<option value="">---</option>
									<?php
									foreach (array('none', 'standard', 'large') as $k)
									{
										?><option value="<?php echo $k; ?>"<?php echo array_key_exists($item, $x_robots_tag_value) && $k == $x_robots_tag_value[$item] ? ' selected="selected"' : NULL; ?>><?php echo $k; ?></option><?php
									}
									?>
								</select><?php
								break;
							case 'datetime':
								?><input type="date" class="http-header-value" name="hh_x_robots_tag_value[<?php echo $item; ?>]"
								         id="hh_x_robots_tag_value_<?php echo $item; ?>"<?php echo $x_robots_tag == 1 ? NULL : ' readonly'; ?>
								         value="<?php echo array_key_exists($item, $x_robots_tag_value) && strlen($x_robots_tag_value[$item]) > 0 ? $x_robots_tag_value[$item] : NULL; ?>"><?php
								break;
						}
						?>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
	</td>
</tr>