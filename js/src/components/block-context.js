import UserLoginContext from './contexts/user-login';

const { Component } = wp.element;
const { PanelBody, ToggleControl } = wp.components;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { __ } = wp.i18n;

class BlockContext extends Component {

	constructor( { settings } ) {
		super( ...arguments );

		this.updateContextSetting = this.updateContextSetting.bind( this );

		this.state = {
			settings
		};
	}

	updateContextSetting ( key, value ) {
		const setting = {};

		setting[ key ] = value;

		this.setState( {
			settings: setting,
		} );
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
	withSelect( ( select, ownProps ) => {
		const { blockContextId } = ownProps.attributes;

		return {
			settings: {
				userLogin: null,
				enabled: false,
			}
		};
	} ),
	withDispatch( ( dispatch, ownProps ) => {
		// TODO.
	} ),
] )( BlockContext );
