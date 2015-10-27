<?php

/**
 * Manage Face Detection fragments.
 * @since 1.2.1
 */
class HelixWare_Mico_Face_Detection_Service extends HelixWare_Mico_Fragment_Service {

	const FRAGMENTS = 'faceFragments';

	/**
	 * Create an instance of the MICO Fragment service.
	 *
	 * @since 1.2.1
	 *
	 * @param \HelixWare_HAL_Client $hal_client A HAL client.
	 * @param string $server_url The server URL.
	 * @param \HelixWare_Asset_Service $asset_service The Asset service.
	 */
	public function __construct( $hal_client, $server_url, $asset_service ) {

		parent::__construct( self::FRAGMENTS, $hal_client, $server_url, $asset_service );

	}

	/**
	 * Handles the AJAX end-point _hw_face_detection_fragments_ providing the list
	 * of face detection fragments for the attachment with the id specified in the
	 * _id_ GET parameter.
	 *
	 * @since 1.3.0
	 */
	public function ajax_face_detection_fragments() {

		if ( ! isset( $_REQUEST['id'] ) || ! is_numeric( $_REQUEST['id'] ) ) {
			wp_send_json_error( 'The id parameter is required.' );
		}

		wp_send_json( $this->get_fragments_by_id( (int) $_REQUEST['id'] ) );

	}

}
