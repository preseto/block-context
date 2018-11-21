const { createHigherOrderComponent, withState } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.editor;
const { PanelBody, CheckboxControl } = wp.components;
const { __ } = wp.i18n;

wp.hooks.addFilter(
    'editor.BlockEdit',
    'preseto/block-context/block-controls',
    createHigherOrderComponent( ( BlockEdit ) => {
        return ( props ) => {
			const HideToggle = withState( {
				isChecked: false,
			} )( ( { isChecked, setState } ) => (
				<CheckboxControl
					label={ __( 'Hide block if selected', 'block-context' ) }
					checked={ isChecked }
					onChange={ ( isChecked ) => { setState( { isChecked } ) } }
				/>
			) );

            return (
                <Fragment>
                    <BlockEdit { ...props } />
                    <InspectorControls>
                        <PanelBody title={ __( 'Block Context', 'block-context' ) }>
							<HideToggle />
                        </PanelBody>
                    </InspectorControls>
                </Fragment>
            );
        };
    }, 'withInspectorControl' )
);