<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Access-Control-Allow-Headers
		<p class="description"><?php _e('The Access-Control-Allow-Headers header is returned by the server in a response to a preflight request and informs the browser about the HTTP headers that can be used in the actual request.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Headers"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
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
		$access_control_allow_headers_value = get_option('hh_access_control_allow_headers_value');
		if (!$access_control_allow_headers_value)
		{
			$access_control_allow_headers_value = array();
		}
		$i = 0;
        array_unshift($headers_list, '*');
		foreach ($headers_list as $item) {
		    if (in_array($item, $cors_safe_request_headers)) {
		        continue;
            }
			if ($i % 3 === 0) {
				?></tr><tr><?php
			}
			?><td><label><input type="checkbox" class="http-header-value" name="hh_access_control_allow_headers_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $access_control_allow_headers_value) ? NULL : ' checked'; ?><?php echo $access_control_allow_headers == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
            $i += 1;
		}
		?>
		</tr></tbody></table>
        <table><tbody>
        <?php
        $access_control_allow_headers_custom = get_option('hh_access_control_allow_headers_custom');
        if (is_array($access_control_allow_headers_custom))
        {
            foreach ($access_control_allow_headers_custom as $header)
            {
                ?>
                <tr>
                    <td><input type="text" name="hh_access_control_allow_headers_custom[]"
                               class="http-header-value" size="35"
                               value="<?php echo esc_attr($header); ?>"<?php echo $access_control_allow_headers == 1 ? NULL : ' readonly'; ?> />
                    </td>
                    <td>
                        <button type="button" class="button button-small hh-btn-delete-ac"
                                title="<?php esc_attr_e('Delete', 'http-headers'); ?>">x</button>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        <tr>
            <td colspan="2">
                <button type="button" class="button hh-btn-add-ac" data-name="hh_access_control_allow_headers_custom[]">+ <?php _e('Add header', 'http-headers'); ?></button>
            </td>
        </tr>
        </tbody></table>
	</td>
</tr>