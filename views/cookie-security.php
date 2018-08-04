<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Cookie security
		<p class="description"><?php _e('A secure cookie is only sent to the server with a encrypted request over the HTTPS protocol.', 'http-headers'); ?></p>
		<p class="description"><?php _e("To prevent cross-site scripting (XSS) attacks, HttpOnly cookies are inaccessible to JavaScript's Document.cookie API; they are only sent to the server.", 'http-headers'); ?></p> 
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Cookie security</legend>
        <?php
        $cookie_security = get_option('hh_cookie_security', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_cookie_security" value="<?php echo $k; ?>"<?php checked($cookie_security, $k); ?> /> <?php echo $v; ?></label></p><?php
		}
		?>
		</fieldset>
	</td>
	<td>
	<?php settings_fields( 'http-headers-cose' ); ?>
	<?php do_settings_sections( 'http-headers-cose' ); ?>
	<?php
	$items = array('Secure', 'HttpOnly');
	$cookie_security_value = get_option('hh_cookie_security_value');
	foreach ($items as $item)
	{
		?><p><label><input type="checkbox" class="http-header-value" name="hh_cookie_security_value[<?php echo $item; ?>]" value="1"<?php echo !is_array($cookie_security_value) || !array_key_exists($item, $cookie_security_value) ? NULL : ' checked'; ?><?php echo $cookie_security == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></p><?php
	}
	?>
	</td>
</tr>