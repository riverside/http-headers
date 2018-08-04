<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
    <th scope="row">Report-To
    	<p class="description"><?php _e('The Report-To HTTP response header field instructs the user agent to store reporting endpoints for an origin.', 'http-headers'); ?></p>
    </th>
	<td>
   		<fieldset>
    		<legend class="screen-reader-text">Report-To</legend>
        <?php
        $report_to = get_option('hh_report_to', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_report_to" value="<?php echo $k; ?>"<?php checked($report_to, $k, true); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
    	</fieldset>
    </td>
	<td>
	<?php settings_fields( 'http-headers-rt' ); ?>
	<?php do_settings_sections( 'http-headers-rt' ); ?>
	</td>
</tr>
<?php 
$report_to_value = get_option('hh_report_to_value');
if (!is_array($report_to_value) || empty($report_to_value))
{
    $report_to_value = array(
        array(
            'url' => '',
            'group' => '',
            'max-age' => '',
        )
    );
}
?>
<tr>
	<td colspan="3">
		<table>
			<tr>
				<th>url</th>
				<th>group</th>
				<th>max-age</th>
				<th class="hh-center">includeSubDomains</th>
				<th>&nbsp;</th>
			</tr>
			<?php
			$items = array('0' => '0 (Delete entire reporting cache)', '3600' => '1 hour', '86400' => '1 day', '604800' => '7 days', '2592000' => '30 days', '5184000' => '60 days', '7776000' => '90 days', '31536000' => '1 year', '63072000' => '2 years');
			$i = 0;
			foreach ($report_to_value as $endpoint)
			{
    			?>
    			<tr>
    				<td><input type="text" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][url]" value="<?php echo esc_attr($endpoint['url']); ?>" placeholder="https://example.com/report/csp"<?php echo $report_to == 1 ? NULL : ' readonly'; ?> size="40" /></td>
    				<td><input type="text" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][group]" value="<?php echo esc_attr($endpoint['group']); ?>" placeholder="csp-endpoint"<?php echo $report_to == 1 ? NULL : ' readonly'; ?> /></td>
    				<td><select class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][max-age]"<?php echo $report_to == 1 ? NULL : ' readonly'; ?>>
    				<?php
    				foreach ($items as $key => $item) {
    				    ?><option value="<?php echo $key; ?>"<?php selected($endpoint['max-age'], $key); ?>><?php echo $item; ?></option><?php
    				}
    				?>
    				</select></td>
    				<td class="hh-center"><input type="checkbox" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][includeSubDomains]" value="1"<?php checked(@$endpoint['includeSubDomains'], 1, true); ?><?php echo $report_to == 1 ? NULL : ' readonly'; ?> /></td>
    				<td><?php 
    				if ($i > 0)
    				{
    				    ?><button type="button" class="button button-small hh-btn-delete-endpoint" title="<?php esc_attr_e('Delete', 'http-headers'); ?>">x</button><?php
    				}
    				?></td>
    			</tr>
    			<?php
    			$i += 1;
			}
			?>
			<tr>
				<td colspan="5">
					<button type="button" class="button" id="hh-btn-add-endpoint">+ <?php _e('Add endpoint', 'http-headers'); ?></button>
				</td>
			</tr>
		</table>
	</td>
</tr>