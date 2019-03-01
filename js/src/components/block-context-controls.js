import BlockContext from './block-context';

const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.editor;
const { Fragment } = wp.element;

export default createHigherOrderComponent( ( BlockEdit ) => {
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
}, 'withBlockContextControls' );
