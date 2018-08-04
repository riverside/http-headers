<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
	<h1>HTTP Headers</h1>
	<p><?php _e('Quick links', 'http-headers'); ?>: 
		<a href="https://zinoui.com/blog/http-headers-for-wordpress" target="_blank" title="HTTP Headers"><?php _e('Getting started', 'http-headers'); ?></a>, 
		<a href="<?php echo get_admin_url(); ?>options-general.php?page=http-headers&amp;tab=advanced"><?php _e('Advanced settings', 'http-headers'); ?></a>,
		<a href="<?php echo get_admin_url(); ?>options-general.php?page=http-headers&amp;tab=manual"><?php _e('Manual setup', 'http-headers'); ?></a>,
		<a href="<?php echo get_admin_url(); ?>options-general.php?page=http-headers&amp;tab=inspect"><?php _e('Inspect headers', 'http-headers'); ?></a>
	</p>
	<?php 
	if (isset($_GET['header']) && !empty($_GET['header']))
	{
		include dirname(__FILE__) . '/header.php';
	} elseif (isset($_GET['tab']) && $_GET['tab'] == 'advanced') {
		include dirname(__FILE__) . '/advanced.php';
	} elseif (isset($_GET['tab']) && $_GET['tab'] == 'manual') {
		include dirname(__FILE__) . '/manual.php';
	} elseif (isset($_GET['tab']) && $_GET['tab'] == 'inspect') {
		include dirname(__FILE__) . '/inspect.php';
	} elseif (isset($_GET['category'])) {
		include dirname(__FILE__) . '/category.php';
	} else {
		include dirname(__FILE__) . '/dashboard.php';
	}
	?>
</div>