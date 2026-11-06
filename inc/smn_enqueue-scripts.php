<?php
/**
 * Enqueue scripts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 function smn_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'smn-js', get_template_directory_uri() . '/assets/js/smn.min.js', array(), $theme_version, true );

	if ( is_singular() && has_block( 'cb/carousel' ) ) {
		wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/assets/js/slick/slick.min.css', array(), $theme_version );
		wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/slick/slick.min.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'slick-init-js', get_template_directory_uri() . '/assets/js/slick/init.js', array( 'jquery', 'slick-js' ), $theme_version, true );
	}

}
add_action( 'wp_enqueue_scripts', 'smn_scripts' );

/** 
* Gutenberg scripts
*/
function smn_gutenberg_scripts() {

	wp_enqueue_script(
		'be-editor', 
		get_stylesheet_directory_uri() . '/assets/js/editor.js', 
		array( 'wp-blocks', 'wp-dom', 'wp-dom-ready', 'wp-edit-post' ), 
		filemtime( get_stylesheet_directory() . '/assets/js/editor.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'smn_gutenberg_scripts' );

/**
 * GSAP script in WordPress
*/
// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
function theme_gsap_script(){
    // The core GSAP library
    wp_enqueue_script( 'gsap-js', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js', array(), false, true );
    // ScrollTrigger - with gsap.js passed as a dependency
    wp_enqueue_script( 'gsap-st', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js', array('gsap-js'), false, true );
    // Your animation code file - with gsap.js and gsap-st passed as a dependency
    wp_enqueue_script( 'gsap-js2', get_template_directory_uri() . '/assets/js/gsap.js', array('gsap-js', 'gsap-st'), false, true );
}

// add_action( 'wp_enqueue_scripts', 'theme_gsap_script' );



