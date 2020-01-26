<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
	<th scope="row">Referrer-Policy
		<p class="description"><?php _e('The Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included with requests made.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
   		<fieldset>
    		<legend class="screen-reader-text">Referrer-Policy</legend>
        <?php
        $referrer_policy = get_option('hh_referrer_policy', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_referrer_policy" value="<?php echo $k; ?>"<?php checked($referrer_policy, $k, true); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
    	<?php settings_fields( 'http-headers-rp' ); ?>
		<?php do_settings_sections( 'http-headers-rp' ); ?>
		<select name="hh_referrer_policy_value" class="http-header-value"<?php echo $referrer_policy == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array("", "no-referrer", "no-referrer-when-downgrade", "same-origin", "origin", "strict-origin", "origin-when-cross-origin", "strict-origin-when-cross-origin", "unsafe-url");
		$referrer_policy_value = get_option('hh_referrer_policy_value');
		foreach ($items as $item) {
			?><option value="<?php echo $item; ?>"<?php selected($referrer_policy_value, $item); ?>><?php echo !empty($item) ? $item : '(empty string)'; ?></option><?php
		}
		?>		
		</select>
	</td>
</tr>