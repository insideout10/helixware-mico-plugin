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

}
