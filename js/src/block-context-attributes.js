const { assign } = lodash;

export default ( settings ) => {
	settings.attributes = assign( settings.attributes, {
		blockContextId: {
			type: 'number',
		},
	} );

	return settings;
}
