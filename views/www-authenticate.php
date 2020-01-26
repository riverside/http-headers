<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr valign="top">
	<th scope="row">WWW-Authenticate
		<p class="description"><?php _e('HTTP supports the use of several authentication mechanisms to control access to pages and other resources. These mechanisms are all based around the use of the 401 status code and the WWW-Authenticate response header.', 'http-headers'); ?></p>
        <hr>
        <p class="description"><?php _e('Read more at', 'http-headers'); ?>
            <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/WWW-Authenticate"><?php _e('MDN Web Docs', 'http-headers'); ?></a>
        </p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">WWW-Authenticate</legend>
			<?php
			$www_authenticate = get_option ( 'hh_www_authenticate', 0 );
			foreach ( $bools as $k => $v ) {
				?><p>
					<label><input type="radio" class="http-header" name="hh_www_authenticate" value="<?php echo $k; ?>" <?php checked($www_authenticate, $k, true); ?> /> <?php echo $v; ?></label>
				</p><?php
			}
			?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-wwa' ); ?>
		<?php do_settings_sections( 'http-headers-wwa' ); ?>
		<table>
			<tbody>
				<tr>
					<td>Type</td>
					<td colspan="3">
						<select name="hh_www_authenticate_type" class="http-header-value"<?php echo $www_authenticate == 1 ? NULL : ' readonly'; ?>>
						<?php
						$items = array ('Basic', 'Digest');
						$www_authenticate_type = get_option ( 'hh_www_authenticate_type' );
						foreach ( $items as $item ) {
							?><option value="<?php echo $item; ?>" <?php selected($www_authenticate_type, $item); ?>><?php echo $item; ?></option><?php
						}
						?>		
						</select>
					</td>
				</tr>
				<tr>
					<td>Realm</td>
					<td colspan="3"><input type="text" name="hh_www_authenticate_realm" class="http-header-value" size="30" value="<?php echo esc_attr(get_option('hh_www_authenticate_realm')); ?>"<?php echo $www_authenticate == 1 ? NULL : ' readonly'; ?> placeholder="Restricted area"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><strong><?php _e('Username', 'http-headers'); ?></strong></td>
					<td><strong><?php _e('Password', 'http-headers'); ?></strong></td>
					<td>&nbsp;</td>
				</tr>
				<?php 
				$usernames = get_option('hh_www_authenticate_user', array());
				$passwords = get_option('hh_www_authenticate_pswd', array());
				if (!is_array($usernames)) {
				    $usernames = array($usernames);
				}
				if (!is_array($passwords)) {
				    $passwords = array($passwords);
				}
				$i = 0;
				foreach ($usernames as $k => $user) {
				    ?>
    				<tr>
    					<td>&nbsp;</td>
    					<td><input type="text" name="hh_www_authenticate_user[]" class="http-header-value" value="<?php echo esc_attr($user); ?>"<?php echo $www_authenticate == 1 ? NULL : ' readonly'; ?>></td>
    					<td><input type="text" name="hh_www_authenticate_pswd[]" class="http-header-value" value="<?php echo esc_attr($passwords[$k]); ?>"<?php echo $www_authenticate == 1 ? NULL : ' readonly'; ?>></td>
    					<td><?php 
    					if ($i > 0)
    					{
    					    ?><button type="button" class="button button-small hh-btn-delete-user" title="<?php esc_attr_e('Delete', 'http-headers'); ?>">x</button><?php
    					} else {
    					    echo "&nbsp;";
    					}
    					?></td>
    				</tr>    
				    <?php
				    $i += 1;
				}
				?>
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">
						<button type="button" class="button hh-btn-add-user">+ <?php _e('Add user', 'http-headers'); ?></button>
					</td>
				</tr>
			</tbody>
		</table>
	</td>
</tr>