<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package smn
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'smn_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 *
	 * @return void
	 */
	function smn_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Add support for excerpts in pages.
		add_post_type_support( 'page', 'excerpt' );

		// To use your template part inside your theme’s create a .html in /parts
		// and then put the php function "block_template_part( 'part-name' );" where you want to call it.
		// You can also create a template like page.html in /templates. And insert a part inside it: <!-- wp:template-part {"slug":"part-name"} /-->
		add_theme_support( 'block-template-parts' );

	}

endif;

add_action( 'after_setup_theme', 'smn_support' );


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function smn_hybrid_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'smn_hybrid_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function smn_hybrid_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'smn_hybrid_pingback_header' );
