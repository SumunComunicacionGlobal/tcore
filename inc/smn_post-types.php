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
                'name'          => __( 'Grupos de páginas', 'tcore-admin' ),
                'singular_name' => __( 'Grupo de páginas', 'tcore-admin' ),
                'menu_name'     => __( 'Grupos de páginas', 'tcore-admin' ),
                'all_items'     => __( 'Todos los grupos', 'tcore-admin' ),
                'edit_item'     => __( 'Editar grupo', 'tcore-admin' ),
                'add_new_item'  => __( 'Añadir nuevo grupo', 'tcore-admin' ),
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
                'name'          => __( 'Tipos de módulo', 'tcore-admin' ),
                'singular_name' => __( 'Tipo de módulo', 'tcore-admin' ),
                'menu_name'     => __( 'Tipos de módulo', 'tcore-admin' ),
                'all_items'     => __( 'Todos los tipos', 'tcore-admin' ),
                'edit_item'     => __( 'Editar tipo', 'tcore-admin' ),
                'add_new_item'  => __( 'Añadir nuevo tipo', 'tcore-admin' ),
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
        )
    );
}
add_action( 'init', 'smn_register_tipo_modulo_taxonomy' );

/**
 * Register the tutorial post type.
 */
function smn_register_tutorial_post_type() {
    $labels = array(
        'name'               => __( 'Tutoriales', 'tcore' ),
        'singular_name'      => __( 'Tutorial', 'tcore' ),
        'menu_name'          => __( 'Tutoriales', 'tcore' ),
        'add_new'            => __( 'Añadir nuevo', 'tcore-admin' ),
        'add_new_item'       => __( 'Añadir nuevo tutorial', 'tcore-admin' ),
        'edit_item'          => __( 'Editar tutorial', 'tcore-admin' ),
        'new_item'           => __( 'Nuevo tutorial', 'tcore-admin' ),
        'view_item'          => __( 'Ver tutorial', 'tcore-admin' ),
        'search_items'       => __( 'Buscar tutoriales', 'tcore-admin' ),
        'not_found'          => __( 'No se encontraron tutoriales', 'tcore-admin' ),
        'not_found_in_trash' => __( 'No se encontraron tutoriales en la papelera', 'tcore-admin' ),
    );

    register_post_type(
        'tutorial',
        array(
            'labels'       => $labels,
            'public'       => true,
            'has_archive'  => true,
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-welcome-learn-more',
            'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        )
    );
}
add_action( 'init', 'smn_register_tutorial_post_type' );

