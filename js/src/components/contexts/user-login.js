const { __ } = wp.i18n;
const { SelectControl } = wp.components;

function ContextUserLogin( { value, onChange } ) {
	const contextOptions = [
		{ id: '', caption: __( 'Select User Login State', 'block-context' ) },
		{ id: 'logged-in', caption: __( 'User logged-in', 'block-context' ) },
		{ id: 'logged-out', caption: __( 'User logged-out', 'block-context' ) }
	];

	return (
		<SelectControl
			value={ value }
			label={ __( 'User Status', 'block-context' ) }
			onChange={ onChange }
			options={ contextOptions.map( ( option ) => ( {
				label: option.caption,
				value: option.id,
			} ) ) }
		/>
	);
}

export default ContextUserLogin;
