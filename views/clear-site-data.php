<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Clear-Site-Data
		<p class="description"><?php _e('The Clear-Site-Data header clears browsing data (cookies, storage, cache) associated with the requesting website. It allows web developers to have more control over the data stored locally by a browser for their origins.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Clear-Site-Data"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
        <fieldset>
        	<legend class="screen-reader-text">Clear-Site-Data</legend>
	    <?php
        $clear_site_data = get_option('hh_clear_site_data', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_clear_site_data" value="<?php echo $k; ?>"<?php checked($clear_site_data, $k); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-csd' ); ?>
		<?php do_settings_sections( 'http-headers-csd' ); ?>
		<?php 
		$items = array(
			'cache' => 'bool',
			'cookies' => 'bool',
			'storage' => 'bool',
			'executionContexts' => 'bool',
			'*' => 'bool',
		);
		?>
		<table>
		<?php 
		$clear_site_data_value = get_option('hh_clear_site_data_value');
		if (!$clear_site_data_value)
		{
			$clear_site_data_value = array();
		}
		foreach ($items as $item => $type)
		{
			?>
			<tr>
				<td><label for="hh_clear_site_data_value_<?php echo $item; ?>">"<?php echo $item; ?>"</label></td>
				<td><?php
				switch ($type) {
					case 'bool':
						?><input type="checkbox" class="http-header-value" name="hh_clear_site_data_value[<?php echo $item; ?>]" id="hh_clear_site_data_value_<?php echo $item; ?>" value="1"<?php checked(array_key_exists($item, $clear_site_data_value), 1, true); ?>><?php
						break;
				}
				?>	
				</td>
			</tr>
			<?php 
		}
		?>
		</table>
	</td>
</tr>