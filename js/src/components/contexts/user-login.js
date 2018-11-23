const { __ } = wp.i18n;
const { SelectControl } = wp.components;

function ContextUserLogin( { value, onChange } ) {
	const contextOptions = [
		{ id: '', caption: __( 'Select User State', 'block-context' ) },
		{ id: 'logged-in', caption: __( 'Show for logged-in users', 'block-context' ) },
		{ id: 'logged-out', caption: __( 'Show for logged-out users', 'block-context' ) }
	];

	return (
		<SelectControl
			value={ value }
			label={ __( 'User Login State:', 'block-context' ) }
			onChange={ onChange }
			options={ contextOptions.map( ( option ) => ( {
				label: option.caption,
				value: option.id,
			} ) ) }
		/>
	);
}

export default ContextUserLogin;
