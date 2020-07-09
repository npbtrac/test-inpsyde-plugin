<?php


namespace TestInpsyde\Wp\Plugin\Services;


use TestInpsyde\Wp\Plugin\Traits\Config_Trait;
use TestInpsyde\Wp\Plugin\Traits\WP_Attribute_Trait;

class ViewService {
	use Config_Trait;
	use WP_Attribute_Trait;

	public function render( $view_file_path, $params = [] ) {
		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract( $params );
		if ( strpos( $view_file_path, '/' ) === 1 ) {
			return load_template( $view_file_path, false );
		} elseif ( ! empty( $template_content = locate_template( $view_file_path, true, false ) ) ) {
			return $template_content;
		}

		$error_message = sprintf( "View file not working: %s.\nTrace: %s", $view_file_path, print_r( debug_backtrace(), true ) );
		trigger_error( $error_message, E_USER_WARNING );

		return null;
	}
}
