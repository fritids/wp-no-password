<?php
/*
Plugin Name: WP No Password
Plugin URI: http://fueledbydreams.com
Description: This plugin creates a widget that allows specified user roles to log in to the WordPress blog without using a password.
Version: 0.9
Author: J. Isaac Friend (a Goddamn genius) and James W. Lane
Author URI: http://fueledbydreams.com
Author Email: info@fueledbydreams.com
Text Domain: wp-no-password-locale
Domain Path: /lang/
Network: false
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2013 Fueled By Dreams (info@fueledbydreams.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class wp_no_password extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		// Hooks fired when the Widget is activated and deactivated
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		parent::__construct(
			'widget-name-id',
			__( 'WP No Password', 'wp-no-password-locale' ),
			array(
				'classname'		=>	'wp-no-password-class',
				'description'	=>	__( 'WP No Password Login Widget.', 'wp-no-password-locale' )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

		// Require the TGM Plugin Activator
		require_once( plugin_dir_path( __FILE__ ) . 'classes/class-tgm-plugin-activation.php' );

	} // end constructor

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param	array	args		The array of form elements
	 * @param	array	instance	The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		echo $before_widget;

		// TODO:	Here is where you manipulate your widget's values based on their input fields

		include( plugin_dir_path( __FILE__ ) . '/views/widget.php' );

		echo $after_widget;

	} // end widget

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param	array	new_instance	The new instance of values to be generated via the update.
	 * @param	array	old_instance	The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		// TODO:	Here is where you update your widget's old values with the new, incoming values

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param	array	instance	The array of keys and values for the widget.
	 */
	public function form( $instance ) {

    	// TODO:	Define default values for your variables
		$instance = wp_parse_args(
			(array) $instance
		);

		// TODO:	Store the values of the widget in their own variable

		// Display the admin form
		include( plugin_dir_path(__FILE__) . '/views/admin.php' );

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {

		// TODO be sure to change 'widget-name' to the name of *your* plugin
		load_plugin_textdomain( 'wp-no-password-locale', false, plugin_dir_path( __FILE__ ) . '/lang/' );

	} // end widget_textdomain

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param		boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
		
		add_action( 'tgmpa_register', 'wp_no_password_required_plugins' );

	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here
	} // end deactivate

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		// TODO:	Change 'widget-name' to the name of your plugin
		wp_enqueue_style( 'widget-name-admin-styles', plugins_url( 'widget-name/css/admin.css' ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		// TODO:	Change 'widget-name' to the name of your plugin
		wp_enqueue_script( 'widget-name-admin-script', plugins_url( 'widget-name/js/admin.js' ), array('jquery') );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		// TODO:	Change 'widget-name' to the name of your plugin
		wp_enqueue_style( 'widget-name-widget-styles', plugins_url( 'widget-name/css/widget.css' ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		// TODO:	Change 'widget-name' to the name of your plugin
		wp_enqueue_script( 'widget-name-script', plugins_url( 'widget-name/js/widget.js' ), array('jquery') );

	} // end register_widget_scripts

	/**
	 * Define the paramaters for the necessary plugins to include with TGM Plugin Activator
	 */
	public function wp_no_password_required_plugins() {

		$plugins = array(

			array(
				'name'				=> 'PIKLIST | Rapid Development Framework',
				'slug'				=> 'piklist',
				'required'			=> true,
				'force_activation'	=> true,
			),
		);

		$theme_text_domain = 'wp-no-password-locale';

		$config = array(
			'domain'					=> $theme_text_domain,
			'default_path'				=> '',
			'parent_menu_slug'			=> 'themes.php',
			'parent_url_slug'			=> 'themes.php',
			'menu'						=> 'install-required-plugins',
			'has_notices'				=> true,
			'is_automatic'				=> false,
			'message'					=> '',
			'strings'					=> array(
				'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
				'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
				'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
				'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
				'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
				'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
				'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
				'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
				'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
				'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
				'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
				'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
				'nag_type'									=> 'updated'
			)
		);

		tgmpa( $plugins, $config );

	}

} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("WP_No_Password");' ) );
