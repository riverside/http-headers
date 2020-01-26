<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
    <th scope="row">Strict-Transport-Security
    	<p class="description"><?php _e("HTTP Strict-Transport-Security (HSTS) enforces secure (HTTP over SSL/TLS) connections to the server. This reduces impact of bugs in web applications leaking session data through cookies and external links and defends against Man-in-the-middle attacks. HSTS also disables the ability for user's to ignore SSL negotiation warnings.", 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
    </th>
    <td>
   		<fieldset>
    		<legend class="screen-reader-text">Strict-Transport-Security</legend>
        <?php
        $strict_transport_security = get_option('hh_strict_transport_security', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_strict_transport_security" value="<?php echo $k; ?>"<?php checked($strict_transport_security, $k, true); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
	<?php settings_fields( 'http-headers-sts' ); ?>
	<?php do_settings_sections( 'http-headers-sts' ); ?>
		<table>
			<tr>
				<td>max-age:</td>
				<td><select name="hh_strict_transport_security_max_age" class="http-header-value"<?php echo $strict_transport_security == 1 ? NULL : ' readonly'; ?>>
				<?php
				$items = array('0' => '0 (Delete entire HSTS Policy)', '3600' => '1 hour', '86400' => '1 day', '604800' => '7 days', '2592000' => '30 days', '5184000' => '60 days', '7776000' => '90 days', '31536000' => '1 year', '63072000' => '2 years');
				$strict_transport_security_max_age = get_option('hh_strict_transport_security_max_age');
				foreach ($items as $key => $item) {
					?><option value="<?php echo $key; ?>"<?php selected($strict_transport_security_max_age, $key); ?>><?php echo $item; ?></option><?php
				}
				?>
				</select></td>
			</tr>
			<tr>
				<td>includeSubDomains:</td>
				<td><input type="checkbox" class="http-header-value" name="hh_strict_transport_security_sub_domains" value="1"<?php checked(get_option('hh_strict_transport_security_sub_domains'), 1, true); ?><?php echo $strict_transport_security == 1 ? NULL : ' readonly'; ?> /></td>
			</tr>
			<tr>
				<td>preload:</td>
				<td><input type="checkbox" class="http-header-value" name="hh_strict_transport_security_preload" value="1"<?php checked(get_option('hh_strict_transport_security_preload'), 1, true); ?><?php echo $strict_transport_security == 1 ? NULL : ' readonly'; ?> /></td>
			</tr>
		</table>
	</td>
</tr>