<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the page grouping taxonomy.
 */
function smn_register_grupo_paginas_taxonomy() {
	register_taxonomy(
		'grupo_paginas',
		array( 'page' ),
		array(
			'labels'            => array(
				'name'          => __( 'Grupos de páginas', 'tcore' ),
				'singular_name' => __( 'Grupo de páginas', 'tcore' ),
				'menu_name'     => __( 'Grupos de páginas', 'tcore' ),
				'all_items'     => __( 'Todos los grupos', 'tcore' ),
				'edit_item'     => __( 'Editar grupo', 'tcore' ),
				'add_new_item'  => __( 'Añadir nuevo grupo', 'tcore' ),
			),
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
		)
	);
}
add_action( 'init', 'smn_register_grupo_paginas_taxonomy' );

/**
 * Register the module type taxonomy for pages.
 */
function smn_register_tipo_modulo_taxonomy() {
	register_taxonomy(
		'tipo-modulo',
		array( 'page' ),
		array(
			'labels'            => array(
				'name'          => __( 'Tipos de módulo', 'tcore' ),
				'singular_name' => __( 'Tipo de módulo', 'tcore' ),
				'menu_name'     => __( 'Tipos de módulo', 'tcore' ),
				'all_items'     => __( 'Todos los tipos', 'tcore' ),
				'edit_item'     => __( 'Editar tipo', 'tcore' ),
				'add_new_item'  => __( 'Añadir nuevo tipo', 'tcore' ),
			),
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
		)
	);
}
add_action( 'init', 'smn_register_tipo_modulo_taxonomy' );

