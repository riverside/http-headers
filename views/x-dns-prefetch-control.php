<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
    <th scope="row">X-DNS-Prefetch-Control
    	<p class="description"><?php _e('The X-DNS-Prefetch-Control HTTP response header controls DNS prefetching, a feature by which browsers proactively perform domain name resolution on both links that the user may choose to follow as well as URLs for items referenced by the document, including images, CSS, JavaScript, and so forth.', 'http-headers'); ?></p>
		<p class="description"><?php _e('This prefetching is performed in the background, so that the DNS is likely to have been resolved by the time the referenced items are needed. This reduces latency when the user clicks a link.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-DNS-Prefetch-Control"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
    </th>
    <td>
   		<fieldset>
    		<legend class="screen-reader-text">X-DNS-Prefetch-Control</legend>
        <?php
        $x_dns_prefetch_control = get_option('hh_x_dns_prefetch_control', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_x_dns_prefetch_control" value="<?php echo $k; ?>"<?php checked($x_dns_prefetch_control, $k); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
		<?php settings_fields( 'http-headers-xdpc' ); ?>
		<?php do_settings_sections( 'http-headers-xdpc' ); ?>
		<select name="hh_x_dns_prefetch_control_value" class="http-header-value"<?php echo $x_dns_prefetch_control == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array('on', 'off');
		$x_dns_prefetch_control_value = get_option('hh_x_dns_prefetch_control_value');
		foreach ($items as $item) {
			?><option value="<?php echo $item; ?>"<?php selected($x_dns_prefetch_control_value, $item); ?>><?php echo $item; ?></option><?php
		}
		?>
		</select>
	</td>
</tr>