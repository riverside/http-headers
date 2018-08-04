<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
	<th scope="row">X-Powered-By
		<p class="description"><?php _e('Specifies the technology (e.g. ASP.NET, PHP, JBoss, Express) supporting the web application, i.e. the scripting language. It is recommended to remove it or provide misleading information to throw off hackers that might target a particular technology/version.', 'http-headers'); ?></p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">X-Powered-By</legend>
			<?php
			$x_powered_by = get_option ( 'hh_x_powered_by', 0 );
			foreach ( $bools as $k => $v ) {
				?><p>
					<label><input type="radio" class="http-header" name="hh_x_powered_by" value="<?php echo $k; ?>" <?php checked($x_powered_by, $k, true); ?> /> <?php echo $v; ?></label>
				</p><?php
			}
			?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-xpb' ); ?>
		<?php do_settings_sections( 'http-headers-xpb' ); ?>
		<select name="hh_x_powered_by_option" class="http-header-value"<?php echo $x_powered_by == 1 ? NULL : ' readonly'; ?>>
		<?php
		$items = array (
			'unset' => 'Unset',
			'set' => 'Set',
		);
		$x_powered_by_option = get_option ( 'hh_x_powered_by_option' );
		foreach ( $items as $k => $v ) {
			?><option value="<?php echo $k; ?>" <?php selected($x_powered_by_option, $k); ?>><?php echo $v; ?></option><?php
		}
		?>		
		</select>
		<input type="text" name="hh_x_powered_by_value" class="http-header-value" placeholder="PHP/<?php echo PHP_VERSION; ?>" value="<?php echo esc_attr(get_option('hh_x_powered_by_value')); ?>"
		<?php echo $x_powered_by == 1 && $x_powered_by_option == 'set' ? NULL : ' style="display: none" readonly'; ?> />
	</td>
</tr>