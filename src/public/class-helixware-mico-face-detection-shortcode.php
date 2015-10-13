<?php

/**
 * Provides the _hw_fragments_ shortcode.
 *
 * @package    HelixWare
 * @subpackage HelixWare/includes
 * @author     David Riccitelli <david@insideout.io>
 */
class HelixWare_Mico_Face_Detection_Shortcode {

	const HANDLE_NAME = 'hw_face_detection';

	/**
	 * The MICO Face Detection service.
	 *
	 * @since 1.2.1
	 * @access private
	 * @var \HelixWare_Mico_Face_Detection_Service $face_detection_service The MICO Face Detection service.
	 */
	private $face_detection_service;

	/**
	 * The Asset service.
	 *
	 * @since 1.2.0
	 * @access private
	 * @var \HelixWare_Asset_Service $asset_service The Asset service.
	 */
	private $asset_service;

	/**
	 * The Asset Image service.
	 *
	 * @since 1.2.0
	 * @access private
	 * @var \HelixWare_Asset_Image_Service $asset_image_service The Asset Image service.
	 */
	private $asset_image_service;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.0
	 *
	 * @param \Helixware_Mico_Face_Detection_Service $face_detection_service The MICO Face Detection service.
	 * @param \HelixWare_Asset_Service $asset_service The Asset service.
	 * @param \HelixWare_Asset_Image_Service $asset_image_service The Asset Image service.
	 */
	public function __construct( $face_detection_service, $asset_service, $asset_image_service ) {

		$this->face_detection_service = $face_detection_service;
		$this->asset_service          = $asset_service;
		$this->asset_image_service    = $asset_image_service;

		// Register itself as handler for the hw_fragments shortcode.
		add_shortcode( self::HANDLE_NAME, array( $this, 'render' ) );

	}

	/**
	 * Render the _hw_fragments_ shortcode.
	 *
	 * @since 1.2.0
	 *
	 * @param array $atts An array of shortcode attributes.
	 *
	 * @return string The HTML code.
	 */
	public function render( $atts ) {

		// We need a post ID.
		if ( ! isset( $atts['id'] ) || ! is_numeric( $atts['id'] ) ) {
			return '';
		}

		// The attachment ID.
		$id = $atts['id'];

		$html = "<ul>";
		foreach ( $this->face_detection_service->get_fragments_by_id( $id ) as $fragment ) {
			$html .= '<li style="float:left;"><img width="200" src="' . $this->asset_image_service->get_local_image_url_by_id( $id, $fragment->start / 1000, $fragment->x, $fragment->y, $fragment->width, $fragment->height ) . '" />' . $fragment->start . "($fragment->x, $fragment->y, $fragment->width, $fragment->height)" .  '</li>';
		}
		$html .= "</ul>";

		return $html;

	}

}
