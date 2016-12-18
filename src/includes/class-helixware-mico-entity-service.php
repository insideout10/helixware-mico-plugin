<?php

/**
 * This class manages Fragments for assets.
 *
 * @since      1.3.0
 * @package    Helixware_Mico
 * @subpackage Helixware_Mico/includes
 * @author     David Riccitelli <david@insideout.io>
 */
class Helixware_Mico_Entity_Service extends Helixware_Mico_Fragment_Service {

	const FRAGMENTS = "entityFragments";

	/**
	 * Create an instance of the MICO Fragment service.
	 *
	 * @since 1.3.0
	 *
	 * @param \HelixWare_HAL_Client $hal_client A HAL client.
	 * @param string $server_url The server URL.
	 * @param \HelixWare_Asset_Service $asset_service The Asset service.
	 */
	public function __construct( $hal_client, $server_url, $asset_service ) {

		parent::__construct( self::FRAGMENTS, $hal_client, $server_url, $asset_service );

	}

}
