<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'smn_get_demo_modal_content', 5 );
function smn_get_demo_modal_content() {
    static $content = null;

    if ( $content === null ) {
        ob_start();
        block_template_part( 'reserva-demo' );
        $content = ob_get_clean();
    }

    return $content;
}

add_action( 'wp_footer', 'smn_render_demo_modal', 5 );
function smn_render_demo_modal() {
    ?>
    <dialog id="smn-demo-modal" class="smn-demo-modal" aria-label="<?php esc_attr_e( 'Reservar demo', 'tefipro' ); ?>">
        <button type="button" class="smn-demo-modal__close" aria-label="<?php esc_attr_e( 'Cerrar ventana', 'tefipro' ); ?>" title="<?php esc_attr_e( 'Cerrar ventana', 'tefipro' ); ?>" autofocus>
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="smn-demo-modal__content">
            <?php echo smn_get_demo_modal_content(); ?>
        </div>
    </dialog>
    <?php
}

add_filter( 'render_block', 'smn_render_rank_math_breadcrumbs', 10, 2 );
function smn_render_rank_math_breadcrumbs( $block_content, $block ) {
    if ( ( $block['blockName'] ?? '' ) !== 'core/breadcrumbs' || ! function_exists( 'rank_math_get_breadcrumbs' ) ) {
        return $block_content;
    }

    $breadcrumbs = rank_math_get_breadcrumbs();

    return $breadcrumbs !== '' ? wp_kses_post( $breadcrumbs ) : $block_content;
}

