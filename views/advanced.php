<?php 
if (!defined('ABSPATH')) {
    exit;
} 
include dirname(__FILE__) . '/includes/config.inc.php';
include dirname(__FILE__) . '/includes/breadcrumbs.inc.php';
?>
<section class="hh-panel">
	<form method="post" action="options.php">
	    <table class="form-table hh-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Default mode', 'http-headers'); ?>
						<p class="description"><?php _e('Choose a method for sending of headers. Usually, the PHP method works perfectly. However, some third-party plugins like WP Super Cache may require switching to Apache method.', 'http-headers'); ?></p>
					</th>
					<td>&nbsp;</td>
		        	<td>
		        		<fieldset>
			        	<?php settings_fields( 'http-headers-mtd' ); ?>
						<?php do_settings_sections( 'http-headers-mtd' ); ?>
						<?php
						$items = array(
							'php' => __('Use PHP to send headers (deprecated)', 'http-headers'),
						    'htaccess' => __('Use Apache (mod_headers) to send headers', 'http-headers'),
						);
						$method = get_option('hh_method');
						foreach ($items as $key => $val) {
							?><p><label><input type="radio" name="hh_method" value="<?php echo $key; ?>"<?php checked($method, $key, true); ?>><?php echo $val; ?></label></p><?php
						}
						?>
						</fieldset>
					</td>
		        </tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</section>
<section class="hh-panel">
    <table class="form-table hh-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php _e('Export', 'http-headers'); ?>
					<p class="description"><?php _e('Export the plugin current state of settings for later use if recovery needs.', 'http-headers'); ?></p>
				</th>
				<td>&nbsp;</td>
	        	<td>
	        		<fieldset>
	        			<form method="post" action="<?php echo admin_url('admin-post.php'); ?>" target="_blank">
	        				<?php wp_nonce_field('export'); ?>
	        				<input type="hidden" name="action" value="export">
	        				<button type="submit" class="button button-primary"><?php _e('Export settings', 'http-headers'); ?></button>
	        			</form>
	        		</fieldset>
	        	</td>
	        </tr>
	        <tr valign="top">
				<th scope="row"><?php _e('Import', 'http-headers'); ?>
					<p class="description"><?php _e('Import a previously saved state of settings.', 'http-headers'); ?></p>
				</th>
				<td>&nbsp;</td>
	        	<td>
	        		<fieldset>
	        			<form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data">
	        				<?php wp_nonce_field('import'); ?>
	        				<input type="hidden" name="action" value="import">
	        				<input type="file" name="file" id="hh-import-file" class="hh-hidden">
	        				<div class="button-group">
	        					<button type="button" class="button hh-btn-import-choose"><?php _e('Choose file...', 'http-headers'); ?></button>
	        					<button type="submit" class="button button-primary"><?php _e('Import settings', 'http-headers'); ?></button>
	        				</div>
	        				<p id="hh-import-name"></p>
	        			</form>
	        		</fieldset>
	        	</td>
	        </tr>
		</tbody>
	</table>
</section>