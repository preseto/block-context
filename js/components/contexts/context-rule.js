import { SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

function ContextRule( { value, onChange } ) {
	const contextOptions = [
		{ id: '', caption: __( 'Show always (default)', 'block-context' ) },
		{
			id: 'show',
			caption: __( 'Show block on selected', 'block-context' ),
		},
		{
			id: 'hide',
			caption: __( 'Hide block on selected', 'block-context' ),
		},
		{ id: 'hidden', caption: __( 'Hide always', 'block-context' ) },
	];

	return (
		<SelectControl
			value={ value }
			onChange={ onChange }
			options={ contextOptions.map( ( option ) => ( {
				label: option.caption,
				value: option.id,
			} ) ) }
		/>
	);
}

export default ContextRule;
