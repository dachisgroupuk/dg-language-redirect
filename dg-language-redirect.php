<?php
/**
 * Plugin Name: BV Language redirect
 * Description: Works with the Multi Lingual Wordpress plugin to redirect the user according to their browser language.
 * Version: 1.0
 * Author: Dachis Group
 * Author URI: http://dachisgroup.com
 *
 */
 if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) || !function_exists( 'add_action' ) ) {
	if ( !function_exists( 'add_action' ) ) {
		$exit_msg = 'I\'m just a plugin, please don\'t call me directly';
	} else {
		// Subscribe2 needs WordPress 3.1 or above, exit if not on a compatible version
		$exit_msg = sprintf( __( 'This version of country list required WordPress 3.1 or greater.' ) );
	}
	exit( $exit_msg );
}

// our version number. Don't touch this or any line below
// unless you know exactly what you are doing
define( 'DGLRPATH', trailingslashit( dirname( __FILE__ ) ) );
define( 'DGLRDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );
define( 'DGLRURL', plugin_dir_url( dirname( __FILE__ ) ) . DGLRDIR );

// Set maximum execution time to 5 minutes - won't affect safe mode
$safe_mode = array( 'On', 'ON', 'on', 1 );
if ( !in_array( ini_get( 'safe_mode' ), $safe_mode ) && ini_get( 'max_execution_time' ) < 300 ) {
	@ini_set( 'max_execution_time', 300 );
}

global $dgLanguageRedirect;

require_once( DGLRPATH . 'classes/language-redirect-core.php' );
require_once( DGLRPATH . 'classes/language-redirect-frontend.php' );

if( is_admin() ):
    require_once( DGLRPATH . 'classes/language-redirect-admin.php' );
    $dgLanguageRedirect = new LanguageRedirectAdmin();
else:
    $dgLanguageRedirect = new LanguageRedirectFrontend();
endif;

$dgLanguageRedirect->init();
