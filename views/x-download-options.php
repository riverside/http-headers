<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
    <th scope="row">X-Download-Options
    	<p class="description"><?php _e("For web applications that need to serve untrusted HTML files, Microsoft IE introduced a mechanism to help prevent the untrusted content from compromising your site's security. When the X-Download-Options header is present with the value noopen, the user is prevented from opening a file download directly; instead, they must first save the file locally. When the locally saved file is later opened, it no longer executes in the security context of your site, helping to prevent script injection.", 'http-headers'); ?></p>
    </th>
    <td>
   		<fieldset>
    		<legend class="screen-reader-text">X-Download-Options</legend>
        <?php
        $x_download_options = get_option('hh_x_download_options', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_x_download_options" value="<?php echo $k; ?>"<?php checked($x_download_options, $k); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
		<?php settings_fields( 'http-headers-xdo' ); ?>
		<?php do_settings_sections( 'http-headers-xdo' ); ?>
		<select name="hh_x_download_options_value" class="http-header-value"<?php echo $x_download_options == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array('noopen');
		$x_download_options_value = get_option('hh_x_download_options_value');
		foreach ($items as $item) {
			?><option value="<?php echo $item; ?>"<?php selected($x_download_options_value, $item); ?>><?php echo $item; ?></option><?php
		}
		?>
		</select>
	</td>
</tr>