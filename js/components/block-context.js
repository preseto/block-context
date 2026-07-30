import { PanelBody } from '@wordpress/components';
import { Component } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import UserLoginContext from './contexts/user-login';
import ContextRule from './contexts/context-rule';

class BlockContext extends Component {
	render() {
		return (
			<PanelBody title={ __( 'Block Context', 'block-context' ) }>
				<ContextRule
					value={ this.props.attributes.blockContextContextRule }
					onChange={ ( value ) =>
						this.props.setAttributes( {
							blockContextContextRule: value,
						} )
					}
				/>
				<UserLoginContext
					value={ this.props.attributes.blockContextUserLoginState }
					onChange={ ( value ) =>
						this.props.setAttributes( {
							blockContextUserLoginState: value,
						} )
					}
				/>
			</PanelBody>
		);
	}
}

export default BlockContext;
