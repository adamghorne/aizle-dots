<?php
/**
 * Uninstall handler for Gravity Dots.
 *
 * Runs when the plugin is deleted from the Plugins screen. Removes the single
 * option the plugin stores — no leftovers.
 *
 * @package GravityDots
 */

// Only run from WordPress's uninstall routine.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'gravity_dots_settings' );

// Multisite: clean the option on every site in the network. Use the get_sites()
// API (not a direct DB query) so no caching/prefix concerns apply.
if ( is_multisite() && function_exists( 'get_sites' ) ) {
	$gravitydots_site_ids = get_sites(
		array(
			'fields' => 'ids',
			'number' => 0,
		)
	);
	foreach ( $gravitydots_site_ids as $gravitydots_site_id ) {
		switch_to_blog( (int) $gravitydots_site_id );
		delete_option( 'gravity_dots_settings' );
		restore_current_blog();
	}
}
