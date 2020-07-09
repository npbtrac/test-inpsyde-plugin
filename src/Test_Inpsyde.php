<?php


namespace TestInpsyde\Wp\Plugin;

use Exception;
use WP;
use Illuminate\Container\Container;
use TestInpsyde\Wp\Plugin\Services\View_Service;
use TestInpsyde\Wp\Plugin\Traits\Service_Trait;
use TestInpsyde\Wp\Plugin\Traits\Config_Trait;
use TestInpsyde\Wp\Plugin\Traits\WP_Attribute_Trait;

class Test_Inpsyde extends Container {

	use Config_Trait;
	use WP_Attribute_Trait;

	const CUSTOM_ENDPOINT_NAME = 'custom-inpsyde';

	/** @noinspection PhpUnusedElementInspection */
	/**
	 * @var string Base path to this plugin
	 */
	public $base_path;

	/**
	 * @var string Base url of the folder of this plugin
	 */
	public $base_url;

	/**
	 * Tamara_Checkout constructor.
	 *
	 * @param $config
	 */
	public function __construct( $config ) {
		$this->bind_config( $config );

		if ( ! empty( $services = $config['services'] ?? null ) ) {
			$this->register_services( $services );
		}
	}

	/**
	 * Register service providers set in config
	 *
	 * @param $service_providers
	 */
	protected function register_services( $service_providers ) {
		foreach ( $service_providers as $service_classname => $service_config ) {
			if ( class_exists( $service_classname ) ) {
				$this->bind( $service_classname, function ( $container ) use ( $service_classname, $service_config ) {
					$service_instance = new $service_classname();
					if ( method_exists( $service_instance, 'bind_config' ) ) {
						$service_instance->bind_config( $service_config );
					}

					if ( in_array( Service_Trait::class, class_uses( $service_instance ) ) ) {
						/** @noinspection PhpUndefinedMethodInspection */
						$service_instance->set_container( $container );
						/** @noinspection PhpUndefinedMethodInspection */
						$service_instance->init();
					}

					return $service_instance;
				} );
			}
		}
	}

	/** @noinspection PhpFullyQualifiedNameUsageInspection */
	/**
	 * @param $alias
	 *
	 * @return mixed
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
	public function get_service( $alias ) {
		return $this->make( $alias );
	}

	/**
	 * @param $config
	 *
	 * @throws Exception
	 */
	public static function init_instance_with_config( $config ) {
		if ( is_null( static::$instance ) ) {
			static::setInstance( new static( $config ) );
		}

		if ( ! static::getInstance() instanceof static ) {
			throw new Exception( __( 'No plugin initialized.' ) );
		}
		static::getInstance()->init_plugin();
	}

	/**
	 * Do some needed things when activate plugin
	 */
	public static function activate_plugin() {
		// Add rewrite rules
		static::add_custom_rewrite_rules();

		// Flush rewrite rules when activate plugins
		flush_rewrite_rules( false );
	}

	/**
	 * Do some needed things when de-activate plugin
	 */
	public static function deactivate_plugin() {
		// The problem with calling flush_rewrite_rules() is that the rules instantly get regenerated, while your plugin's hooks are still active.
		delete_option( 'rewrite_rules' );
	}

	/**
	 * Initialize all needed things for this plugin: hooks, assignments ...
	 */
	protected function init_plugin() {
		add_action( 'init', array( get_called_class(), 'add_custom_rewrite_rules' ) );

		// We use `init` hook to avoid parse_request process because we want to use custom request
		add_action( 'init', array( $this, 'render_custom_inpsyde_response' ), 1000 );
	}

	/**
	 * Add rewrite rule for Tamara IPN response page
	 */
	public static function add_custom_rewrite_rules() {
		add_rewrite_rule( 'custom-inpsyde/?$', 'index.php?pagename=' . static::CUSTOM_ENDPOINT_NAME, 'top' );
	}

	/** @noinspection PhpFullyQualifiedNameUsageInspection */
	/**
	 * Handle response for custom endpoint
	 *
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
	public function render_custom_inpsyde_response() {
		// We need to parse request here to fetch our needed query_var because this method would be call before main query executed
		$the_wp = new WP();
		$the_wp->parse_request();

		$pagename = $the_wp->query_vars['pagename'] ?? null;

		if ( static::CUSTOM_ENDPOINT_NAME === $pagename ) {
			/** @var View_Service $view_service */
			$view_service = $this->get_service( View_Service::class );

			echo $view_service->render( 'views/custom-insyde' );
			exit;
		}
	}
}
