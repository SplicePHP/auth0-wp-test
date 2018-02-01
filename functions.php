<?php
/**
 * Main bootstrap file for this theme. Notes for usage:
 *
 * - This file is used for theme setup, file includes, and constant definition for the theme
 * - All functions defined here should be tied to the init, after_theme_setup, or activation hook
 * - Additional function definitions should go in a required file
 * - All relative path mentions in comments are relative to the theme root (where this file is)
 *
 * @package    WordPress
 * @subpackage WPAuth0Test
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Do not allow this file to be loaded directly
 */

if ( ! function_exists( 'add_action' ) ) {
	die( 'Nothing to do...' );
}

define( 'AUTH0_THEME_ROOT', dirname( __FILE__ ) );

/**
 * Add theme-specific functionality.
 *
 * @see http://codex.wordpress.org/Plugin_API/Action_Reference
 * @see http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
 * @see https://codex.wordpress.org/Function_Reference/add_theme_support#Addable_Features
 */

function auth0_theme_hook_after_setup_theme() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	remove_action( 'wp_head', 'wp_generator' );
}

add_action( 'after_setup_theme', 'auth0_theme_hook_after_setup_theme' );

/**
 * Queuing up JS and CSS for the front-end.
 *
 * @see https://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * @see https://codex.wordpress.org/Function_Reference/wp_enqueue_script
 *
 */

function auth0_theme_wp_enqueue_scripts() {

	wp_enqueue_style( 'auth0-core', '//cdn.auth0.com/styleguide/core/2.0.5/core.min.css' );
	wp_enqueue_style( 'auth0-comp', '//cdn.auth0.com/styleguide/components/2.0.0/components.min.css' );
	wp_enqueue_style( 'auth0-test', get_stylesheet_directory_uri() . '/assets/css/main.css' );
}

add_action( 'wp_enqueue_scripts', 'auth0_theme_wp_enqueue_scripts' );