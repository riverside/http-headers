<?php 
if (!defined('ABSPATH')) {
    exit;
}
$public_key_pins = get_option ( 'hh_public_key_pins', 0 );
?>
<tr valign="top">
	<th scope="row">Public-Key-Pins
		<p class="description"><?php _e('HTTP Public Key Pinning (HPKP) is a security mechanism which allows HTTPS websites to resist impersonation by attackers using mis-issued or otherwise fraudulent certificates.', 'http-headers'); ?></p>

		<p>
		<label><input type="checkbox" class="http-header-value"
			name="hh_public_key_pins_report_only" value="1"
			<?php checked(get_option('hh_public_key_pins_report_only'), 1, true); ?>
			<?php echo $public_key_pins == 1 ? NULL : ' readonly'; ?> /> "Report-Only" (<?php _e('for reporting-only purposes', 'http-headers'); ?>)</label>
		</p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Public-Key-Pins</legend>
			<?php
			foreach ( $bools as $k => $v ) {
				?><p>
				<label><input type="radio" class="http-header" name="hh_public_key_pins" value="<?php echo $k; ?>" <?php checked($public_key_pins, $k, true); ?> /> <?php echo $v; ?></label>
				</p><?php
			}
			?>
		</fieldset>
	</td>
	<td>
	<?php settings_fields( 'http-headers-pkp' ); ?>
	<?php do_settings_sections( 'http-headers-pkp' ); ?>
		<table>
			<tr>
				<td>pin-sha256:</td>
				<td><input type="text" class="http-header-value"
					name="hh_public_key_pins_sha256_1"
					value="<?php echo esc_attr(get_option('hh_public_key_pins_sha256_1')); ?>"
					placeholder="d6qzRu9zOECb90Uez27xWltNsj0e1Md7GkYYkVoZWmM="
					<?php echo $public_key_pins == 1 ? NULL : ' readonly'; ?> /></td>
			</tr>
			<tr>
				<td>pin-sha256:<br>(backup key)
				</td>
				<td><input type="text" class="http-header-value"
					name="hh_public_key_pins_sha256_2"
					value="<?php echo esc_attr(get_option('hh_public_key_pins_sha256_2')); ?>"
					placeholder="E9CZ9INDbd+2eRQozYqqbQ2yXLVKB9+xcprMF+44U1g="
					<?php echo $public_key_pins == 1 ? NULL : ' readonly'; ?> /></td>
			</tr>
			<tr>
				<td>max-age:</td>
				<td><select class="http-header-value"
					name="hh_public_key_pins_max_age"
					<?php echo $public_key_pins == 1 ? NULL : ' readonly'; ?>>
					<?php
					$items = array (
						'3600' => '1 hour',
						'86400' => '1 day',
						'604800' => '7 days',
						'2592000' => '30 days',
						'5184000' => '60 days',
						'7776000' => '90 days',
						'31536000' => '1 year',
					);
					$public_key_pins_max_age = get_option ( 'hh_public_key_pins_max_age' );
					foreach ( $items as $key => $item ) {
						?><option value="<?php echo $key; ?>"
							<?php selected($public_key_pins_max_age, $key); ?>><?php echo $item; ?></option><?php
					}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>includeSubDomains:</td>
				<td><input type="checkbox" class="http-header-value"
					name="hh_public_key_pins_sub_domains" value="1"
					<?php checked(get_option('hh_public_key_pins_sub_domains'), 1, true); ?>
					<?php echo $public_key_pins == 1 ? NULL : ' readonly'; ?> /></td>
			</tr>
			<tr>
				<td>report-uri:</td>
				<td><input type="text" class="http-header-value"
					name="hh_public_key_pins_report_uri"
					value="<?php echo esc_attr(get_option('hh_public_key_pins_report_uri')); ?>"
					placeholder="http://example.com/pkp-report"
					<?php echo $public_key_pins == 1 ? NULL : ' readonly'; ?> /></td>
			</tr>
		</table>
	</td>
</tr>