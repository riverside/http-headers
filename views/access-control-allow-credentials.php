<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Access-Control-Allow-Credentials
		<p class="description"><?php _e('The Access-Control-Allow-Credentials header indicates whether the response to request can be exposed when the credentials flag is true.', 'http-headers'); ?></p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Access-Control-Allow-Credentials</legend>
	        <?php
	        $access_control_allow_credentials = get_option('hh_access_control_allow_credentials', 0);
	        foreach ($bools as $k => $v)
	        {
	        	?><p><label><input type="radio" class="http-header" name="hh_access_control_allow_credentials" value="<?php echo $k; ?>"<?php checked($access_control_allow_credentials, $k); ?> /> <?php echo $v; ?></label></p><?php
	        }
	        ?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-acac' ); ?>
		<?php do_settings_sections( 'http-headers-acac' ); ?>
		<select name="hh_access_control_allow_credentials_value" class="http-header-value"<?php echo $access_control_allow_credentials == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array('true');
		$access_control_allow_credentials_value = get_option('hh_access_control_allow_credentials_value');
		foreach ($items as $item) {
			?><option value="<?php echo $item; ?>"<?php selected($access_control_allow_credentials_value, $item); ?>><?php echo $item; ?></option><?php
		}
		?>
		</select>
	</td>
</tr>