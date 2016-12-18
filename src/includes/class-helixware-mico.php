<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://insideout.io
 * @since      1.0.0
 *
 * @package    Helixware_Mico
 * @subpackage Helixware_Mico/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Helixware_Mico
 * @subpackage Helixware_Mico/includes
 * @author     David Riccitelli <david@insideout.io>
 */
class Helixware_Mico {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Helixware_Mico_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * An HTTP Client to perform remote requests.
	 *
	 * @since 1.2.0
	 * @access private
	 * @var \HelixWare_HTTP_Client $http_client An HTTP Client.
	 */
	private $http_client;

	/**
	 * A HAL Client.
	 *
	 * @since 1.2.0
	 * @access private
	 * @var \HelixWare_HAL_Client $hal_client An HAL Client.
	 */
	private $hal_client;

	/**
	 * The MICO Sequence fragment service.
	 *
	 * @since 1.2.1
	 * @access private
	 * @var \Helixware_Mico_Sequence_Service $sequence_service The MICO Sequence fragment service.
	 */
	private $sequence_service;

	/**
	 * The MICO Face Detection fragment service.
	 *
	 * @since 1.2.1
	 * @access private
	 * @var \HelixWare_Mico_Face_Detection_Service $face_detection_service The MICO Face Detection fragment service.
	 */
	private $face_detection_service;

	/**
	 * The MICO Topic fragment service.
	 *
	 * @since 1.3.0
	 * @access private
	 * @var \Helixware_Mico_Topic_Service $topic_service The MICO Topic fragment service.
	 */
	private $topic_service;

	/**
	 * The MICO Entity fragment service.
	 *
	 * @since 1.3.0
	 * @access private
	 * @var \Helixware_Mico_Entity_Service $entity_service The MICO Entity fragment service.
	 */
	private $entity_service;

	/**
	 * The hw_fragments shortcode handler.
	 *
	 * @since 1.2.0
	 * @access private
	 * @var \HelixWare_Mico_Face_Detection_Shortcode $face_detection_shortcode The hw_fragments shortcode handler.
	 */
	private $face_detection_shortcode;

	/**
	 * The plugin requirements service.
	 *
	 * @since 1.3.0
	 * @access private
	 * @var \HelixWare_Mico_Requirements_Service $requirements_service The plugin requirements service.
	 */
	private $requirements_service;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'helixware-mico';
		$this->version     = '1.3.0-dev';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Helixware_Mico_Loader. Orchestrates the hooks of the plugin.
	 * - Helixware_Mico_i18n. Defines internationalization functionality.
	 * - Helixware_Mico_Admin. Defines all hooks for the admin area.
	 * - Helixware_Mico_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-helixware-mico-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-helixware-mico-i18n.php';

		/**
		 * The Log service.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-helixware-mico-log-service.php';

		/**
		 * Load fragments from MICO.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-helixware-mico-fragment-service.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-helixware-mico-sequence-service.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-helixware-mico-face-detection-service.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-helixware-mico-topic-service.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-helixware-mico-entity-service.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-helixware-mico-admin.php';

		/** Hook to the admin footer and display topics and entities related to an asset. */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-helixware-mico-admin-footer.php';

		/**
		 * Load admin classes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-helixware-mico-notice-service.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-helixware-mico-requirements-service.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-helixware-mico-public.php';

		/**
		 * The hw_fragments shortcode.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-helixware-mico-face-detection-shortcode.php';

		$this->loader = new Helixware_Mico_Loader();

		$notice_service             = new HelixWare_Mico_Notice_Service();
		$this->requirements_service = new HelixWare_Mico_Requirements_Service( $notice_service );

		// Instantiate all the classes.
		// Create the Basic authentication strategy.
		// Pass the strategy to the HTTP Client.
		// The HTTP Client is needed by the HAL Client.
		$http_authentication = new HelixWare_HTTP_Client_Basic_Authentication( HELIXWARE_MICO_GW_USERNAME, HELIXWARE_MICO_GW_PASSWORD );
		$this->http_client   = new HelixWare_HTTP_Client( $http_authentication );
		$this->hal_client    = new HelixWare_HAL_Client( $this->http_client );

		$helixware                      = HelixWare::get_instance();
		$this->sequence_service         = new Helixware_Mico_Sequence_Service( $this->hal_client, HELIXWARE_MICO_GW_URL, $helixware->get_asset_service() );
		$this->face_detection_service   = new HelixWare_Mico_Face_Detection_Service( $this->hal_client, HELIXWARE_MICO_GW_URL, $helixware->get_asset_service() );
		$this->face_detection_shortcode = new HelixWare_Mico_Face_Detection_Shortcode( $this->face_detection_service, $helixware->get_asset_service(), $helixware->get_asset_image_service() );

		$this->topic_service  = new HelixWare_Mico_Topic_Service( $this->hal_client, HELIXWARE_MICO_GW_URL, $helixware->get_asset_service() );
		$this->entity_service = new Helixware_Mico_Entity_Service( $this->hal_client, HELIXWARE_MICO_GW_URL, $helixware->get_asset_service() );

		$admin_footer = new Helixware_Mico_Admin_Footer( $this->entity_service, $this->topic_service );
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Helixware_Mico_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Helixware_Mico_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Helixware_Mico_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_ajax_hw_vtt_chapters', $this->sequence_service, 'ajax_vtt_chapters' );

		// Hook the requirements service.
		$this->loader->add_action( 'admin_init', $this->requirements_service, 'admin_init' );

		// Add topics and entities actions.
		$this->loader->add_action( 'wp_ajax_hx_topics', $this->topic_service, 'wp_ajax_fragments_by_id' );
		$this->loader->add_action( 'wp_ajax_hx_entities', $this->entity_service, 'wp_ajax_fragments_by_id' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Helixware_Mico_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Provide an AJAX end-point to load the video chapters.
		$this->loader->add_action( 'wp_ajax_nopriv_hw_vtt_chapters', $this->sequence_service, 'ajax_vtt_chapters' );

		// Hook to the hewa_playlist_rss_jwplayer_header action, which is triggered when the RSS/JWPlayer
		// playlist is generated. We add the chapters track.
		$this->loader->add_action( 'hewa_playlist_rss_jwplayer_header', $this->sequence_service, 'playlist_rss_jwplayer_header' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Helixware_Mico_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
