
wp.domReady( () => {
	wp.blocks.registerBlockStyle( 'core/list', [
		{
			name: 'default',
			label: 'Default',
			isDefault: true,
		},
		{
			name: 'separator-list',
			label: 'Separador',
		},
		{
			name: 'arrow-list',
			label: 'Flecha simple',
		},
		{
			name: 'arrow-separator-list',
			label: 'Flecha con separador',
		},
		{
			name: 'arrow-mini-separator-list',
			label: 'Flecha mini con separador',
		},

		{
			name: 'check-separator-list',
			label: 'Check con separador',
		},
		{
			name: 'check-list',
			label: 'Check simple',
		},
	] );
	wp.blocks.registerBlockStyle( 'core/button', [
		{
			name: 'default',
			label: 'Default',
			isDefault: true,
		},
		{
			name: 'with-arrow',
			label: 'Con Flecha',
		},
		{
			name: 'outline-with-arrow',
			label: 'Contorno con Flecha',
		},
	] );

	wp.blocks.registerBlockStyle( 'core/paragraph', [
		{
			name: 'default',
			label: 'Default',
			isDefault: true,
		},
		{
			name: 'badge',
			label: 'Píldora',
		},
		{
			name: 'eyebrow',
			label: 'Eyebrow',
		},
		{
			name: 'border-left',
			label: 'Border Left',
		}
	] );

		wp.blocks.registerBlockStyle( 'core/heading', [
		{
			name: 'default',
			label: 'Default',
			isDefault: true,
		},
		{
			name: 'badge',
			label: 'Píldora',
		},
		{
			name: 'eyebrow',
			label: 'Eyebrow',
		}
	] );

	wp.blocks.registerBlockStyle( 'core/cover', [
		{
			name: 'cover-contain-background',
			label: 'Contain Background',
		},
	] );

	wp.blocks.registerBlockStyle( 'core/quote', [
		{
			name: 'quote-card',
			label: 'Card',
		},
	] );

	wp.blocks.registerBlockStyle( 'core/query', [
		{
			name: 'is-related-posts',
			label: 'Related by category',
		},
	] );

	wp.blocks.registerBlockStyle( 'core/group', [
		{
			name: 'card',
			label: 'Card',
		},
		{
			name: 'card-small',
			label: 'Card small',
		},
		{
			name: 'group-horizontal-scroll',
			label: 'Horizontal scroll',
		},
		{
			name: 'group-horizontal-scroll-btns',
			label: 'Horizontal scroll with buttons',
		},
		{
			name: 'margin-vertical',
			label: 'Margin vertical (top & bottom 80px)',
		},
		{
			name: 'badge',
			label: 'Párrafos en píldora',
		},
		{
			name: 'arrow-on-top',
			label: 'Flecha encima',
		},
		{
			name: 'carousel',
			label: 'Carrusel',
		},
		{
			name: 'pattern-background',
			label: 'Pattern Background'
		},
		{
			name: 'oversized-left',
			label: 'Oversized Left'
		}
	] );

	wp.blocks.registerBlockStyle( 'core/media-text', [
		{
			name: 'card',
			label: 'Card',
		},
		{
			name: 'oversized-image',
			label: 'Oversized Image',
		}
	] );

	wp.blocks.registerBlockStyle( 'core/columns', [
		{
			name: 'oversized-left',
			label: 'Oversized Left',
		}
	] );

	wp.blocks.registerBlockVariation( 'core/group', [
		{
			name: 'group-horizontal-scroll',
			title: 'Horizontal scroll group',
			icon: 'leftright',
			description: 'Items in Horizontal scroll',
			isDefault: false,
			attributes: {
				className: 'is-style-group-horizontal-scroll',
			},
		},
	] );

	wp.blocks.registerBlockVariation( 'core/group', [
		{
			name: 'group-horizontal-scroll-btns',
			title: 'Horizontal scroll group with buttons',
			icon: 'sort',
			description: 'Items in Horizontal scroll with buttons',
			isDefault: false,
			attributes: {
				className: 'is-style-group-horizontal-scroll--btns',
			},
		},
	] );
	
} );

/* ADD data space height to wp-block-spacer in gutenberg */
wp.data.subscribe( function() {
	setTimeout( function() {
		const spacerBlocks = document.querySelectorAll( '.wp-block.wp-block-spacer' );

		for ( let item = 0; item < spacerBlocks.length; item++ ) {
			const block = spacerBlocks[ item ];

			const style = getComputedStyle( block ),
				height = parseInt( style.height ) || 0;

			block.querySelector( '.components-resizable-box__container' ).setAttribute( 'data-spaceheight', height + 'px' );
		}
	}, 1 );
} );

/* ADD data-hidden-class attribute to elements with hidden-* classes in the editor */
wp.data.subscribe(function() {
	setTimeout(function() {
		const hiddenBlocks = document.querySelectorAll('[class*="hidden-"]');
		hiddenBlocks.forEach(function(block) {
			const hiddenClasses = Array.from(block.classList).filter(function(cls) {
				return cls.startsWith('hidden-');
			});
			if (hiddenClasses.length > 0) {
				block.setAttribute('data-hidden-class', hiddenClasses.join(' '));
			}
		});
	}, 1);
});

