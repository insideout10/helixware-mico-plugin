<?php

/**
 * This class manages Fragments for assets.
 *
 * @since      1.0.0
 * @package    Helixware_Mico
 * @subpackage Helixware_Mico/includes
 * @author     David Riccitelli <david@insideout.io>
 */
class Helixware_Mico_Sequence_Service extends Helixware_Mico_Fragment_Service {

	const FRAGMENTS = "sequenceFragments";

	/**
	 * Create an instance of the MICO Fragment service.
	 *
	 * @since 1.0.0
	 *
	 * @param \HelixWare_HAL_Client $hal_client A HAL client.
	 * @param string $server_url The server URL.
	 * @param \HelixWare_Asset_Service $asset_service The Asset service.
	 */
	public function __construct( $hal_client, $server_url, $asset_service ) {

		parent::__construct( self::FRAGMENTS, $hal_client, $server_url, $asset_service );

	}

	/**
	 * Get the VTT chapters URL.
	 *
	 * @since 1.2.0
	 *
	 * @param int $id The post ID.
	 *
	 * @return string The local URL to the VTT chapters URL.
	 */
	public function get_vtt_chapters_url( $id ) {

		return admin_url( "admin-ajax.php?action=hw_vtt_chapters&id=$id" );
	}

	/**
	 * Echo a jwplayer:track line linking to the chapters file.
	 *
	 * @since 1.2.0
	 *
	 * @param WP_Post $post A post instance.
	 */
	public function playlist_rss_jwplayer_header( $post ) {

		echo( '<jwplayer:track file="' . htmlentities( $this->get_vtt_chapters_url( $post->ID ) ) . '" kind="chapters" />' . "\n" );

	}

	/**
	 * Outputs a VTT file defining the chapters for the attachment with the provided id.
	 *
	 * @since 1.2.0
	 */
	public function ajax_vtt_chapters() {

		// Check that a post ID has been provided.
		if ( ! isset( $_GET['id'] ) || ! is_numeric( $_GET['id'] ) ) {
			wp_die( 'A numeric id is required.' );
		}

		echo( "WEBVTT\n\n" );

		$chapter_no = 0;
		$fragments  = $this->get_fragments_by_id( $_GET['id'] );

		array_walk( $fragments, function ( $fragment ) use ( &$chapter_no ) {

			echo( 'chapter_' . ( ++ $chapter_no ) . "\n" );
			echo( HelixWare_Helper::milliseconds_to_timecode( $fragment->start ) . " --> " . HelixWare_Helper::milliseconds_to_timecode( $fragment->end ) . "\n" );
			echo( 'Chapter ' . $chapter_no . "\n" );
			echo( "\n" );

		} );

		wp_die();

	}

}
