<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
	<h1>HTTP Headers</h1>
	<?php 
	$check = check_webserver_requirements();
	if ($check !== true) {
	    ?>
	    <div class="notice notice-error">
	    	<h2><?php _e('Error!', 'http-headers'); ?></h2>
	    	<?php 
	    	if ($check == -1) {
	    	    ?><p><?php _e('The following file was not found. Please make sure the file exists and has write permissions:', 'http-headers'); ?> <code><?php echo get_home_path(); ?>.htaccess</code></p><?php
	    	} elseif ($check == -2) {
	    	    ?><p><?php _e('Please make sure the following file has write permissions:', 'http-headers'); ?> <code><?php echo get_home_path(); ?>.htaccess</code></p><?php
	    	}
	    	?>
	    </div>
	    <?php
	}
	$check = check_php_requirements();
	if ($check !== true) {
	    ?>
	    <div class="notice notice-warning">
	    	<h2><?php _e('Warning!', 'http-headers'); ?></h2>
	    	<?php 
	    	if ($check == -1) {
	    	    ?><p><?php _e('The following file was not found. Please make sure the file exists and has write permissions:', 'http-headers'); ?> <code><?php echo get_home_path().ini_get('user_ini.filename'); ?></code></p><?php
	    	} elseif ($check == -2) {
	    	    ?><p><?php _e('Please make sure the following file has write permissions:', 'http-headers'); ?> <code><?php echo get_home_path().ini_get('user_ini.filename'); ?></code></p><?php
	    	}
	    	?>
	    </div>
	    <?php
	}
	?>
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