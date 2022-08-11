<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.darwinbiler.com
 * @since      1.0.0
 *
 * @package    B2_Private_Files
 * @subpackage B2_Private_Files/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    B2_Private_Files
 * @subpackage B2_Private_Files/admin
 * @author     Darwin Biler <darwin@bilersolutions.com>
 */
class B2_Private_Files_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		include plugin_dir_path( __DIR__ ) . 'includes/class-b2-library.php';

	}

	/**
	 * Register the stylesheets for the admin area.
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

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/b2-private-files-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script("jquery");

	}

	public function settings_page(){
		add_options_page( 'B2 Private Files', 
			'B2 Private Files', 'manage_options', 
			'b2-private-files-settings-page', 
			[&$this, 'render_settings_page'] 
		);
	}

	function settings_init(  ) {

		register_setting( 'b2-private-files', 'b2_private_files_settings' );
		add_settings_section(
			'b2_private_files_section',
			__( '', 'wordpress' ),
			[$this, 'section_callback'],
			'b2-private-files'
		);
	
		add_settings_field(
			'b2_private_files_account_id',
			__( 'Account ID / Key ID', 'wordpress' ),
			[$this, 'render_account_id'],
			'b2-private-files',
			'b2_private_files_section'
		);
	
		add_settings_field(
			'b2_private_files_application_key',
			__( 'Application Key', 'wordpress' ),
			[$this, 'render_application_key'],
			'b2-private-files',
			'b2_private_files_section'
		);

		add_settings_field(
			'b2_private_files_bucket_id',
			__( 'Bucket ID', 'wordpress' ),
			[$this, 'render_bucket_id'],
			'b2-private-files',
			'b2_private_files_section'
		);

		add_settings_field(
			'b2_private_files_bucket_name',
			__( 'Bucket Name', 'wordpress' ),
			[$this, 'render_bucket_name'],
			'b2-private-files',
			'b2_private_files_section'
		);
	}

	function section_callback(){
		echo __( 'Login to BackBlaze B2 and generate a new key for accessing your account.', 'wordpress' );
	}

	function render_account_id() {
		$options = get_option( 'b2_private_files_settings' );
		?>
		<input type='text' name='b2_private_files_settings[b2_private_files_account_id]' value='<?php echo esc_attr($options['b2_private_files_account_id']); ?>'/>
		<?php
	}
	
	function render_application_key() {
		$options = get_option( 'b2_private_files_settings' );
		?>
		<input type='text' name='b2_private_files_settings[b2_private_files_application_key]' value='<?php echo esc_attr($options['b2_private_files_application_key']); ?>'/>
	<?php
	}

	function render_bucket_id() {
		$options = get_option( 'b2_private_files_settings' );
		?>
		<input type='text' name='b2_private_files_settings[b2_private_files_bucket_id]' value='<?php echo esc_attr($options['b2_private_files_bucket_id']); ?>'/>
	<?php
	}

	function render_bucket_name() {
		$options = get_option( 'b2_private_files_settings' );
		?>
		<input type='text' name='b2_private_files_settings[b2_private_files_bucket_name]' value='<?php echo esc_attr($options['b2_private_files_bucket_name']); ?>'/>
	<?php
	}

	public function render_settings_page(){
?>
    <form action='options.php' method='post'>

	<h2>B2 Private Files Settings</h2>

	<?php
	settings_fields( 'b2-private-files' );
	do_settings_sections( 'b2-private-files' );
	submit_button();
	?>

	</form>
<?php
	} // render_settings_page

	public function add_upload_page_submenu(){
		$page = add_submenu_page(
			'upload.php', 
			'Add New (Private) - B2 Private Files', 
			'Add New (Private)', 
			'upload_files',
			'b2-private-files-upload-page',
			[&$this, 'render_uploads_page']
		);
		add_action( 'load-' . $page, [$this, 'load_upload_page_js'] );
	}

	public function load_upload_page_js(){
		add_action( 'admin_enqueue_scripts', [$this, 'enqueue_upload_page_js'] );
	}

	public function enqueue_upload_page_js(){
		wp_enqueue_script( 'b2-private-files-upload-page', plugin_dir_url( __FILE__ ) .'js/upload-page.js', array( 'jquery') );
	}


	public function render_uploads_page(){
		include plugin_dir_path( __FILE__ ) . 'partials/upload_page.php';
	}

	public function on_upload_page_submitted(){

		$options = get_option( 'b2_private_files_settings');

		$upload_dir_info =  wp_upload_dir();
		$target_dir = $upload_dir_info['path'] . '/';
		$error_message = '';
		$content_type = B2_Private_Files_B2_Library::get_mime_type($_FILES["uploadFile"]["name"]);


		$target_file = $target_dir . basename($_FILES["uploadFile"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check file size
		if ($_FILES["uploadFile"]["size"] > wp_max_upload_size()) {
			$error_message = "Sorry, your file is too large.";
			$uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "xls") {
			$error_message = "Sorry, file type not allowed.";
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 1) {
			if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {
				$error_message = 'file upload success';

				// authorize in b2 api
				$authorize = B2_Private_Files_B2_Library::authorize(
					$options['b2_private_files_account_id'],
					$options['b2_private_files_application_key']
				);

				if(isset($resp['status']) && $resp['status'] == 401)
					$error_message = "B2 Credentials Invalid";

				// get upload url
				$upload_url = B2_Private_Files_B2_Library::get_upload_url(
					$authorize['apiUrl'], 
					$authorize['authorizationToken'], 
					$options['b2_private_files_bucket_id']
				);


				// upload it
				$upload_resp = B2_Private_Files_B2_Library::upload_file(
					$target_file, $upload_url['uploadUrl'], $upload_url['authorizationToken'], 
					$options['b2_private_files_bucket_id'], $content_type, $_FILES["uploadFile"]["name"]
				);

				if(isset($upload_resp['code']) && $upload_resp['code'] == 'bad_request'){
					$error_message = $upload_resp['message'];
				}

				// delete it once uploaded to b2
				unlink( $target_file);

				wp_redirect( admin_url( 'upload.php?page=b2-private-files-upload-page&message=' . $error_message ) );
				exit;
			} else {
				$error_message = "Sorry, there was an error uploading your file.";
			}
		} 

	  	wp_redirect( admin_url( 'upload.php?page=b2-private-files-upload-page&message='. $error_message ) );
        exit;
	}

	public function render_library_page(){
		include plugin_dir_path( __FILE__ ) . 'private-files-table.php';
		include plugin_dir_path( __FILE__ ) . 'partials/library_page.php';
	}

	public function on_file_delete(){

		$options = get_option( 'b2_private_files_settings');
		$fileId = sanitize_key($_GET['fileId']);
		$fileName = sanitize_file_name($_GET['fileName']);

		// authorize in b2 api
		$authorize = B2_Private_Files_B2_Library::authorize(
			$options['b2_private_files_account_id'],
			$options['b2_private_files_application_key']
		);

		B2_Private_Files_B2_Library::delete_file_version(
			$authorize['apiUrl'], 
			$authorize['authorizationToken'], 
			$fileId,
			$fileName
		);

	  	wp_redirect( admin_url( 'upload.php?page=b2-private-files-library-page' ) );
        exit;
	}

	public function on_file_view(){

		$options = get_option( 'b2_private_files_settings');
		$fileName = sanitize_file_name($_GET['fileName']);

		// authorize in b2 api
		$authorize = B2_Private_Files_B2_Library::authorize(
			$options['b2_private_files_account_id'],
			$options['b2_private_files_application_key']
		);

		$link = B2_Private_Files_B2_Library::get_link(
			$authorize['downloadUrl'], 
			$options['b2_private_files_bucket_name'],
			$fileName,
			$authorize['authorizationToken']
		);

	  	wp_redirect( $link );
        exit;
	}

	public function add_library_page_submenu(){
		$page = add_submenu_page(
			'upload.php', 
			'Library (Private) - B2 Private Files', 
			'Library (Private)', 
			'upload_files',
			'b2-private-files-library-page',
			[&$this, 'render_library_page']
		);
	}

	public function add_code_page_submenu(){
		$page = add_submenu_page(
			null, 
			'B2 Private Files - Shortcodes', 
			'Shortcodes', 
			'upload_files',
			'b2-private-files-code-page',
			[&$this, 'render_code_page']
		);
	}

	public function render_code_page(){

		$options = get_option( 'b2_private_files_settings');
		$fileName = sanitize_file_name($_GET['fileName']);

		include plugin_dir_path( __FILE__ ) . 'partials/code_page.php';
	}
}
