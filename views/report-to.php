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
    	<?php settings_fields( 'http-headers-rt' ); ?>
    	<?php do_settings_sections( 'http-headers-rt' ); ?>
    </td>
</tr>
<?php 
$default_value = array(
    array(
        'endpoints' => array(),
        'group' => '',
        'max_age' => '',
    )
);
$report_to_value = get_option('hh_report_to_value');
if (!is_array($report_to_value) || empty($report_to_value))
{
    $report_to_value = $default_value;
}
?>
<tr>
	<td colspan="2">
		<div style="max-width: 1024px; overflow-x: auto">
    		<table class="hh-bordered hh-p-sm">
    			<tr>
    				<th rowspan="2" class="hh-center hh-middle">group</th>
    				<th rowspan="2" class="hh-center hh-middle">max_age</th>
    				<th rowspan="2" class="hh-center hh-middle">include_subdomains</th>
    				<th colspan="3" class="hh-center">endpoints</th>
    				<th>&nbsp;</th>
    				<th>&nbsp;</th>
    			</tr>
    			<tr>
    				<th class="hh-center">url</th>
    				<th class="hh-center">priority</th>
    				<th class="hh-center">weight</th>
    				<th>&nbsp;</th>
    				<th>&nbsp;</th>
    			</tr>
    			<?php
    			$items = array('0' => '0 (Delete entire reporting cache)', '3600' => '1 hour', '86400' => '1 day', '604800' => '7 days', '2592000' => '30 days', '5184000' => '60 days', '7776000' => '90 days', '31536000' => '1 year', '63072000' => '2 years');
    			$i = 0;
    			foreach ($report_to_value as $item)
    			{
    			    if (isset($item['endpoints']) && !empty($item['endpoints']))
    				{
    				    $cnt = count($item['endpoints']);
    				    $c = 0;
    				    foreach ($item['endpoints'] as $k => $v)
    				    {
    				        $classes = array();
    				        if ($c == 0)
    				        {
    				            if ($i == 0)
    				            {
    				                $classes[] = 'hh-tr-first';
    				            }
    				            $classes[] = 'hh-tr-group-start';
    				        }
    				        
    				        if ($c == $cnt - 1)
    				        {
    				            $classes[] = 'hh-tr-group-end';
    				        }
    				        ?>
    				        <tr class="<?php echo join(' ', $classes); ?>">
    				        	<?php 
    				        	if ($c == 0)
    				        	{
    				        	    ?>
    				        	    <td rowspan="<?php echo $cnt; ?>" class="hh-middle"><input type="text" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][group]" value="<?php echo esc_attr($item['group']); ?>" placeholder="csp-endpoint"<?php echo $report_to == 1 ? NULL : ' readonly'; ?>></td>
                    				<td rowspan="<?php echo $cnt; ?>" class="hh-middle"><select class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][max_age]"<?php echo $report_to == 1 ? NULL : ' readonly'; ?>>
                    				<?php
                    				foreach ($items as $key => $val) {
                    				    ?><option value="<?php echo $key; ?>"<?php selected($item['max_age'], $key); ?>><?php echo $val; ?></option><?php
                    				}
                    				?>
                    				</select></td>
                    				<td rowspan="<?php echo $cnt; ?>" class="hh-middle hh-center"><input type="checkbox" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][include_subdomains]" value="1"<?php checked(@$item['include_subdomains'], 1, true); ?><?php echo $report_to == 1 ? NULL : ' readonly'; ?> /></td>
    				        	    <?php
    				        	}
    				        	?>
    				
        				        <td><input type="text" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][endpoints][<?php echo $k; ?>][url]" value="<?php echo esc_attr($v['url']); ?>" placeholder="https://example.com/report/csp"<?php echo $report_to == 1 ? NULL : ' readonly'; ?> size="40"></td>
        				        <td><input type="number" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][endpoints][<?php echo $k; ?>][priority]" value="<?php echo esc_attr($v['priority']); ?>" min="0" step="1"></td>
        				        <td><input type="number" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][endpoints][<?php echo $k; ?>][weight]" value="<?php echo esc_attr($v['weight']); ?>" min="0" step="1"></td>
        				        
        				        <td><?php 
        				        if ($c == 0)
        				        {
        				            ?>
        				        	<button type="button" class="button hh-btn-add-endpoint"><?php _e('Add endpoint', 'http-headers'); ?></button>
        				            <?php
        				        } else {
        				            ?>
        				        	<button type="button" class="button hh-btn-delete-endpoint"><?php _e('Remove endpoint', 'http-headers'); ?></button>
        				            <?php
        				        }
        				        ?></td>
        				        <?php 
        				        if ($c == 0)
        				        {
        				            ?>
        				        	<td rowspan="<?php echo $cnt; ?>" class="hh-middle hh-center"><?php 
        				        	if ($i > 0)
        				        	{
                                        ?>
                				    	<button type="button" class="button hh-btn-delete-endpoint-group" title="<?php esc_attr_e('Delete', 'http-headers'); ?>"><?php _e('Remove group', 'http-headers'); ?></button>
                				    	<?php 
        				        	}
        				        	?></td>
                				  	<?php  
                				}
                				?>
    				        </tr>
    				    	<?php
    				    	$c += 1;
    				    }
    				} else {
    				    ?>
    				    <tr class="hh-tr-first hh-tr-group-start hh-tr-group-end">
    				    	<td><input type="text" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][group]" value="<?php echo esc_attr($item['group']); ?>" placeholder="csp-endpoint"<?php echo $report_to == 1 ? NULL : ' readonly'; ?>></td>
            				<td><select class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][max_age]"<?php echo $report_to == 1 ? NULL : ' readonly'; ?>>
            				<?php
            				foreach ($items as $key => $val) {
            				    ?><option value="<?php echo $key; ?>"<?php selected($item['max_age'], $key); ?>><?php echo $val; ?></option><?php
            				}
            				?>
            				</select></td>
            				<td class="hh-center"><input type="checkbox" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][include_subdomains]" value="1"<?php checked(@$item['include_subdomains'], 1, true); ?><?php echo $report_to == 1 ? NULL : ' readonly'; ?> /></td>
    				        
    				        <td><input type="text" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][endpoints][0][url]" placeholder="https://example.com/report/csp"<?php echo $report_to == 1 ? NULL : ' readonly'; ?> size="40"></td>
    				        <td><input type="number" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][endpoints][0][priority]" min="0" step="1"></td>
    				        <td><input type="number" class="http-header-value" name="hh_report_to_value[<?php echo $i; ?>][endpoints][0][weight]" min="0" step="1"></td>
    				        
    				        <td>
    				        	<button type="button" class="button hh-btn-add-endpoint"><?php _e('Add endpoint', 'http-headers'); ?></button>
    				        </td>
    				        <td rowspan="1"><?php 
            				if ($i > 0)
            				{
            				    ?><button type="button" class="button hh-btn-delete-endpoint-group" title="<?php esc_attr_e('Delete', 'http-headers'); ?>"><?php _e('Remove group', 'http-headers'); ?></button><?php
            				}
            				?></td>
				        </tr>
    				    <?php
    				}
        			$i += 1;
    			}
    			?>
    			<tr>
    				<td colspan="8">
    					<button type="button" class="button" id="hh-btn-add-endpoint-group">+ <?php _e('Add endpoint group', 'http-headers'); ?></button>
    				</td>
    			</tr>
    		</table>
		</div>
	</td>
</tr>