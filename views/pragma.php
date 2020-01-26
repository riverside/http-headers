<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
	<th scope="row">Pragma
		<p class="description"><?php _e('The Pragma HTTP/1.0 general header is an implementation-specific header that may have various effects along the request-response chain. It is used for backwards compatibility with HTTP/1.0 caches where the Cache-Control HTTP/1.1 header is not yet present.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Pragma"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Pragma</legend>
			<?php
			$pragma = get_option('hh_pragma', 0);
	        foreach ($bools as $k => $v)
	        {
	        	?><p><label><input type="radio" class="http-header" name="hh_pragma" value="<?php echo $k; ?>"<?php checked($pragma, $k); ?> /> <?php echo $v; ?></label></p><?php
	        }
	        ?>
        	</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-pra' ); ?>
		<?php do_settings_sections( 'http-headers-pra' ); ?>
		<select name="hh_pragma_value" class="http-header-value"<?php echo $pragma == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array('no-cache');
		$pragma_value = get_option('hh_pragma_value');
		foreach ($items as $item) {
			?><option value="<?php echo $item; ?>"<?php selected($pragma_value, $item); ?>><?php echo $item; ?></option><?php
		}
		?>
		</select>
	</td>
</tr>