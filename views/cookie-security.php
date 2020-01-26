<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Cookie security
		<p class="description"><?php _e('A secure cookie is only sent to the server with a encrypted request over the HTTPS protocol.', 'http-headers'); ?></p>
		<p class="description"><?php _e("To prevent cross-site scripting (XSS) attacks, HttpOnly cookies are inaccessible to JavaScript's Document.cookie API; they are only sent to the server.", 'http-headers'); ?></p>
        <p class="description"><?php _e('SameSite prevents the browser from sending this cookie along with cross-site requests. The main goal is mitigate the risk of cross-origin information leakage. It also provides some protection against cross-site request forgery attacks.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies#Secure_and_HttpOnly_cookies"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
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
	$items = array('Secure', 'HttpOnly', 'SameSite');
	$cookie_security_value = get_option('hh_cookie_security_value');
	foreach ($items as $item)
	{
        $is_disabled = $item == 'SameSite' && !is_samesite_supported();
        $is_checked = is_array($cookie_security_value) && array_key_exists($item, $cookie_security_value);
        if ($is_disabled) {
            $is_checked = false;
        }
        ?>
        <p>
            <label><input type="checkbox"
                          class="http-header-value"
                          name="hh_cookie_security_value[<?php echo $item; ?>]"<?php echo $is_disabled ? ' disabled' : NULL; ?>
                          value="1"<?php echo !$is_checked ? NULL : ' checked'; ?><?php echo $cookie_security == 1 ? NULL : ' readonly'; ?>> <?php echo $item; ?><?php
                if ($item == 'SameSite' && $is_disabled)
                {
                    ?> <small><?php _e('(PHP 7.3+ only)', 'http-headers'); ?></small><?php
                }
                ?></label>
        </p>
        <?php
        if ($item == 'SameSite')
        {
            foreach (array('None', 'Lax', 'Strict') as $s_val)
            {
                ?>
                <p class="hh-csv-value<?php echo !$is_checked ? ' hh-hidden' : NULL; ?>">
                    <label><input type="radio"
                          class="http-header-value"
                          name="hh_cookie_security_value[SameSite]"
                          value="<?php echo $s_val; ?>"<?php echo !is_array($cookie_security_value) || !array_key_exists($item, $cookie_security_value) || $cookie_security_value[$item] != $s_val ? NULL : ' checked'; ?><?php echo $cookie_security == 1 ? NULL : ' readonly'; ?>> <?php echo $s_val; ?></label>
                </p>
                <?php
            }
        }
	}
	?>
	</td>
</tr>