<?php
/**
 * sumun functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package smn
 */



if ( ! function_exists( 'smn_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @return void
	 */
	function smn_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'smn-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'smn-style' );
	}

endif;

add_action( 'wp_enqueue_scripts', 'smn_styles' );



// Enqueue scripts
require get_template_directory() . '/inc/smn_enqueue-scripts.php';

/**
 * Implement the theme support features.
 */
require get_template_directory() . '/inc/smn_theme-support.php';

// Register blocks
require get_template_directory() . '/inc/smn_register-blocks.php';

// Shortcodes
require get_template_directory() . '/inc/smn_shortcodes.php';

// Admin functions
require get_template_directory() . '/inc/smn_admin-functions.php';

// Hooks
require get_template_directory() . '/inc/smn_hooks.php';

// Block theme support and editor styles
require get_template_directory() . '/inc/template-functions.php';

// Custom Post Type and Taxonomy registration
require get_template_directory() . '/inc/smn_post-types.php';

// Icon collection
require get_template_directory() . '/inc/smn_icons.php';