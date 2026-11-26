<?php

function smn_render_animated_number_block( $attributes ) {
	$number = isset( $attributes['number'] ) ? (string) $attributes['number'] : '0';
	$prefix = isset( $attributes['prefix'] ) ? sanitize_text_field( $attributes['prefix'] ) : '';
	$suffix = isset( $attributes['suffix'] ) ? sanitize_text_field( $attributes['suffix'] ) : '';

	// Normaliza la entrada para asegurar que la animacion de GSAP reciba un numero valido.
	if ( is_numeric( $number ) ) {
		$safe_number = $number;
	} else {
		$safe_number = '0';
	}

	return sprintf(
		'<div %s><span class="animated-number-prefix">%s</span><span class="animated-number">%s</span><span class="animated-number-suffix">%s</span></div>',
		get_block_wrapper_attributes(),
		esc_html( $prefix ),
		esc_html( $safe_number ),
		esc_html( $suffix )
	);
}
