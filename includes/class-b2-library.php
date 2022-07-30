<?php 
class B2_Private_Files_B2_Library {

    public static function authorize($application_key_id, $application_key){

		$credentials = base64_encode($application_key_id . ":" . $application_key);
		$url = "https://api.backblazeb2.com/b2api/v2/b2_authorize_account";
		
		$apiResponse = wp_remote_get( $url,
			[
				'headers'   => [
					'Accept' => 'application/json',
					'Authorization' => 'Basic ' . $credentials,
				],
			]
		);
		$apiBody     = json_decode( wp_remote_retrieve_body( $apiResponse ), true);
		return $apiBody;
	} // b2_authorize

	public static function get_upload_url($api_url, $auth_token, $bucket_id){

		$endpoint = $api_url .  "/b2api/v2/b2_get_upload_url";
 
		$body = [
			'bucketId'  => $bucket_id
		];
		 
		$body = wp_json_encode( $body );
		 
		$options = [
			'body'        => $body,
			'headers'     => [
				'Content-Type' => 'application/json',
				'Authorization' => $auth_token
			],
			'timeout'     => 60,
			'redirection' => 5,
			'blocking'    => true,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'data_format' => 'body',
		];
		 
		$apiResponse = wp_remote_post( $endpoint, $options );
		
		$apiBody = json_decode( wp_remote_retrieve_body( $apiResponse ), true);
		return $apiBody;

	}

	public static function upload_file(
			$my_file, $upload_url, $upload_auth_token, 
			$bucket_id, $content_type, $file_name
		){
		$endpoint = $upload_url;
		$handle = fopen($my_file, 'r');
		$read_file = fread($handle,filesize($my_file));
		$sha1_of_file_data = sha1_file($my_file);
		
		$body = $read_file;
			
		$options = [
			'body'        => $body,
			'headers'     => [
				'Authorization' => $upload_auth_token,
				'X-Bz-File-Name' => $file_name,
				'Content-Type' => $content_type,
				'X-Bz-Content-Sha1' => $sha1_of_file_data,
				'X-Bz-Info-Author' => 'unknown',
				'X-Bz-Server-Side-Encryption' => 'AES256'
			],
			'timeout'     => 60,
			'redirection' => 5,
			'blocking'    => true,
			'httpversion' => '1.0',
			'sslverify'   => true,
			'data_format' => 'body',
		];
			
		$apiResponse = wp_remote_post( $endpoint, $options );
		
		$apiBody = json_decode( wp_remote_retrieve_body( $apiResponse ), true);
		return $apiBody;			
	}

	public static function get_mime_type($filename) {
		$idx = explode( '.', $filename );
		$count_explode = count($idx);
		$idx = strtolower($idx[$count_explode-1]);
	
		$mimet = array( 
			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv',
	
			// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',
	
			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',
	
			// audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',
	
			// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',
	
			// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',
			'docx' => 'application/msword',
			'xlsx' => 'application/vnd.ms-excel',
			'pptx' => 'application/vnd.ms-powerpoint',
	
	
			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);
	
		if (isset( $mimet[$idx] )) {
		 return $mimet[$idx];
		} else {
		 return 'application/octet-stream';
		}
	 }

     public static function delete_file_version($api_url, $auth_token, $file_id, $file_name){

		$session = curl_init($api_url .  "/b2api/v2/b2_delete_file_version");

		// Add post fields
		$data = array("fileId" => $file_id, "fileName" => $file_name);
		$post_fields = json_encode($data);
		curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields); 

		// Add headers
		$headers = array();
		$headers[] = "Authorization: " . $auth_token;
		curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 

		curl_setopt($session, CURLOPT_POST, true); // HTTP POST
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
		$server_output = curl_exec($session); // Let's do this!
		curl_close ($session); // Clean up
		return json_decode($server_output, true); // Tell me about the rabbits, George!
	}

    public static function get_link($download_url, $bucket_name, $file_name, $token){
		$uri = $download_url . "/file/" . $bucket_name . "/" . $file_name;
		$uri .= '?Authorization=' . $token;
		return $uri;

	}

    public static function fetch_files_array(){
        $output = [];

        $options = get_option( 'b2_private_files_settings' );
        
        // authorize in b2 api
        $authorize = B2_Private_Files_B2_Library::authorize(
            $options['b2_private_files_account_id'],
            $options['b2_private_files_application_key']
        );


        $res = B2_Private_Files_B2_Library::list_file_names(
            $authorize['apiUrl'], 
            $authorize['authorizationToken'], 
            $options['b2_private_files_bucket_id']
        );


        foreach($res['files'] as $file){
            $output[] =  array(
                'ID'        => $file['fileId'],
                'fileName'     => $file['fileName'],
                'contentType'    => $file['contentType'],
                'uploadTimestamp'  => date("m/d/Y h:i A", $file['uploadTimestamp']/ 1000)
            );
        }

        return $output;

    }

    public static function list_file_names($api_url, $auth_token, $bucket_id){

		$session = curl_init($api_url .  "/b2api/v2/b2_list_file_names");

		// Add post fields
		$data = array("bucketId" => $bucket_id);
		$post_fields = json_encode($data);
		curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields); 

		// Add headers
		$headers = array();
		$headers[] = "Authorization: " . $auth_token;
		curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 

		curl_setopt($session, CURLOPT_POST, true); // HTTP POST
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
		$server_output = curl_exec($session); // Let's do this!
		curl_close ($session); // Clean up
		return json_decode($server_output, true);
	}

	/**
	 * 
	 * @param $api_url From b2_authorize_account call
	 * @param $auth_token From b2_authorize_account call
	 * @param $bucket_id The bucket that files can be downloaded from
	 * @param $valid_duration The number of seconds the authorization is valid for
	 * @param $file_name_prefix The file name prefix of files the download authorization will allow
	 */
	public static function get_download_authorization($api_url, $auth_token, $bucket_id, $file_name_prefix = "", $valid_duration = 86400){

		$session = curl_init($api_url .  "/b2api/v2/b2_get_download_authorization");

		// Add post fields
		$data = array("bucketId" => $bucket_id, 
					"validDurationInSeconds" => $valid_duration, 
					"fileNamePrefix" => $file_name_prefix);
		$post_fields = json_encode($data);
		curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields); 

		// Add headers
		$headers = array();
		$headers[] = "Authorization: " . $auth_token;
		curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 

		curl_setopt($session, CURLOPT_POST, true); // HTTP POST
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
		$server_output = curl_exec($session); // Let's do this!
		curl_close ($session); // Clean up
		return json_decode($server_output, true); // Tell me about the rabbits, George!
	}
}