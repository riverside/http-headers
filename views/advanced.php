<?php 
if (!defined('ABSPATH')) {
    exit;
} 
$is_super_admin = is_super_admin();
if (isset($_GET['status'], $_GET['code']) && $_GET['status'] == 'ERR') {
    switch ($_GET['code']) {
        case 102:
            ?>
            <div class="notice notice-error">
                <h2><?php _e('Error!', 'http-headers'); ?></h2>
                <p><?php _e('Only Super Admin users have access to this functionality.', 'http-headers'); ?></p>
            </div>
            <?php
            break;
    }
}
include dirname(__FILE__) . '/includes/config.inc.php';
include dirname(__FILE__) . '/includes/breadcrumbs.inc.php';
?>
<form method="post" action="options.php" accept-charset="utf-8">
    <?php settings_fields( 'http-headers-mtd' ); ?>
    <?php do_settings_sections( 'http-headers-mtd' ); ?>
    <div style="display: flex; justify-content: space-between; gap: 20px">
        <div style="width: 50%">
            <table class="hh-index-table">
                <thead>
                    <tr>
                        <th>Directive</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="active">
                        <td>PHP version</td>
                        <td><?php echo PHP_VERSION; ?></td>
                    </tr>
                    <tr class="active">
                        <td>Server Software</td>
                        <td><?php echo getenv('SERVER_SOFTWARE'); ?></td>
                    </tr>
                    <tr class="active">
                        <td>Server API</td>
                        <td><?php echo PHP_SAPI; ?></td>
                    </tr>
                    <tr class="active">
                        <td>user_ini.filename</td>
                        <td><?php echo ini_get('user_ini.filename'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <section class="hh-panel" style="width: 50%; box-sizing: border-box; margin: 0">
			<table style="width: 100%">
				<thead>
					<tr>
						<th colspan="2" style="text-align: left"><?php _e('Setup Location', 'http-headers'); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Location of <code>.htaccess</code></td>
						<td><?php
                            if ($is_super_admin) {
                                ?><input type="text" name="hh_htaccess_path" placeholder="<?php echo get_home_path(); ?>.htaccess" style="width: 100%" value="<?php echo get_option('hh_htaccess_path'); ?>"><?php
                            } else {
                                echo get_option('hh_htaccess_path');
                            }
                            ?></td>
					</tr>
					<tr>
						<td>Location of <code>.user.ini</code></td>
                        <td><?php
                            if ($is_super_admin) {
                                ?><input type="text" name="hh_user_ini_path" placeholder="<?php echo get_home_path(); ?>.user.ini" style="width: 100%" value="<?php echo get_option('hh_user_ini_path'); ?>"><?php
                            } else {
                                echo get_option('hh_user_ini_path');
                            }
                            ?></td>
					</tr>
					<tr>
                        <td>Location of <code>.hh-htpasswd</code></td>
                        <td><?php
                            if ($is_super_admin) {
                                ?><input type="text" name="hh_htpasswd_path" placeholder="<?php echo get_home_path(); ?>.hh-htpasswd" style="width: 100%" value="<?php echo get_option('hh_htpasswd_path'); ?>"><?php
                            } else {
                                echo get_option('hh_htpasswd_path');
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td>Location of <code>.hh-htdigest</code></td>
                        <td><?php
                            if ($is_super_admin) {
                                ?><input type="text" name="hh_htdigest_path" placeholder="<?php echo get_home_path(); ?>.hh-htdigest" style="width: 100%" value="<?php echo get_option('hh_htdigest_path'); ?>"><?php
                            } else {
                                echo get_option('hh_htdigest_path');
                            }
                            ?></td>
					</tr>
                    <?php
                    if ($is_super_admin) {
                        ?>
					<tr>
						<td></td>
						<td><?php submit_button(null, 'primary', null, false); ?></td>
					</tr>
                        <?php
                    }
                    ?>
				</tbody>
			</table>
        </section>
    </div>

	<section class="hh-panel">
	    <table class="form-table hh-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Default mode', 'http-headers'); ?>
						<p class="description"><?php _e('Choose a method for sending of headers. Usually, the PHP method works perfectly. However, some third-party plugins like WP Super Cache may require switching to Apache method.', 'http-headers'); ?></p>
					</th>
					<td>&nbsp;</td>
		        	<td>
		        		<fieldset>
						<?php
						$items = array(
							'php' => __('Use PHP to send headers (deprecated)', 'http-headers'),
						    'htaccess' => __('Use Apache (mod_headers) to send headers', 'http-headers'),
						);
						$method = get_option('hh_method');
						foreach ($items as $key => $val) {
						    if ($is_super_admin) {
								?><p><label><input type="radio" name="hh_method" value="<?php echo $key; ?>"<?php checked($method, $key, true); ?>><?php echo $val; ?></label></p><?php
                            } else {
                                ?><p><label><input type="radio"<?php checked($method, $key, true); ?> disabled><?php echo $val; ?></label></p><?php
                            }
						}
						?>
						</fieldset>
					</td>
		        </tr>
			</tbody>
		</table>
		<?php
        if ($is_super_admin) {
            submit_button();
        }
        ?>
	</section>
</form>