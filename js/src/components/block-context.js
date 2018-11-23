import UserLoginContext from './contexts/user-login';

const { Component } = wp.element;
const { PanelBody } = wp.components;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { __ } = wp.i18n;

class BlockContext extends Component {
    
    constructor( { clientId, blockContextId, settings } ) {
        super( ...arguments );

        this.updateContextSetting = this.updateContextSetting.bind( this );
        this.setBlockContextId = this.setBlockContextId.bind( this );

        console.log( 'id', blockContextId );

        this.state = {
            clientId,
            settings,
            blockContextId,
        };
    }

    setBlockContextId( blockContextId ) {
        this.setState( {
            blockContextId,
        } );

        this.props.setAttributes( {
            blockContextId: blockContextId,
        } );
    }

    updateContextSetting( key, value ) {
        const setting = {};
        
        setting[ key ] = value;
        
        this.setState( { 
            settings: setting,
        } );

        this.setBlockContextId( 1234 );
    }

    render () {
        const { userLogin } = this.state;

        return (
            <PanelBody title={ __( 'Block Context', 'block-context' ) }>
                <UserLoginContext
                    value={ userLogin }
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
            blockContextId,
            settings: {
                userLogin: Math.floor( Math.random() * 10 )
            }
		};
	} ),
	withDispatch( ( dispatch, ownProps ) => {
		return {
			updateBlockContext() {
                console.log( 'updateBlockContext', ownProps );
            } 
		};
	} ),
] )( BlockContext );