<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       natehobi.com
 * @since      1.0.0
 *
 * @package    Wp_Persist_Request_Parameters
 * @subpackage Wp_Persist_Request_Parameters/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Persist_Request_Parameters
 * @subpackage Wp_Persist_Request_Parameters/includes
 * @author     Nate Hobi <nate.hobi@gmail.com>
 */
class Wp_Persist_Request_Parameters_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-persist-request-parameters',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
