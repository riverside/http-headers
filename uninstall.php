<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$options = include dirname(__FILE__) . '/views/includes/options.inc.php';

foreach ($options as $option)
{
	delete_option( $option[0] );
}