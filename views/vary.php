<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Vary
		<p class="description"><?php _e('The Vary HTTP response header determines how to match future request headers to decide whether a cached response can be used rather than requesting a fresh one from the origin server. It is used by the server to indicate which headers it used when selecting a representation of a resource in a content negotiation algorithm.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Vary"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Vary</legend>
			<?php
			$vary = get_option('hh_vary', 0);
			foreach ($bools as $k => $v)
			{
				?><p><label><input type="radio" class="http-header" name="hh_vary" value="<?php echo $k; ?>"<?php checked($vary, $k); ?> /> <?php echo $v; ?></label></p><?php
			}
			?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-vary' ); ?>
		<?php do_settings_sections( 'http-headers-vary' ); ?>
		<table>
            <tbody>
                <tr>
                    <td>
                    <?php
                    $items = array(
                        '*', 'Accept-Encoding', 'User-Agent', 'Referer', 'Cookie',
                    );
                    $vary_value = get_option('hh_vary_value');
                    if (!$vary_value) {
                        $vary_value = array();
                    }
                    foreach ($items as $item)
                    {
                        ?><p><label><input type="checkbox" class="http-header-value" name="hh_vary_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $vary_value) ? NULL : ' checked'; ?><?php echo $vary == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></p><?php
                    }
                    ?>
                    </td>
                </tr>
            </tbody>
        </table>
	</td>
</tr>