<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
        <tr valign="top">
	        <th scope="row">P3P
	        	<p class="description"><?php _e('The Platform for Privacy Preferences Project (P3P) is a protocol allowing websites to declare their intended use of information they collect about web browser users.', 'http-headers'); ?></p>
	        </th>
	        <td>
	       		<fieldset>
	        		<legend class="screen-reader-text">P3P</legend>
		        <?php
		        $p3p = get_option('hh_p3p', 0);
		        foreach ($bools as $k => $v)
		        {
		        	?><p><label><input type="radio" class="http-header" name="hh_p3p" value="<?php echo $k; ?>"<?php checked($p3p, $k); ?> /> <?php echo $v; ?></label></p><?php
		        }
		        ?>
	        	</fieldset>
	        </td>
			<td>
			<?php settings_fields( 'http-headers-p3p' ); ?>
			<?php do_settings_sections( 'http-headers-p3p' ); ?>
			<?php 
			$p3p_value = get_option('hh_p3p_value');
			if (!$p3p_value)
			{
				$p3p_value = array();
			}
			$in_creq = array('ADM', 'DEV', 'TAI', 'PSA', 'PSD', 'IVA', 'IVD', 'CON', 'HIS', 'TEL', 'OTP', 'DEL', 'SAM', 'UNR', 'PUB', 'OTR',);
			$creq = array('a', 'i', 'o');
			?>
			<table>
				<tbody>
					<tr>
						<td>Compact ACCESS</td>
						<td class="hh-td-inner">
							<table><tbody><tr><?php
							$items = array('NOI', 'ALL', 'CAO', 'IDC', 'OTI', 'NON');
							foreach ($items as $i => $item) {
								if ($i > 0 && $i % 4 === 0) {
									?></tr><tr><?php
								}
								?><td><label><input type="checkbox" class="http-header-value" name="hh_p3p_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $p3p_value) ? NULL : ' checked'; ?><?php echo $p3p == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
							}
							?></tr></tbody></table>
						</td>
					</tr>
					<tr>
						<td>Compact DISPUTES</td>
						<td class="hh-td-inner">
							<table><tbody><tr><?php
							$items = array('DSP');
							foreach ($items as $i => $item) {
								if ($i > 0 && $i % 4 === 0) {
									?></tr><tr><?php
								}
								?><td><label><input type="checkbox" class="http-header-value" name="hh_p3p_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $p3p_value) ? NULL : ' checked'; ?><?php echo $p3p == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
							}
							?></tr></tbody></table>
						</td>
					</tr>
					<tr>
						<td>Compact REMEDIES</td>
						<td class="hh-td-inner">
							<table><tbody><tr><?php
							$items = array('COR', 'MON', 'LAW');
							foreach ($items as $i => $item) {
								if ($i > 0 && $i % 4 === 0) {
									?></tr><tr><?php
								}
								?><td><label><input type="checkbox" class="http-header-value" name="hh_p3p_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $p3p_value) ? NULL : ' checked'; ?><?php echo $p3p == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
							}
							?></tr></tbody></table>
						</td>
					</tr>
					<tr>
						<td>Compact NON-IDENTIFIABLE</td>
						<td class="hh-td-inner">
							<table><tbody><tr><?php
							$items = array('NID');
							foreach ($items as $i => $item) {
								if ($i > 0 && $i % 4 === 0) {
									?></tr><tr><?php
								}
								?><td><label><input type="checkbox" class="http-header-value" name="hh_p3p_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $p3p_value) ? NULL : ' checked'; ?><?php echo $p3p == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
							}
							?></tr></tbody></table>
						</td>
					</tr>
					<tr>
						<td>Compact PURPOSE</td>
						<td class="hh-td-inner">
							<table><tbody><tr><?php
							$items = array('CUR', 'ADM', 'DEV', 'TAI', 'PSA', 'PSD', 'IVA', 'IVD', 'CON', 'HIS', 'TEL', 'OTP');
							foreach ($items as $i => $item) {
								if ($i > 0 && $i % 4 === 0) {
									?></tr><tr><?php
								}
								?><td><label><input type="checkbox" class="http-header-value" name="hh_p3p_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $p3p_value) ? NULL : ' checked'; ?><?php echo $p3p == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
							}
							?></tr></tbody></table>
						</td>
					</tr>
					<tr>
						<td>Compact RECIPIENT</td>
						<td class="hh-td-inner">
							<table><tbody><tr><?php
							$items = array('OUR', 'DEL', 'SAM', 'UNR', 'PUB', 'OTR');
							foreach ($items as $i => $item) {
								if ($i > 0 && $i % 4 === 0) {
									?></tr><tr><?php
								}
								?><td><label><input type="checkbox" class="http-header-value" name="hh_p3p_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $p3p_value) ? NULL : ' checked'; ?><?php echo $p3p == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
							}
							?></tr></tbody></table>
						</td>
					</tr>
					<tr>
						<td>Compact RETENTION</td>
						<td class="hh-td-inner">
							<table><tbody><tr><?php
							$items = array('NOR', 'STP', 'LEG', 'BUS', 'IND');
							foreach ($items as $i => $item) {
								if ($i > 0 && $i % 4 === 0) {
									?></tr><tr><?php
								}
								?><td><label><input type="checkbox" class="http-header-value" name="hh_p3p_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $p3p_value) ? NULL : ' checked'; ?><?php echo $p3p == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
							}
							?></tr></tbody></table>
						</td>
					</tr>
					<tr>
						<td>Compact CATEGORIES</td>
						<td class="hh-td-inner">
							<table><tbody><tr><?php
							$items = array('PHY', 'ONL', 'UNI', 'PUR', 'FIN', 'COM', 'NAV', 'INT', 'DEM', 'CNT', 'STA', 'POL', 'HEA', 'PRE', 'LOC', 'GOV', 'OTC');
							foreach ($items as $i => $item) {
								if ($i > 0 && $i % 4 === 0) {
									?></tr><tr><?php
								}
								?><td><label><input type="checkbox" class="http-header-value" name="hh_p3p_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $p3p_value) ? NULL : ' checked'; ?><?php echo $p3p == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
							}
							?></tr></tbody></table>
						</td>
					</tr>
					<tr>
						<td>Compact TEST</td>
						<td class="hh-td-inner">
							<table><tbody><tr><?php
							$items = array('TST');
							foreach ($items as $i => $item) {
								if ($i > 0 && $i % 4 === 0) {
									?></tr><tr><?php
								}
								?><td><label><input type="checkbox" class="http-header-value" name="hh_p3p_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $p3p_value) ? NULL : ' checked'; ?><?php echo $p3p == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
							}
							?></tr></tbody></table>
						</td>
					</tr>
				</tbody>
			</table>
			
			</td>
        </tr>