import { InspectorControls } from '@wordpress/block-editor';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';

import BlockContext from './block-context';

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
