<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.darwinbiler.com
 * @since             1.0.0
 * @package           B2_Private_Files
 *
 * @wordpress-plugin
 * Plugin Name:       B2 Private Files
 * Plugin URI:        https://github.com/buonzz/b2-private-files
 * Description:       Serve token-protected private files hosted in Backblaze B2.
 * Version:           1.0.0
 * Author:            Darwin Biler
 * Author URI:        https://www.darwinbiler.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       b2-private-files
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'B2_PRIVATE_FILES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-b2-private-files-activator.php
 */
function activate_b2_private_files() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-b2-private-files-activator.php';
	B2_Private_Files_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-b2-private-files-deactivator.php
 */
function deactivate_b2_private_files() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-b2-private-files-deactivator.php';
	B2_Private_Files_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_b2_private_files' );
register_deactivation_hook( __FILE__, 'deactivate_b2_private_files' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-b2-private-files.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_b2_private_files() {

	$plugin = new B2_Private_Files();
	$plugin->run();

}
run_b2_private_files();
