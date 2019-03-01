const { __ } = wp.i18n;
const { SelectControl } = wp.components;

function ContextRule( { value, onChange } ) {
	const contextOptions = [
		{ id: '', caption: __( 'Always show (default)', 'block-context' ) },
		{ id: 'show', caption: __( 'Show block when', 'block-context' ) },
		{ id: 'hide', caption: __( 'Hide block when', 'block-context' ) },
		{ id: 'hidden', caption: __( 'Always hide', 'block-context' ) },
	];

	return (
		<SelectControl
			value={ value }
			label={ __( 'Block Context', 'block-context' ) }
			onChange={ onChange }
			options={ contextOptions.map( ( option ) => ( {
				label: option.caption,
				value: option.id,
			} ) ) }
		/>
	);
}

export default ContextRule;
