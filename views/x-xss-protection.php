<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
	<th scope="row">X-XSS-Protection
		<p class="description"><?php _e("This header enables the Cross-site scripting (XSS) filter built into most recent web browsers. It's usually enabled by default anyway, so the role of this header is to re-enable the filter for this particular website if it was disabled by the user.", 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">X-XSS-Protection</legend>
		<?php
		$x_xxs_protection = get_option('hh_x_xxs_protection', 0);
		foreach ($bools as $k => $v)
		{
			?><p><label><input type="radio" class="http-header" name="hh_x_xxs_protection" value="<?php echo $k; ?>"<?php checked($x_xxs_protection, $k, true); ?> /> <?php echo $v; ?></label></p><?php
		}
		?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-xss' ); ?>
		<?php do_settings_sections( 'http-headers-xss' ); ?>
		<select name="hh_x_xxs_protection_value" class="http-header-value"<?php echo $x_xxs_protection == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array('0', '1', '1; mode=block', '1; report=');
		$x_xxs_protection_value = get_option('hh_x_xxs_protection_value');
		foreach ($items as $item)
		{
			?><option value="<?php echo $item; ?>"<?php selected($x_xxs_protection_value, $item); ?>><?php echo $item; ?></option><?php
		}
		?>
		</select>
		<input type="text" name="hh_x_xxs_protection_uri" class="http-header-value" placeholder="Reporting URI" value="<?php echo esc_attr(get_option('hh_x_xxs_protection_uri')); ?>"<?php echo $x_xxs_protection == 1 && $x_xxs_protection_value == '1; report=' ? NULL : ' style="display: none" readonly'; ?> />
	</td>
</tr>