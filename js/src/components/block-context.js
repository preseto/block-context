import UserLoginContext from './contexts/user-login';
import ContextRule from './contexts/context-rule';

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
				<ContextRule
					value={ this.props.attributes.blockContextContextRule }
					onChange={ ( value ) => this.props.setAttributes( { blockContextContextRule: value } ) }
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
