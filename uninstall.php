<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

include dirname(__FILE__) . '/views/includes/config.inc.php';

foreach ($options as $option)
{
	delete_option( $option );
}