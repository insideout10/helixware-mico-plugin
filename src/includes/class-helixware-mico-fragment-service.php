<?php

/**
 * This class manages Fragments for assets.
 *
 * @since      1.0.0
 * @package    Helixware_Mico
 * @subpackage Helixware_Mico/includes
 * @author     David Riccitelli <david@insideout.io>
 */
class Helixware_Mico_Fragment_Service {

	const FIND_BY_ASSET_GUID_PATH = '/%s/search/findByAssetGUID?guid=%s';

	/**
	 * The name of the fragments component.
	 *
	 * @since 1.2.1
	 * @access private
	 * @var string $fragments The name of the fragments component.
	 */
	private $fragments;

	/**
	 * A HAL client.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var \HelixWare_HAL_Client $hal_client A HAL client.
	 */
	private $hal_client;

	/**
	 * The MICO server URL.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string $server_url The MICO server URL.
	 */
	private $server_url;

	/**
	 * The Asset service.
	 *
	 * @since 1.2.0
	 * @access private
	 * @var \HelixWare_Asset_Service The Asset service.
	 */
	private $asset_service;

	/**
	 * Create an instance of the MICO Fragment service.
	 *
	 * @since 1.0.0
	 *
	 * @param string $fragments The fragments part in the path.
	 * @param \HelixWare_HAL_Client $hal_client A HAL client.
	 * @param string $server_url The server URL.
	 * @param \HelixWare_Asset_Service $asset_service The Asset service.
	 */
	public function __construct( $fragments, $hal_client, $server_url, $asset_service ) {

		$this->fragments     = $fragments;
		$this->hal_client    = $hal_client;
		$this->server_url    = $server_url;
		$this->asset_service = $asset_service;
	}

	/**
	 * Get the fragments for the specified GUID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $guid The asset GUID.
	 *
	 * @return array An array of fragments.
	 */
	public function get_fragments( $guid ) {

		$path    = sprintf( self::FIND_BY_ASSET_GUID_PATH, $this->fragments, urlencode( $guid ) );
		$request = new HelixWare_HAL_Request( 'GET', $this->server_url . $path );

		$response = $this->hal_client->execute( $request );

		$fragments = array();
		do {

			$fragments = array_merge( $fragments, $response->get_embedded( $this->fragments ) );

		} while ( $response->has_next() && NULL !== ( $response = $response->get_next() ) );

		return $fragments;

	}

	/**
	 * Get the fragments for the specified post ID.
	 *
	 * @since 1.2.0
	 *
	 * @param int $id The post ID.
	 *
	 * @return array An array of fragments.
	 */
	public function get_fragments_by_id( $id ) {

		return $this->get_fragments( $this->asset_service->get_guid( $id ) );

	}

}
