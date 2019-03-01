import UserLoginContext from './contexts/user-login';

const { Component } = wp.element;
const { PanelBody, ToggleControl } = wp.components;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { __ } = wp.i18n;

class BlockContext extends Component {

	constructor( { clientId, blockContextId, settings, blockContext, generateBlockContextId, updateBlockContext } ) {
		super( ...arguments );

		console.log('BlockContext', blockContext);

		this.updateContextSetting = this.updateContextSetting.bind( this );
		this.setBlockContextId = this.setBlockContextId.bind( this );

		this.state = {
			clientId,
			settings,
			blockContextId,
		};

		if ( ! blockContextId ) {
			this.setBlockContextId( generateBlockContextId() );
		}
	}

	setBlockContextId ( blockContextId ) {
		console.log(blockContextId);
/*
		this.setState( {
			blockContextId,
		} );

		this.props.setAttributes( {
			blockContextId: blockContextId,
		} );*/
	}

	updateContextSetting ( key, value ) {
		const setting = {};

		setting[ key ] = value;

		this.setState( {
			settings: setting,
		} );

		// TODO: Replace the clientId with a permanent post ID when saving.
		// this.setBlockContextId( 1234 );
	}

	toggleContextEnable () {
		const { attributes, setAttributes } = this.props;
	}

	render () {
		const { settings } = this.state;

		return (
			<PanelBody title={ __( 'Block Context', 'block-context' ) }>
				<ToggleControl
					label={ __( 'Enable Block Context', 'block-context' ) }
					checked={ settings.enabled }
					onChange={ ( value ) => this.updateContextSetting( 'enabled', ! settings.enabled ) }
				/>
				<UserLoginContext
					value={ settings.userLogin }
					onChange={ ( value ) => this.updateContextSetting( 'userLogin', value ) }
				/>
			</PanelBody>
		);
	}

}

export default compose( [
	withSelect( ( select, ownProps, { dispatch } ) => {
		const { clientId } = ownProps;
		const { blockContextId } = ownProps.attributes;
		const { getEntityRecord } = select( 'core' );

		return {
			blockContextId,
			blockContext: blockContextId ? getEntityRecords( 'postType', 'block_context', blockContextId ) : {},
			settings: {
				userLogin: null,
				enabled: false,
			}
		};
	} ),
	withDispatch( ( dispatch, ownProps ) => {
		return {
			updateBlockContext () {
				console.log( 'updateBlockContext', ownProps );
			},

			generateBlockContextId () {
				const { clientId } = ownProps;
				const { saveEntityRecord } = dispatch( 'core' );

				return saveEntityRecord(
					'postType',
					'block_context',
					{
						title: clientId,
						status: 'publish',
					}
				).then( record => {
					console.log(record);
				} )
			}
		};
	} ),
] )( BlockContext );
