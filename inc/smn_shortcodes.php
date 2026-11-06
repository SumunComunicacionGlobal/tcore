<?php 
// Shortcodes 

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function fecha_copyright_function() {
	return date('Y');
}
add_shortcode('fecha_copyright','fecha_copyright_function');
