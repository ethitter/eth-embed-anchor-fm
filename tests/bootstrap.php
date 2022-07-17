<?php
/**
 * PHPUnit bootstrap file
 *
 * @package ETH_Embed_Anchor_FM
 */

$eth_embed_anchor_fm = getenv( 'WP_TESTS_DIR' );

if ( ! $eth_embed_anchor_fm ) {
	$eth_embed_anchor_fm = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $eth_embed_anchor_fm . '/includes/functions.php' ) ) {
	echo "Could not find $eth_embed_anchor_fm/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // WPCS: XSS ok.
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $eth_embed_anchor_fm . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function eth_embed_anchor_fm_tests_manually_load_plugin() {
	require dirname( __FILE__, 2 ) . '/eth-embed-anchor-fm.php';
}
tests_add_filter( 'muplugins_loaded', 'eth_embed_anchor_fm_tests_manually_load_plugin' );

// Start up the WP testing environment.
require $eth_embed_anchor_fm . '/includes/bootstrap.php';
