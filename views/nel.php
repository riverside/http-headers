<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
    <th scope="row">NEL
    	<p class="description"><?php _e('Network Error Logging is a mechanism that can be configured via the NEL HTTP response header. This experimental header allows web sites and applications to opt-in to receive reports about failed (and, if desired, successful) network fetches from supporting browsers.', 'http-headers'); ?></p>
    	<hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Network_Error_Logging"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
    </th>
	<td>
   		<fieldset>
    		<legend class="screen-reader-text">NEL</legend>
        <?php
        $nel = get_option('hh_nel', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_nel" value="<?php echo $k; ?>"<?php checked($nel, $k, true); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
	<?php settings_fields( 'http-headers-nel' ); ?>
	<?php do_settings_sections( 'http-headers-nel' ); ?>
	<?php 
	$nel_value = get_option('hh_nel_value', array());
	
	$report_to = isset($nel_value['report_to']) ? $nel_value['report_to'] : NULL;
	$max_age = isset($nel_value['max_age']) ? $nel_value['max_age'] : NULL;
	$include_subdomains = isset($nel_value['include_subdomains']) ? $nel_value['include_subdomains'] : NULL;
	$success_fraction = isset($nel_value['success_fraction']) ? $nel_value['success_fraction'] : NULL;
	$failure_fraction = isset($nel_value['failure_fraction']) ? $nel_value['failure_fraction'] : NULL;
	$request_headers = isset($nel_value['request_headers']) ? $nel_value['request_headers'] : NULL;
	$response_headers = isset($nel_value['response_headers']) ? $nel_value['response_headers'] : NULL;
	?>
		<table>
			<tr>
				<td>report_to:</td>
				<td><input type="text" class="http-header-value" name="hh_nel_value[report_to]" value="<?php echo esc_attr($report_to); ?>"<?php echo $nel == 1 ? NULL : ' readonly'; ?>></td>
			</tr>
			<tr>
				<td>max_age:</td>
				<td><select name="hh_nel_value[max_age]" class="http-header-value"<?php echo $nel == 1 ? NULL : ' readonly'; ?>>
				<?php
				$items = array('3600' => '1 hour', '86400' => '1 day', '604800' => '7 days', '2592000' => '30 days', '5184000' => '60 days', '7776000' => '90 days', '31536000' => '1 year');
				foreach ($items as $key => $item) {
				    ?><option value="<?php echo $key; ?>"<?php selected($max_age, $key); ?>><?php echo $item; ?></option><?php
				}
				?>
				</select></td>
			</tr>
			<tr>
				<td>include_subdomains:</td>
				<td><input type="checkbox" class="http-header-value" name="hh_nel_value[include_subdomains]" value="1"<?php checked($include_subdomains, 1, true); ?><?php echo $nel == 1 ? NULL : ' readonly'; ?>></td>
			</tr>
			<tr>
				<td>success_fraction:</td>
				<td><input type="number" class="http-header-value" name="hh_nel_value[success_fraction]" value="<?php echo esc_attr($success_fraction); ?>"<?php echo $nel == 1 ? NULL : ' readonly'; ?> min="0.0" max="1.0" step="0.1"></td>
			</tr>
			<tr>
				<td>failure_fraction:</td>
				<td><input type="number" class="http-header-value" name="hh_nel_value[failure_fraction]" value="<?php echo esc_attr($failure_fraction); ?>"<?php echo $nel == 1 ? NULL : ' readonly'; ?> min="0.0" max="1.0" step="0.1"></td>
			</tr>
			<tr>
				<td>request_headers:</td>
				<td><input type="text" class="http-header-value" name="hh_nel_value[request_headers]" value="<?php echo esc_attr($request_headers); ?>"<?php echo $nel == 1 ? NULL : ' readonly'; ?>></td>
			</tr>
			<tr>
				<td>response_headers:</td>
				<td><input type="text" class="http-header-value" name="hh_nel_value[response_headers]" value="<?php echo esc_attr($response_headers); ?>"<?php echo $nel == 1 ? NULL : ' readonly'; ?>></td>
			</tr>
		</table>
	</td>
</tr>