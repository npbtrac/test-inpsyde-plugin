<?php
/**
 * Plugin Name: Test for Inpsyde
 * Description: Plugin for checking out using Tamara payment method
 * Author:      nptrac@yahoo.com
 * Text Domain: inpsyde
 */

use TestInpsyde\Wp\Plugin\Test_Inpsyde;

// Use autoload if it isn't loaded before
if ( ! class_exists( Test_Inpsyde::class ) ) {
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
}

$text_domain = 'tamara';

$config = [
	'base_path'         => __DIR__,
	'base_url'          => plugins_url( null, __FILE__ ),
	'text_domain'       => $text_domain,
	'service_providers' => [

	],
];

register_activation_hook( __FILE__, [ Test_Inpsyde::class, 'activate_plugin' ] );
register_deactivation_hook( __FILE__, [ Test_Inpsyde::class, 'deactivate_plugin' ] );

// We need to set up the main instance for the plugin.
// Use 'init' event but with low (<10) processing order to be able to execute before -> able to add other init
add_action( 'init', function () use ( $config ) {
	/** @noinspection PhpUnusedDeclarationInspection */
	Test_Inpsyde::init_instance_with_config( $config );
}, 7 );
