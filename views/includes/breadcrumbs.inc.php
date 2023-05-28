<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<ul class="hh-breadcrumbs">
	<li><a href="<?php echo get_admin_url(); ?>options-general.php?page=http-headers"><?php _e('Dashboard', 'http-headers'); ?></a></li>
	<?php 
	if (isset($_GET['category']))
	{
		?><li><?php echo isset($categories[$_GET['category']]) ? $categories[$_GET['category']] : 'Unknown'; ?></li><?php
	} elseif (isset($_GET['header'])) {
	    if (isset($headers[$_GET['header']][2]))
        {
            ?><li><a href="<?php echo get_admin_url(); ?>options-general.php?page=http-headers&amp;category=<?php echo htmlspecialchars($headers[$_GET['header']][2]); ?>"><?php echo isset($categories[$headers[$_GET['header']][2]]) ? $categories[$headers[$_GET['header']][2]] : 'Unknown'; ?></a></li><?php
            ?><li><?php echo $headers[$_GET['header']][0]; ?></li><?php
        }
	} elseif (isset($_GET['tab']) && $_GET['tab'] == 'advanced') {
		?><li><?php _e('Advanced settings', 'http-headers'); ?></li><?php
	} elseif (isset($_GET['tab']) && $_GET['tab'] == 'manual') {
	    ?><li><?php _e('Manual setup', 'http-headers'); ?></li><?php
	} elseif (isset($_GET['tab']) && $_GET['tab'] == 'inspect') {
		?><li><?php _e('Inspect headers', 'http-headers'); ?></li><?php
	}
	?>
</ul>