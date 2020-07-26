<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Cross-Origin-Opener-Policy
		<p class="description"><?php _e('The HTTP Cross-Origin-Opener-Policy (COOP) response header allows you to ensure a top-level document does not share a browsing context group with cross-origin documents.', 'http-headers'); ?></p>
        <p class="description"><?php _e("COOP will process-isolate your document and potential attackers can't access to your global object if they were opening it in a popup, preventing a set of cross-origin attacks dubbed XS-Leaks.", 'http-headers'); ?></p>
        <p class="description"><?php _e('If a cross-origin document with COOP is opened in a new window, the opening document will not have a reference to it, and the window.opener property of the new window will be null. This allows you to have more control over references to a window than rel=noopener, which only affects outgoing navigations.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Opener-Policy"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Cross-Origin-Opener-Policy</legend>
			<?php
            $cross_origin_opener_policy = get_option('hh_cross_origin_opener_policy', 0);
			foreach ($bools as $k => $v)
			{
				?><p><label><input type="radio" class="http-header" name="hh_cross_origin_opener_policy" value="<?php echo $k; ?>"<?php checked($cross_origin_opener_policy, $k); ?> /> <?php echo $v; ?></label></p><?php
			}
			?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-coop' ); ?>
		<?php do_settings_sections( 'http-headers-coop' ); ?>
        <select name="hh_cross_origin_opener_policy_value" class="http-header-value"<?php echo $cross_origin_opener_policy == 1 ? NULL : ' readonly'; ?>>
            <?php
            $items = array('unsafe-none', 'same-origin-allow-popups', 'same-origin');
            $cross_origin_opener_policy_value = get_option('hh_cross_origin_opener_policy_value');
            foreach ($items as $item) {
                ?><option value="<?php echo $item; ?>"<?php selected($cross_origin_opener_policy_value, $item); ?>><?php echo $item; ?></option><?php
            }
            ?>
        </select>
	</td>
</tr>