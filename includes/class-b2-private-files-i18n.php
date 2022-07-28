<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.darwinbiler.com
 * @since      1.0.0
 *
 * @package    B2_Private_Files
 * @subpackage B2_Private_Files/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    B2_Private_Files
 * @subpackage B2_Private_Files/includes
 * @author     Darwin Biler <darwin@bilersolutions.com>
 */
class B2_Private_Files_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'b2-private-files',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
