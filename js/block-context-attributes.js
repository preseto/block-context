export default ( settings ) => {
	settings.attributes = Object.assign( settings.attributes, {
		blockContextContextRule: {
			type: 'string',
		},
		blockContextUserLoginState: {
			type: 'string',
		},
	} );

	return settings;
};
