<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Timing-Allow-Origin
		<p class="description"><?php _e('The Timing-Allow-Origin header indicates whether a resource provides the complete timing information. SEO tools use the Resource Timing API to analyze the speed and weight of your web page resources.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Timing-Allow-Origin"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
	    <fieldset>
	    	<legend class="screen-reader-text">Timing-Allow-Origin</legend>
	        <?php
	        $timing_allow_origin = get_option('hh_timing_allow_origin', 0);
	        foreach ($bools as $k => $v)
	        {
	        	?><p><label><input type="radio" class="http-header" name="hh_timing_allow_origin" value="<?php echo $k; ?>"<?php checked($timing_allow_origin, $k); ?> /> <?php echo $v; ?></label></p><?php
	        }
	        ?>
	    </fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-tao' ); ?>
		<?php do_settings_sections( 'http-headers-tao' ); ?>
		<select name="hh_timing_allow_origin_value" class="http-header-value"<?php echo $timing_allow_origin == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array('*', 'origin');
		$timing_allow_origin_value = get_option('hh_timing_allow_origin_value');
		foreach ($items as $item) {
			?><option value="<?php echo $item; ?>"<?php selected($timing_allow_origin_value, $item); ?>><?php echo $item; ?></option><?php
		}
		?>
		</select>
		<input type="text" name="hh_timing_allow_origin_url" class="http-header-value" placeholder="http://domain.com" value="<?php echo esc_attr(get_option('hh_timing_allow_origin_url')); ?>" size="35"<?php echo $timing_allow_origin == 1 && $timing_allow_origin_value == 'origin' ? NULL : ' style="display: none" readonly'; ?> />
	</td>
</tr>