add_filter( 'render_block', 'smn_render_go_button_arrow', 10, 2 );
function smn_render_go_button_arrow( $block_content, $block ) {
    if ( ( $block['blockName'] ?? '' ) !== 'core/button' ) {
        return $block_content;
    }

    $document = new DOMDocument( '1.0', 'UTF-8' );
    $previous_errors = libxml_use_internal_errors( true );
    $loaded = $document->loadHTML( '<?xml encoding="UTF-8">' . $block_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
    libxml_clear_errors();
    libxml_use_internal_errors( $previous_errors );
    if ( ! $loaded ) {
        return $block_content;
    }

    $xpath = new DOMXPath( $document );
    $button = $xpath->query( '//*[self::a or self::button][contains(concat(" ", normalize-space(@class), " "), " wp-block-button__link ")]' )->item( 0 );
    if ( ! $button || trim( $button->textContent ) !== 'Go' ) {
        return $block_content;
    }

    if ( ! $button->hasAttribute( 'aria-label' ) ) {
        $button->setAttribute( 'aria-label', 'Go' );
    }

    while ( $button->firstChild ) {
        $button->removeChild( $button->firstChild );
    }
    $button->appendChild( $document->createTextNode( "\u{2192}" ) );

    return $document->saveHTML( $document->documentElement );
}

add_filter( 'register_block_type_args', 'smn_paragraph_custom_field_context', 10, 2 );
function smn_paragraph_custom_field_context( $args, $block_name ) {
    if ( $block_name === 'core/paragraph' ) {
        $args['uses_context'] = array_unique( array_merge( $args['uses_context'] ?? [], [ 'postId' ] ) );
    }

    return $args;
}

add_filter( 'render_block', 'smn_render_custom_field_paragraph', 10, 3 );
function smn_render_custom_field_paragraph( $block_content, $block, $instance ) {
    if ( ( $block['blockName'] ?? '' ) !== 'core/paragraph' ) {
        return $block_content;
    }

    $classes = preg_split( '/\s+/', trim( $block['attrs']['className'] ?? '' ) );
    $field_name = '';
    foreach ( $classes as $class_name ) {
        if ( strpos( $class_name, 'cf-' ) === 0 && strlen( $class_name ) > 3 ) {
            $field_name = substr( $class_name, 3 );
            break;
        }
    }

    $post_id = $instance->context['postId'] ?? get_the_ID();
    if ( ! $field_name || ! $post_id || ! metadata_exists( 'post', $post_id, $field_name ) ) {
        return $block_content;
    }

    $value = get_post_meta( $post_id, $field_name, true );
    if ( ! is_scalar( $value ) ) {
        return $block_content;
    }

    $document = new DOMDocument( '1.0', 'UTF-8' );
    $previous_errors = libxml_use_internal_errors( true );
    $loaded = $document->loadHTML( '<?xml encoding="UTF-8">' . $block_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
    libxml_clear_errors();
    libxml_use_internal_errors( $previous_errors );
    $paragraph = $document->getElementsByTagName( 'p' )->item( 0 );
    if ( ! $loaded || ! $paragraph ) {
        return $block_content;
    }

    while ( $paragraph->firstChild ) {
        $paragraph->removeChild( $paragraph->firstChild );
    }
    $paragraph->appendChild( $document->createTextNode( (string) $value ) );
    if ( 'precio' === $field_name ) {
        $paragraph->nodeValue .= "&nbsp;€";
    }


    return $document->saveHTML( $paragraph );
}

// Agrega un filtro para el bloque de consulta de WordPress
// que muestra los posts relacionados en la página de un post y los filtra por categorías
add_filter('render_block_data', function ($parsed_block) {
    if (
        is_single() &&
        isset($parsed_block['blockName']) &&
        $parsed_block['blockName'] === 'core/query' &&
        isset($parsed_block['attrs']['className']) &&
        strpos($parsed_block['attrs']['className'], 'is-style-is-related-posts') !== false
    ) {
        $category_ids = wp_get_post_categories(get_the_ID());

        if (!empty($category_ids)) {
            $parsed_block['attrs']['query']['categoryIds'] = $category_ids;
            $parsed_block['attrs']['query']['exclude'] = [get_the_ID()];
            $parsed_block['attrs']['query']['sticky'] = '';
            $parsed_block['attrs']['query']['perPage'] = 6;
        }
    }

    return $parsed_block;
});

add_action( 'pre_get_posts', 'smn_pre_get_posts' );
function smn_pre_get_posts($query) {
    if (!$query->is_main_query() || is_admin() ) return;

    if (is_search()) {
        $query->set('posts_per_page', 30);
    } elseif( is_tax( 'portfolio_category') ) {
        $query->set('posts_per_page', 24);
    }
}

function cmplz_show_banner_on_click() {
	?>
	<script>
        function addEvent(event, selector, callback, context) {
            document.addEventListener(event, e => {
                if ( e.target.closest(selector) ) {
                    callback(e);
                }
            });
        }
        addEvent('click', 'a.cmplz-show-banner, li.cmplz-show-banner > a', function(){
            event.preventDefault();
            document.querySelectorAll('.cmplz-manage-consent').forEach(obj => {
                obj.click();
            });
        });
	</script>
	<?php
}
add_action( 'wp_footer', 'cmplz_show_banner_on_click' );

add_action( 'init', 'smn_register_meta' );
function smn_register_meta() {
	register_meta(
		'page',
		'precio',
		array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'sanitize_callback' => 'wp_strip_all_tags'
		)
	);
}

// TEMPORAL: mantiene abierta la superposición móvil del menú para maquetarla. Poner a false o borrar al terminar.
define( 'SMN_DEBUG_NAV_OVERLAY', false );

function smn_force_nav_overlay_open( $block_content ) {
    $processor = new WP_HTML_Tag_Processor( $block_content );

    if ( ! $processor->next_tag( 'nav' ) ) {
        return $block_content;
    }

    while ( $processor->next_tag( array( 'class_name' => 'wp-block-navigation__responsive-container' ) ) ) {
        $processor->add_class( 'is-menu-open' );
        $processor->add_class( 'has-modal-open' );
        // Without these directives the Interactivity API can no longer remove the open classes.
        $processor->remove_attribute( 'data-wp-class--is-menu-open' );
        $processor->remove_attribute( 'data-wp-class--has-modal-open' );
    }

    return $processor->get_updated_html();
}

add_filter( 'render_block_core/navigation', function ( $block_content ) {
    if ( ! SMN_DEBUG_NAV_OVERLAY || ! is_user_logged_in() ) {
        return $block_content;
    }

    return smn_force_nav_overlay_open( $block_content );
} );

