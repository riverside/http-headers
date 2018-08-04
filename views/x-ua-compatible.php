<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
    <th scope="row">X-UA-Compatible
    	<p class="description"><?php _e('In some cases, it might be necessary to restrict a webpage to a document mode supported by an older version of Windows Internet Explorer. Here we look at the x-ua-compatible header, which allows a webpage to be displayed as if it were viewed by an earlier version of the browser.', 'http-headers'); ?></p>
    </th>
    <td>
   		<fieldset>
    		<legend class="screen-reader-text">X-UA-Compatible</legend>
        <?php
        $x_ua_compatible = get_option('hh_x_ua_compatible', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_x_ua_compatible" value="<?php echo $k; ?>"<?php checked($x_ua_compatible, $k, true); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
		<?php settings_fields( 'http-headers-uac' ); ?>
		<?php do_settings_sections( 'http-headers-uac' ); ?>
		<select name="hh_x_ua_compatible_value" class="http-header-value"<?php echo $x_ua_compatible == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array('IE=7', 'IE=8', 'IE=9', 'IE=10', 'IE=edge', 'IE=edge,chrome=1');
		$x_ua_compatible_value = get_option('hh_x_ua_compatible_value');
		foreach ($items as $item) {
			?><option value="<?php echo $item; ?>"<?php selected($x_ua_compatible_value, $item); ?>><?php echo $item; ?></option><?php
		}
		?>
		</select>
	</td>
</tr>