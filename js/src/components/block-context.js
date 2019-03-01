import UserLoginContext from './contexts/user-login';

const { Component } = wp.element;
const { PanelBody, ToggleControl } = wp.components;
const { __ } = wp.i18n;

class BlockContext extends Component {

	constructor( props ) {
		super( ...arguments );

		this.props = props;
	}

	render () {
		return (
			<PanelBody title={ __( 'Block Context', 'block-context' ) }>
				<ToggleControl
					label={ __( 'Enable Block Context', 'block-context' ) }
					checked={ this.props.attributes.blockContextEnable }
					onChange={ ( value ) => this.props.setAttributes( { blockContextEnable: !! value } ) }
				/>
				<UserLoginContext
					value={ this.props.attributes.blockContextUserLoginState }
					onChange={ ( value ) => this.props.setAttributes( { blockContextUserLoginState: value } ) }
				/>
			</PanelBody>
		);
	}

}

export default BlockContext;
