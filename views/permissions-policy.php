<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
    <th scope="row">Permissions-Policy
    	<p class="description"><?php _e('Permissions Policy is a web platform API which gives a website the ability to allow or block the use of browser features in its own frame or in iframes that it embeds.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://www.w3.org/TR/permissions-policy-1/"><?php _e('W3C Working Draft', 'http-headers'); ?></a>
        </p>
    </th>
	<td>
   		<fieldset>
    		<legend class="screen-reader-text">Permissions-Policy</legend>
        <?php
        $permissions_policy = get_option('hh_permissions_policy', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_permissions_policy" value="<?php echo $k; ?>"<?php checked($permissions_policy, $k, true); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
    	<?php settings_fields( 'http-headers-pp' ); ?>
    	<?php do_settings_sections( 'http-headers-pp' ); ?>
		<table>
			<tbody>
			<?php 
			# https://github.com/w3c/webappsec-permissions-policy/blob/master/features.md
			$features = array(
			    'accelerometer',
			    'ambient-light-sensor',
			    'autoplay',
			    'battery',
			    'camera',
			    'cross-origin-isolated',
			    'display-capture',
			    'document-domain',
			    'encrypted-media',
			    'execution-while-not-rendered',
			    'execution-while-out-of-viewport',
			    'fullscreen',
			    'geolocation',
			    'gyroscope',
			    'interest-cohort',
                'layout-animations',
                'legacy-image-formats',
			    'magnetometer',
			    'microphone',
			    'midi',
			    'navigation-override',
                'oversized-images',
			    'payment',
			    'picture-in-picture',
			    'publickey-credentials-get',
			    'screen-wake-lock',
			    'sync-script',
			    'sync-xhr',
			    'usb',
			    'vertical-scroll',
			    'web-share',
			    'wake-lock',
			    'xr-spatial-tracking',
			);
			$origins = array('none', 'self', '*', 'origin(s)');
			
			$permissions_policy_value = get_option('hh_permissions_policy_value');
			$permissions_policy_feature = get_option('hh_permissions_policy_feature');
			$permissions_policy_origin = get_option('hh_permissions_policy_origin');
			if (!$permissions_policy_value)
			{
			    $permissions_policy_value = array();
			}
			if (!$permissions_policy_feature)
			{
			    $permissions_policy_feature = array();
			}
			if (!$permissions_policy_origin)
			{
			    $permissions_policy_origin = array();
			}
			
			foreach ($features as $feature)
			{
				?>
				<tr>
					<td><input type="checkbox" name="hh_permissions_policy_feature[<?php echo $feature; ?>]" class="http-header-value" 
						value="1"<?php echo !is_array($permissions_policy_feature) || !array_key_exists($feature, $permissions_policy_feature) ? NULL : ' checked'; ?><?php echo $permissions_policy == 1 ? NULL : ' readonly'; ?>></td>
        			<td><?php echo $feature; ?></td>
        			<td>
        				<select name="hh_permissions_policy_value[<?php echo $feature; ?>]"
        					class="http-header-value"<?php echo $permissions_policy == 1 ? NULL : ' readonly'; ?>>
        				<?php 
        				foreach ($origins as $origin)
        				{
        				    ?><option value="<?php echo $origin; ?>"<?php isset($permissions_policy_value[$feature]) ? selected($permissions_policy_value[$feature], $origin) : NULL; ?>><?php echo $origin; ?></option><?php
        				}
        				?>
        				</select>
        				<input type="text" name="hh_permissions_policy_origin[<?php echo $feature; ?>]" 
        					value="<?php echo isset($permissions_policy_origin[$feature]) ? htmlspecialchars( $permissions_policy_origin[$feature] ) : NULL; ?>" size="30"<?php echo isset($permissions_policy_value[$feature]) && in_array($permissions_policy_value[$feature], array('origin(s)', 'self')) ? NULL : ' style="display: none"'; ?>
        					class="http-header-value"<?php echo $permissions_policy == 1 ? NULL : ' readonly'; ?>>
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