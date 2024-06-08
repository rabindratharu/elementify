<?php
/**
 * Elementify functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Elementify
 */

$theme_version = wp_get_theme()->get( 'Version' );

if ( ! defined( 'ELEMENTIFY_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'ELEMENTIFY_VERSION', $theme_version );
}

if ( ! defined( 'ELEMENTIFY_DIR_PATH' ) ) {
	define( 'ELEMENTIFY_DIR_PATH', untrailingslashit( get_template_directory() ) );
}

if ( ! defined( 'ELEMENTIFY_DIR_URI' ) ) {
	define( 'ELEMENTIFY_DIR_URI', untrailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'ELEMENTIFY_BUILD_URI' ) ) {
	define( 'ELEMENTIFY_BUILD_URI', untrailingslashit( get_template_directory_uri() ) . '/build' );
}

if ( ! defined( 'ELEMENTIFY_BUILD_PATH' ) ) {
	define( 'ELEMENTIFY_BUILD_PATH', untrailingslashit( get_template_directory() ) . '/build' );
}

if ( ! defined( 'ELEMENTIFY_BUILD_JS_URI' ) ) {
	define( 'ELEMENTIFY_BUILD_JS_URI', untrailingslashit( get_template_directory_uri() ) . '/build/js' );
}

if ( ! defined( 'ELEMENTIFY_BUILD_JS_DIR_PATH' ) ) {
	define( 'ELEMENTIFY_BUILD_JS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/build/js' );
}

if ( ! defined( 'ELEMENTIFY_BUILD_IMG_URI' ) ) {
	define( 'ELEMENTIFY_BUILD_IMG_URI', untrailingslashit( get_template_directory_uri() ) . '/build/src/img' );
}

if ( ! defined( 'ELEMENTIFY_BUILD_CSS_URI' ) ) {
	define( 'ELEMENTIFY_BUILD_CSS_URI', untrailingslashit( get_template_directory_uri() ) . '/build/css' );
}

if ( ! defined( 'ELEMENTIFY_BUILD_CSS_DIR_PATH' ) ) {
	define( 'ELEMENTIFY_BUILD_CSS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/build/css' );
}

if ( ! defined( 'ELEMENTIFY_BUILD_LIB_URI' ) ) {
	define( 'ELEMENTIFY_BUILD_LIB_URI', untrailingslashit( get_template_directory_uri() ) . '/build/library' );
}

if ( ! defined( 'ELEMENTIFY_ARCHIVE_POST_PER_PAGE' ) ) {
	define( 'ELEMENTIFY_ARCHIVE_POST_PER_PAGE', 9 );
}

if ( ! defined( 'ELEMENTIFY_SEARCH_RESULTS_POST_PER_PAGE' ) ) {
	define( 'ELEMENTIFY_SEARCH_RESULTS_POST_PER_PAGE', 9 );
}

require_once ELEMENTIFY_DIR_PATH . '/inc/helpers/autoloader.php';
require_once ELEMENTIFY_DIR_PATH . '/inc/helpers/template-functions.php';
require_once ELEMENTIFY_DIR_PATH . '/inc/helpers/template-tags.php';
require_once ELEMENTIFY_DIR_PATH . '/inc/helpers/functions.php';

function elementify_get_theme_instance() {
	new \Elementify\Inc\Elementify();
}
elementify_get_theme_instance();