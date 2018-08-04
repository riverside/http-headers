<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Access-Control-Allow-Headers
		<p class="description"><?php _e('The Access-Control-Allow-Headers header is returned by the server in a response to a preflight request and informs the browser about the HTTP headers that can be used in the actual request.', 'http-headers'); ?></p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Access-Control-Allow-Credentials</legend>
			<?php
			$access_control_allow_headers = get_option('hh_access_control_allow_headers', 0);
			foreach ($bools as $k => $v)
			{
				?><p><label><input type="radio" class="http-header" name="hh_access_control_allow_headers" value="<?php echo $k; ?>"<?php checked($access_control_allow_headers, $k); ?> /> <?php echo $v; ?></label></p><?php
			}
			?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-acah' ); ?>
		<?php do_settings_sections( 'http-headers-acah' ); ?>
		<table><tbody><tr>
		<?php
		$items = array('Accept', 'Accept-Charset', 'Accept-Encoding', 'Accept-Language', 'Accept-Datetime', 'Authorization', 'Cache-Control', 'Connection', 'Permanent', 'Cookie', 'Content-Length', 'Content-MD5', 'Content-Type', 'Date', 'Expect', 'Forwarded', 'From', 'Host', 'Permanent', 'If-Match', 'If-Modified-Since', 'If-None-Match', 'If-Range', 'If-Unmodified-Since', 'Max-Forwards', 'Origin', 'Pragma', 'Proxy-Authorization', 'Range', 'Referer', 'TE', 'User-Agent', 'Upgrade', 'Via', 'Warning', 'X-Requested-With', 'DNT', 'X-Forwarded-For', 'X-Forwarded-Host', 'X-Forwarded-Proto', 'Front-End-Https', 'X-Http-Method-Override', 'X-ATT-DeviceId', 'X-Wap-Profile', 'Proxy-Connection', 'X-UIDH', 'X-Csrf-Token', 'X-PINGOTHER');
		$access_control_allow_headers_value = get_option('hh_access_control_allow_headers_value');
		if (!$access_control_allow_headers_value)
		{
			$access_control_allow_headers_value = array();
		}
		foreach ($items as $i => $item) {
			if ($i % 3 === 0) {
				?></tr><tr><?php
			}
			?><td><label><input type="checkbox" class="http-header-value" name="hh_access_control_allow_headers_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $access_control_allow_headers_value) ? NULL : ' checked'; ?><?php echo $access_control_allow_headers == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
		}
		?>
		</tr></tbody></table>
	</td>
</tr>