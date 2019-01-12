<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

$option_name = 'xenial_version';

delete_option( $option_name );

delete_site_option( $option_name );
?>

Please log in again. The login page will open in a new window. After logging in you can close it and return to this page.