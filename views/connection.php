<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
	<th scope="row">Connection
		<p class="description"><?php _e('The Connection general header controls whether or not the network connection stays open after the current transaction finishes. If the value sent is keep-alive, the connection is persistent and not closed, allowing for subsequent requests to the same server to be done.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Connection"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Connection</legend>
			<?php
			$connection = get_option('hh_connection', 0);
	        foreach ($bools as $k => $v)
	        {
	        	?><p><label><input type="radio" class="http-header" name="hh_connection" value="<?php echo $k; ?>"<?php checked($connection, $k); ?> /> <?php echo $v; ?></label></p><?php
	        }
	        ?>
        	</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-con' ); ?>
		<?php do_settings_sections( 'http-headers-con' ); ?>
		<select name="hh_connection_value" class="http-header-value"<?php echo $connection == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array('keep-alive', 'close');
		$connection_value = get_option('hh_connection_value');
		foreach ($items as $item) {
			?><option value="<?php echo $item; ?>"<?php selected($connection_value, $item); ?>><?php echo $item; ?></option><?php
		}
		?>
		</select>
	</td>
</tr>