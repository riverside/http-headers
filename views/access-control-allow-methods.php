<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Access-Control-Allow-Methods
		<p class="description"><?php _e('The Access-Control-Allow-Methods header is returned by the server in a response to a preflight request and informs the browser about the HTTP methods that can be used in the actual request.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Access-Control-Allow-Methods</legend>
        <?php
        $access_control_allow_methods = get_option('hh_access_control_allow_methods', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_access_control_allow_methods" value="<?php echo $k; ?>"<?php checked($access_control_allow_methods, $k); ?> /> <?php echo $v; ?></label></p><?php
		}
		?>
		</fieldset>
	</td>
	<td>
	<?php settings_fields( 'http-headers-acam' ); ?>
	<?php do_settings_sections( 'http-headers-acam' ); ?>
	<?php
	$items = array('*', 'GET', 'POST', 'OPTIONS', 'HEAD', 'PUT', 'DELETE', 'TRACE', 'CONNECT', 'PATCH');
	$access_control_allow_methods_value = get_option('hh_access_control_allow_methods_value');
	if (!$access_control_allow_methods_value)
	{
		$access_control_allow_methods_value = array();
	}
	foreach ($items as $item)
	{
		?><p><label><input type="checkbox" class="http-header-value" name="hh_access_control_allow_methods_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $access_control_allow_methods_value) ? NULL : ' checked'; ?><?php echo $access_control_allow_methods == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></p><?php
	}
	?>
	</td>
</tr>