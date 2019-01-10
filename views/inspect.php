<?php 
if (!defined('ABSPATH')) {
    exit;
}
include dirname(__FILE__) . '/includes/config.inc.php';
include dirname(__FILE__) . '/includes/breadcrumbs.inc.php';
?>
<section class="hh-panel">
	<h3><span class="hh-highlight"><?php _e('Inspect headers', 'http-headers'); ?></span></h3>
	<p><?php _e("Use this tool to inspect the HTTP headers of your website or your competitor's website.", 'http-headers'); ?></p>
    <div class="form-wrap">
		<form action="<?php echo admin_url('admin-ajax.php'); ?>" method="get" id="frmIspect">
			<?php wp_nonce_field('inspect'); ?>
			<input type="hidden" name="action" value="inspect">
			<div class="form-row">
				<div class="form-field form-col-6">
					<label class="form-label">URL:</label>
					<input type="text" name="url" size="40" placeholder="<?php echo home_url('/'); ?>" value="<?php echo home_url('/'); ?>">
				</div>
				<div class="form-field form-col-6">
					<label class="form-label">&nbsp;</label>
					<label><input type="checkbox" name="authentication" id="authentication"><?php _e('Authentication', 'http-headers'); ?></label>
				</div>
			</div>
			<div id="box-authentication" style="display: none">
				<div class="form-row">
					<div class="form-field form-col-6">
						<label class="form-label" for="username"><?php _e('Username', 'http-headers'); ?>:</label>
						<input type="text" name="username">
					</div>
					<div class="form-field form-col-6">
						<label class="form-label" for="password"><?php _e('Password', 'http-headers'); ?>:</label>
						<input type="text" name="password">
					</div>
				</div>
			</div>
			<?php submit_button(__('Inspect', 'http-headers')); ?>
		</form>
	</div>
</section>

<div id="hh-result"></div>