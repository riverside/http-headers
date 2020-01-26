<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Access-Control-Allow-Origin
		<p class="description"><?php _e('The Access-Control-Allow-Origin header indicates whether a resource can be shared.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
	    <fieldset>
	    	<legend class="screen-reader-text">Access-Control-Allow-Origin</legend>
	        <?php
	        $access_control_allow_origin = get_option('hh_access_control_allow_origin', 0);
	        foreach ($bools as $k => $v)
	        {
	        	?><p><label><input type="radio" class="http-header" name="hh_access_control_allow_origin" value="<?php echo $k; ?>"<?php checked($access_control_allow_origin, $k); ?> /> <?php echo $v; ?></label></p><?php
	        }
	        ?>
	    </fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-acao' ); ?>
		<?php do_settings_sections( 'http-headers-acao' ); ?>
		<?php
		$access_control_allow_origin_url = get_option('hh_access_control_allow_origin_url');
		if (is_scalar($access_control_allow_origin_url))
		{
		    $access_control_allow_origin_url = array($access_control_allow_origin_url);
		}
		if (!is_array($access_control_allow_origin_url))
		{
		    $access_control_allow_origin_url = array(NULL);
		}
		?>
		<table>
    		<tr>
    			<td>
            		<select name="hh_access_control_allow_origin_value" class="http-header-value"<?php echo $access_control_allow_origin == 1 ? NULL : ' readonly'; ?>>
            		<?php
            		$items = array('*', 'origin', 'null');
            		$access_control_allow_origin_value = get_option('hh_access_control_allow_origin_value');
            		foreach ($items as $item) {
            		    ?><option value="<?php echo $item; ?>"<?php selected($access_control_allow_origin_value, $item); ?>><?php echo $item; ?></option><?php
            		}
            		?>
            		</select>
				</td>
    			<td class="hh-acao<?php echo $access_control_allow_origin_value != 'origin' ? ' hh-hidden' : NULL; ?>"><input type="text" name="hh_access_control_allow_origin_url[]" class="http-header-value" placeholder="http://domain.com" size="35" value="<?php echo esc_attr(@$access_control_allow_origin_url[0]); ?>"<?php echo $access_control_allow_origin == 1 && $access_control_allow_origin_value == 'origin' ? NULL : ' readonly'; ?> /></td>
    			<td class="hh-acao<?php echo $access_control_allow_origin_value != 'origin' ? ' hh-hidden' : NULL; ?>">&nbsp;</td>
    		</tr>
    		<?php 
		    foreach ($access_control_allow_origin_url as $i => $url)
    		{
    		    if ($i == 0)
    		    {
    		        continue;
    		    }
    		    ?>
				<tr class="hh-acao<?php echo $access_control_allow_origin_value != 'origin' ? ' hh-hidden' : NULL; ?>">
        			<td>&nbsp;</td>
        			<td><input type="text" name="hh_access_control_allow_origin_url[]" class="http-header-value" placeholder="http://domain.com" size="35" value="<?php echo esc_attr($url); ?>"<?php echo $access_control_allow_origin == 1 && $access_control_allow_origin_value == 'origin' ? NULL : ' readonly'; ?> /></td>
        			<td><button type="button" class="button button-small hh-btn-delete-origin" title="<?php esc_attr_e('Delete', 'http-headers'); ?>">x</button></td>
        		</tr>		    
    		    <?php 
    		}
    		?>
    		<tr class="hh-acao<?php echo $access_control_allow_origin_value != 'origin' ? ' hh-hidden' : NULL; ?>">
    			<td>&nbsp;</td>
    			<td><button type="button" class="button hh-btn-add-origin">+ <?php _e('Add origin', 'http-headers'); ?></button></td>
    			<td>&nbsp;</td>
    		</tr>
		</table>
	</td>
</tr>