const { assign } = lodash;

export default ( settings ) => {
	settings.attributes = assign( settings.attributes, {
		blockContextContextRule: {
			type: 'string',
		},
		blockContextUserLoginState: {
			type: 'string',
		},
	} );

	return settings;
}
