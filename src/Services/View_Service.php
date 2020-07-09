<?php

namespace TestInpsyde\Wp\Plugin\Services;


use TestInpsyde\Wp\Plugin\Traits\Config_Trait;
use TestInpsyde\Wp\Plugin\Traits\Service_Trait;
use TestInpsyde\Wp\Plugin\Traits\WP_Attribute_Trait;

class View_Service {
	use Config_Trait;
	use WP_Attribute_Trait;
	use Service_Trait;

	public $base_path;
	public $base_url;

	/**
	 * @inheritDoc
	 */
	public function init() {
		$this->base_path = $this->get_container()->base_path;
		$this->base_url  = $this->get_container()->base_url;
	}

	/**
	 * @param $view_file_path
	 * @param array $params
	 *
	 * @return string|void|null
	 */
	public function render( $view_file_path, $params = [] ) {
		$extension = '.php';
		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract( $params );
		if ( strpos( $view_file_path, '/' ) === 1 ) {
			return load_template( $view_file_path, false );
		} elseif ( ! empty( $template_content = locate_template( $view_file_path . $extension, true, false ) ) ) {
			return $template_content;
		} elseif ( file_exists( $this->base_path . DIRECTORY_SEPARATOR . $view_file_path . $extension ) ) {
			return load_template( $this->base_path . DIRECTORY_SEPARATOR . $view_file_path . $extension, false );
		}

		$error_message = sprintf( "View file not working: %s.\nTrace: %s", $view_file_path . $extension, print_r( debug_backtrace(), true ) );
		trigger_error( $error_message, E_USER_WARNING );

		return null;
	}
}
