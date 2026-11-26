(function () {
    if (wp.blocks.getBlockType('smn/animated-number')) {
        return;
    }

    var useBlockProps = wp.blockEditor.useBlockProps;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;

    wp.blocks.registerBlockType('smn/animated-number', {
    apiVersion: 2,
    title: 'Número animado',
    icon: 'image-filter',
    category: 'widgets',
    attributes: {
        number: {
            type: 'string',
            default: '000',
        },
        prefix: {
            type: 'string',
            default: '',
        },
        suffix: {
            type: 'string',
            default: '',
        },
    },
    edit: function(props) {
        const { attributes, setAttributes } = props;
        const { number, prefix, suffix } = attributes;
        const blockProps = useBlockProps({ className: 'wp-block-animated-number' });

        return wp.element.createElement(
            wp.element.Fragment,
            null,
            wp.element.createElement(
                InspectorControls,
                null,
                wp.element.createElement(
                    PanelBody,
                    { title: 'Ajustes del número animado', initialOpen: true },
                    wp.element.createElement(TextControl, {
                        label: 'Número',
                        type: 'number',
                        value: number,
                        onChange: function(value) {
                            setAttributes({ number: value });
                        }
                    }),
                    wp.element.createElement(TextControl, {
                        label: 'Prefijo',
                        value: prefix,
                        onChange: function(value) {
                            setAttributes({ prefix: value });
                        },
                        help: 'Ejemplos: +, %, $, ~'
                    }),
                    wp.element.createElement(TextControl, {
                        label: 'Sufijo',
                        value: suffix,
                        onChange: function(value) {
                            setAttributes({ suffix: value });
                        },
                        help: 'Ejemplos: k, M, %'
                    })
                )
            ),
            wp.element.createElement(
                'div',
                blockProps,
                wp.element.createElement(
                    'strong',
                    null,
                    ''
                ),
                wp.element.createElement(
                    'span',
                    { className: 'animated-number-prefix' },
                    prefix
                ),
                wp.element.createElement(
                    'span',
                    { className: 'wp-block-animated-number' },
                    number || '0'
                ),
                wp.element.createElement(
                    'span',
                    { className: 'animated-number-suffix' },
                    suffix
                )
            )
        );
    },
    save: function() {
        return null; // Bloque dinámico, renderizado por PHP
    }
    });
})();