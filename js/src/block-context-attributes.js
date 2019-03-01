const { assign } = lodash;

export default ( settings ) => {
	settings.attributes = assign( settings.attributes, {
		blockContextEnable: {
			type: 'bool',
		},
		blockContextUserLoginState: {
			type: 'string',
		},
	} );

	return settings;
}
