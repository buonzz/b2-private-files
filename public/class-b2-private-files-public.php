<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.darwinbiler.com
 * @since      1.0.0
 *
 * @package    B2_Private_Files
 * @subpackage B2_Private_Files/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    B2_Private_Files
 * @subpackage B2_Private_Files/public
 * @author     Darwin Biler <darwin@bilersolutions.com>
 */
class B2_Private_Files_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in B2_Private_Files_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The B2_Private_Files_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/b2-private-files-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in B2_Private_Files_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The B2_Private_Files_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/b2-private-files-public.js', array( 'jquery' ), $this->version, false );

	}

	public function b2_private_file_render_button_shortcode($atts, $content, $tag){

		$label = 'Download';

		if(!isset($atts['filename']) || empty($atts['filename']))
			return $output;

		if(!isset($atts['filename']) || empty($atts['filename']))
			$label = $atts['filename'];


		if(!isset($atts['expire_after']) || empty($atts['expire_after']))
			$atts['expire_after'] = 60;

		
		$atts['expire_after'] = (int) $atts['expire_after'];

		$options = get_option( 'b2_private_files_settings');
		$fileName = $atts['filename'];

		// authorize in b2 api
		$authorize = B2_Private_Files_B2_Library::authorize(
			$options['b2_private_files_account_id'],
			$options['b2_private_files_application_key']
		);

		$download_authorization =  B2_Private_Files_B2_Library::get_download_authorization(
			$authorize['apiUrl'],
			$authorize['authorizationToken'],
			$options['b2_private_files_bucket_id'],
			$atts['filename'],
			$atts['expire_after']
		);

		if(isset($download_authorization['code']) && $download_authorization['code'] == 'bad_request')
			return '';

		$link = B2_Private_Files_B2_Library::get_link(
			$authorize['downloadUrl'], 
			$options['b2_private_files_bucket_name'],
			$fileName,
			$download_authorization['authorizationToken']
		);


		$a = shortcode_atts( array(
			'link' => $link,
			'id' => 'b2-private-file-' . random_int(1000,2000),
			'label' => $label,
			'target' => '_blank',
			'class' => 'b2-button wp-block-button__link'
			), $atts );

		$output = '<div class="wp-block-button b2-private-file-button">
				<a href="' 
				. esc_url( $a['link'] ) . '" id="' . esc_attr( $a['id'] ) 
				. '" class="' .  $a['class']
				. '" target="' . esc_attr($a['target']) . '">' 
					. esc_attr( $a['label'] ) 
				. '</a>
			</div>';
		

		return $output;	
	}
}
