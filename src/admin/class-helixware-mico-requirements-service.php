<?php

/**
 * Check that the plugin requirements are satisfied. The existence and the activation
 * of HelixWare are actually superfluous checks because we don't get executed if
 * HelixWare is not installed and active.
 *
 * @since 1.3.0
 */
class HelixWare_Mico_Requirements_Service {

	const HELIXWARE_PLUGIN_FOLDER = '/helixware';
	const HELIXWARE_PLUGIN_FILE = 'helixware/helixware.php';
	const HELIXWARE_PLUGIN_SLUG = 'helixware';
	const HELIXWARE_VERSION = '1.3.0';

	/**
	 * The Notice service.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var \HelixWare_Mico_Notice_Service $notice_service The Notice service.
	 */
	private $notice_service;

	/**
	 * Create an instance of the Requirements service.
	 *
	 * @since 1.0.0
	 *
	 * @param \HelixWare_Mico_Notice_Service $notice_service The Notice service.
	 */
	public function __construct( $notice_service ) {

		$this->notice_service = $notice_service;

	}

	/**
	 * Called when the admin_init action hook is called.
	 *
	 * @since 1.0.0
	 */
	public function admin_init() {

		$this->is_valid();

	}

	public function is_valid() {

		// Check if the HelixWare plugin is installed, otherwise show a notice.
		if ( NULL === ( $helixware_plugin = $this->get_helixware_plugin() ) ) {

			$this->notice_service->add_error( sprintf( __( 'HelixWare MICO requires HelixWare plugin, which is not installed on this web site: <a href="%s">Install Now</a>.' ), $this->get_plugin_install_link( self::HELIXWARE_PLUGIN_SLUG ) ) );

			return FALSE;

		}

// TODO: add version checks.
		// Add an error if the installed version doesn't match the one we used for
		// development and testing, but continue anyway.
//		if ( self::HELIXWARE_VERSION !== ( $plugin_version = $helixware_plugin['Version'] ) ) {
//
//			$this->notice_service->add_error( sprintf( __( 'TvGestori has been tested with User Access Manager v%s. Currently v%s is installed.' ), self::USER_ACCESS_MANAGER_VERSION, $plugin_version ) );
//
//		}

		// Check if the HelixWare plugin is activated, otherwise show a notice.
		if ( ! is_plugin_active( self::HELIXWARE_PLUGIN_FILE ) ) {

			$this->notice_service->add_error( sprintf( __( 'HelixWare MICO requires HelixWare plugin, which is installed, but not active: <a href="%s"> Activate Now </a>.' ), $this->get_plugin_activate_link( self::HELIXWARE_PLUGIN_FILE ) ) );

			return FALSE;

		}

		return TRUE;

	}

	/**
	 * Get the HelixWare plugin.
	 *
	 * @since 1.3.0
	 *
	 * @return array|NULL An array describing the plugin or NULL if not found.
	 */
	private function get_helixware_plugin() {

		$plugins = get_plugins( self::HELIXWARE_PLUGIN_FOLDER );

		if ( 0 === sizeof( $plugins ) ) {
			return NULL;
		}

		return $plugins[ key( $plugins ) ];

	}

	/**
	 * Get an install link to a plugin.
	 *
	 * @since 1.0.0
	 *
	 * @param string $plugin_name The plugin slug.
	 *
	 * @return string A plugin install URL.
	 */
	private function get_plugin_install_link( $plugin_name ) {

		$action = 'install-plugin';

		return wp_nonce_url( add_query_arg( array(
			'action' => $action,
			'plugin' => $plugin_name
		), admin_url( 'update.php' ) ), $action . '_' . $plugin_name );

	}

	/**
	 * Provides the link to activate a plugin.
	 *
	 * @since 1.0.0
	 *
	 * @param string $plugin_file The path/file to a plugin.
	 *
	 * @return string The URL link to activate a plugin.
	 */
	private function get_plugin_activate_link( $plugin_file ) {

		$action = 'activate-plugin';

		return wp_nonce_url( add_query_arg( array(
			'action' => 'activate',
			'plugin' => $plugin_file
		), admin_url( 'plugins.php' ) ), $action . '_' . $plugin_file );

	}

}
