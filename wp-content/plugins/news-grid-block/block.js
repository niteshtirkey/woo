(function(blocks, element, editor, components, data) {
    var el = element.createElement;
    var InspectorControls = editor.InspectorControls;
    var SelectControl = components.SelectControl;
    var PanelBody = components.PanelBody;
    var useSelect = data.useSelect;
    
    blocks.registerBlockType('ngb/news-grid', {
        title: 'News Grid',
        icon: 'grid-view',
        category: 'widgets',
        attributes: {
            category: {
                type: 'string',
                default: ''
            },
            postsPerPage: {
                type: 'number',
                default: 6
            }
        },
        
        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            
            // Fetch categories
            var categories = useSelect(function(select) {
                return select('core').getEntityRecords('taxonomy', 'news_category', {
                    per_page: -1
                });
            }, []);
            
            var categoryOptions = [{ label: 'All Categories', value: '' }];
            if (categories) {
                categories.forEach(function(cat) {
                    categoryOptions.push({ label: cat.name, value: cat.slug });
                });
            }
            
            var postsOptions = [
                { label: '3', value: 3 },
                { label: '6', value: 6 },
                { label: '9', value: 9 },
                { label: '12', value: 12 }
            ];
            
            return el('div', { className: 'ngb-block-editor' },
                el(InspectorControls, {},
                    el(PanelBody, { title: 'News Settings' },
                        el(SelectControl, {
                            label: 'Category',
                            value: attributes.category,
                            options: categoryOptions,
                            onChange: function(value) {
                                setAttributes({ category: value });
                            }
                        }),
                        el(SelectControl, {
                            label: 'Posts to Show',
                            value: attributes.postsPerPage,
                            options: postsOptions,
                            onChange: function(value) {
                                setAttributes({ postsPerPage: parseInt(value) });
                            }
                        })
                    )
                ),
                el('div', { className: 'ngb-preview' },
                    el('p', { style: { padding: '20px', background: '#f0f0f0', textAlign: 'center' } },
                        'News Grid Block',
                        el('br'),
                        'Category: ' + (attributes.category || 'All'),
                        el('br'),
                        'Posts: ' + attributes.postsPerPage
                    )
                )
            );
        },
        
        save: function() {
            return null; // Dynamic block, rendered by PHP
        }
    });
    
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.data
);
