<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
    <th scope="row">X-Permitted-Cross-Domain-Policies
    	<p class="description"><?php _e('A cross-domain policy file is an XML document that grants a web client, such as Adobe Flash Player or Adobe Acrobat (though not necessarily limited to these), permission to handle data across domains.', 'http-headers'); ?></p>
    </th>
    <td>
   		<fieldset>
    		<legend class="screen-reader-text">X-Permitted-Cross-Domain-Policies</legend>
        <?php
        $x_permitted_cross_domain_policies = get_option('hh_x_permitted_cross_domain_policies', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_x_permitted_cross_domain_policies" value="<?php echo $k; ?>"<?php checked($x_permitted_cross_domain_policies, $k); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
		<?php settings_fields( 'http-headers-xpcd' ); ?>
		<?php do_settings_sections( 'http-headers-xpcd' ); ?>
		<select name="hh_x_permitted_cross_domain_policies_value" class="http-header-value"<?php echo $x_permitted_cross_domain_policies == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array('none', 'master-only', 'by-content-type', 'by-ftp-filename', 'all');
		$x_permitted_cross_domain_policies_value = get_option('hh_x_permitted_cross_domain_policies_value');
		foreach ($items as $item) {
			?><option value="<?php echo $item; ?>"<?php selected($x_permitted_cross_domain_policies_value, $item); ?>><?php echo $item; ?></option><?php
		}
		?>
		</select>
	</td>
</tr>