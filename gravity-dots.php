<?php
/**
 * Plugin Name:       Gravity Dots
 * Plugin URI:        https://aizle.co/gravity-dots
 * Description:       An interactive particle background that makes any WordPress site feel alive: coloured dots that drift gently and part around the cursor. No code, no libraries.
 * Version:           1.5.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Aizle
 * Author URI:        https://aizle.co
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gravity-dots
 * Domain Path:       /languages
 *
 * @package GravityDots
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GRAVITY_DOTS_VERSION', '1.5.0' );
define( 'GRAVITY_DOTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'GRAVITY_DOTS_URL', plugin_dir_url( __FILE__ ) );
define( 'GRAVITY_DOTS_FILE', __FILE__ );
define( 'GRAVITY_DOTS_BASENAME', plugin_basename( __FILE__ ) );

require_once GRAVITY_DOTS_PATH . 'includes/defaults.php';
require_once GRAVITY_DOTS_PATH . 'includes/class-gd-frontend.php';

if ( is_admin() ) {
	require_once GRAVITY_DOTS_PATH . 'includes/class-gd-settings.php';
}

// Translations are loaded automatically by WordPress (4.6+) for the plugin's
// text domain, so no manual load_plugin_textdomain() call is needed.

add_action( 'init', 'gravitydots_bootstrap' );
function gravitydots_bootstrap() {
	if ( is_admin() && class_exists( 'GravityDots_Settings' ) ) {
		new GravityDots_Settings();
	}
	if ( class_exists( 'GravityDots_Frontend' ) ) {
		new GravityDots_Frontend();
	}
}

register_activation_hook( __FILE__, 'gravitydots_on_activate' );
function gravitydots_on_activate() {
	if ( false === get_option( 'gravity_dots_settings', false ) ) {
		add_option( 'gravity_dots_settings', gravitydots_default_settings() );
	}
}
