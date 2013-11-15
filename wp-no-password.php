<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   WP_No_Password
 * @author    J. Isaac Friend and James W. Lane <info@fueledbydreams.com>
 * @license   GPL-2.0+
 * @link      http://fueledbydreams.com
 * @copyright 2013 Fueled by Dreams
 *
 * @wordpress-plugin
 * Plugin Name:       WP No Password
 * Plugin URI:        http://fueledbydreams.com
 * Description:       Plugin to create a widget that allows specified user
 *					  roles to log in without a password
 * Version:           0.9.0
 * Author:            J. Isaac Friend and James W. Lane
 * Author URI:        http://fueledbydreams.com
 * Text Domain:       wp-no-password
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/fueledbydreams/wp-no-password
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-wp-no-password.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-tgm-plugin-activation.php' );

register_activation_hook( __FILE__, array( 'WP_No_Password', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_No_Password', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'WP_No_Password', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-wp-no-password-admin.php' );
	add_action( 'plugins_loaded', array( 'WP_No_Password_Admin', 'get_instance' ) );

}
