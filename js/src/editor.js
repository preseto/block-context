import BlockContext from './components/block-context';

const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.editor;
const { Fragment } = wp.element;
const { addFilter } = wp.hooks;
const { assign } = lodash;

function defineBlockContextIdAttribute( settings ) {
    settings.attributes = assign( settings.attributes, {
        blockContextId: {
            type: 'number',
        },
    } );

    return settings;
}

const blockContextControls = createHigherOrderComponent( ( BlockEdit ) => {
    return ( props ) => {
        if ( props.isSelected ) {
            return (
                <Fragment>
                    <BlockEdit { ...props } />
                    <InspectorControls>
                        <BlockContext { ...props } />
                    </InspectorControls> 
                </Fragment>
            );
        }
        
        return <BlockEdit { ...props } />;
    };
}, 'withInspectorControl' );

addFilter(
    'blocks.registerBlockType',
    'preseto/block-context/block-attributes',
    defineBlockContextIdAttribute
);

addFilter(
    'editor.BlockEdit',
    'preseto/block-context/block-controls',
    blockContextControls
);
