<?php
/**
 * Bootstrap file
 *
 * Bootstrap file of the plugin
 *
 * @package test-ipsyde-plugin
 *
 * Plugin Name: Test for Inpsyde
 * Description: Plugin for checking out using Tamara payment method
 * Author:      nptrac@yahoo.com
 * Text Domain: inpsyde
 */

use TestInpsyde\Wp\Plugin\TestInpsyde;

// Use autoload if it isn't loaded before.
// phpcs:ignore PSR2.ControlStructures.ControlStructureSpacing.SpacingAfterOpenBrace
if ( ! class_exists(TestInpsyde::class)) {
    require_once __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
}

$config = require_once(__DIR__.DIRECTORY_SEPARATOR.'config.php');
/** @noinspection PhpUnhandledExceptionInspection */
TestInpsyde::initInstanceWithConfig($config);

register_activation_hook(__FILE__, [TestInpsyde::getInstance(), 'activatePlugin']);
register_deactivation_hook(__FILE__, [TestInpsyde::getInstance(), 'deactivatePlugin']);

// We need to set up the main instance for the plugin.
// Use 'init' event but with low (<10) processing order to be able to execute before -> able to add other init.
add_action('init', [TestInpsyde::getInstance(), 'initPlugin'], 7);
