<?php

/**
 * The {@link Helixware_Mico_Admin_Footer} hooks to the media attachment popup page to display additional information
 * coming from MICO.
 *
 * @since 1.3.0
 */
class Helixware_Mico_Admin_Footer {

	/**
	 * A {@link Helixware_Mico_Entity_Service} instance.
	 *
	 * @since 1.3.0
	 * @access private
	 * @var Helixware_Mico_Entity_Service $topic_service A {@link Helixware_Mico_Entity_Service} instance.
	 */
	private $entity_service;

	/**
	 * A {@link Helixware_Mico_Topic_Service} instance.
	 *
	 * @since 1.3.0
	 * @access private
	 * @var Helixware_Mico_Topic_Service $topic_service A {@link Helixware_Mico_Topic_Service} instance.
	 */
	private $topic_service;

	/**
	 * Create a {@link Helixware_Mico_Admin_Footer} instance.
	 *
	 * @since 1.3.0
	 *
	 * @param Helixware_Mico_Entity_Service $entity_service A {@link Helixware_Mico_Entity_Service} instance.
	 * @param Helixware_Mico_Topic_Service $topic_service A {@link Helixware_Mico_Topic_Service} instance.
	 */
	public function __construct( $entity_service, $topic_service ) {

		$this->entity_service = $entity_service;
		$this->topic_service  = $topic_service;

		add_action( 'admin_footer-upload.php', array( $this, 'admin_footer_upload' ), PHP_INT_MAX );

	}

	public function admin_footer_upload() {


	}

}