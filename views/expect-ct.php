<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
	<th scope="row">Expect-CT
		<p class="description"><?php _e('Expect-CT is an HTTP header that allows sites to opt in to reporting and/or enforcement of Certificate Transparency requirements, which prevents the use of misissued certificates for that site from going unnoticed. When a site enables the Expect-CT header, they are requesting that Chrome check that any certificate for that site appears in public CT logs.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expect-CT"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Expect-CT</legend>
			<?php
	        $expect_ct = get_option('hh_expect_ct', 0);
	        foreach ($bools as $k => $v)
	        {
	        	?><p><label><input type="radio" class="http-header" name="hh_expect_ct" value="<?php echo $k; ?>"<?php checked($expect_ct, $k, true); ?> /> <?php echo $v; ?></label></p><?php
	        }
	        ?>
        	</fieldset>
	</td>
	<td>
	<?php settings_fields( 'http-headers-ect' ); ?>
	<?php do_settings_sections( 'http-headers-ect' ); ?>
		<table>
			<tr>
				<td>max-age:</td>
				<td><select name="hh_expect_ct_max_age" class="http-header-value"<?php echo $expect_ct == 1 ? NULL : ' readonly'; ?>>
				<?php
				$items = array('3600' => '1 hour', '86400' => '1 day', '604800' => '7 days', '2592000' => '30 days', '5184000' => '60 days', '7776000' => '90 days', '31536000' => '1 year');
				$expect_ct_max_age = get_option('hh_expect_ct_max_age');
				foreach ($items as $key => $item) {
					?><option value="<?php echo $key; ?>"<?php selected($expect_ct_max_age, $key); ?>><?php echo $item; ?></option><?php
				}
				?>
				</select></td>
			</tr>
			<tr>
				<td>report-uri:</td>
				<td><input type="text" class="http-header-value" name="hh_expect_ct_report_uri" value="<?php echo esc_attr(get_option('hh_expect_ct_report_uri')); ?>" placeholder="https://example.com/ct-report"<?php echo $expect_ct == 1 ? NULL : ' readonly'; ?> /></td>
			</tr>
			<tr>
				<td>enforce:</td>
				<td><input type="checkbox" class="http-header-value" name="hh_expect_ct_enforce" value="1"<?php checked(get_option('hh_expect_ct_enforce'), 1, true); ?><?php echo $expect_ct == 1 ? NULL : ' readonly'; ?> /></td>
			</tr>
		</table>
	</td>
</tr>