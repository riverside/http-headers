<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
    <th scope="row">Feature-Policy
    	<p class="description"><?php _e('With Feature Policy, you opt-in to a set of policies for the browser to enforce on specific features used throughout your site. These policies restrict what APIs the site can access or modify the browser\'s default behavior for certain features.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Feature-Policy"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
    </th>
	<td>
   		<fieldset>
    		<legend class="screen-reader-text">Feature-Policy</legend>
        <?php
        $feature_policy = get_option('hh_feature_policy', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_feature_policy" value="<?php echo $k; ?>"<?php checked($feature_policy, $k, true); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
    	<?php settings_fields( 'http-headers-fp' ); ?>
    	<?php do_settings_sections( 'http-headers-fp' ); ?>
		<table>
			<tbody>
			<?php 
			$features = array(
			    'accelerometer',
			    'ambient-light-sensor',
			    'autoplay',
			    'camera',
			    'cookie',
			    'docwrite',
			    'domain',
			    'encrypted-media',
			    'fullscreen',
			    'geolocation',
			    'gyroscope',
			    'magnetometer',
			    'microphone',
			    'midi',
			    'payment',
			    'picture-in-picture',
			    'speaker',
			    'sync-script',
			    'sync-xhr',
			    'unsized-media',
			    'usb',
			    'vertical-scroll',
			    'vibrate',
			    'vr',
			);
			$origins = array("'self'", "'none'", '*', 'origin(s)');
			
			$feature_policy_value = get_option('hh_feature_policy_value');
			$feature_policy_feature = get_option('hh_feature_policy_feature');
			$feature_policy_origin = get_option('hh_feature_policy_origin');
			if (!$feature_policy_value)
			{
			    $feature_policy_value = array();
			}
			if (!$feature_policy_feature)
			{
			    $feature_policy_feature = array();
			}
			if (!$feature_policy_origin)
			{
			    $feature_policy_origin = array();
			}
			
			foreach ($features as $feature)
			{
				?>
				<tr>
					<td><input type="checkbox" name="hh_feature_policy_feature[<?php echo $feature; ?>]" class="http-header-value" 
						value="1"<?php echo !is_array($feature_policy_feature) || !array_key_exists($feature, $feature_policy_feature) ? NULL : ' checked'; ?><?php echo $feature_policy == 1 ? NULL : ' readonly'; ?>></td>
        			<td><?php echo $feature; ?></td>
        			<td>
        				<select name="hh_feature_policy_value[<?php echo $feature; ?>]"
        					class="http-header-value"<?php echo $feature_policy == 1 ? NULL : ' readonly'; ?>>
        				<?php 
        				foreach ($origins as $origin)
        				{
        				    ?><option value="<?php echo $origin; ?>"<?php selected(@$feature_policy_value[$feature], $origin); ?>><?php echo $origin; ?></option><?php
        				}
        				?>
        				</select>
        				<input type="text" name="hh_feature_policy_origin[<?php echo $feature; ?>]" 
        					value="<?php echo @$feature_policy_origin[$feature]; ?>" size="30"<?php echo isset($feature_policy_value[$feature]) && in_array($feature_policy_value[$feature], array('origin(s)', "'self'")) ? NULL : ' style="display: none"'; ?> 
        					class="http-header-value"<?php echo $feature_policy == 1 ? NULL : ' readonly'; ?>>
        			</td>
        		</tr>
				<?php
			}
			?>
        	</tbody>
		</table>
	</td>
	</td>
</tr>