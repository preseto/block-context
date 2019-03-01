const { Component } = wp.element;
const { __ } = wp.i18n;

class StatusBar extends Component {
    
    constructor () {
        super( ...arguments );
    }

    buildClassName( name ) {
        return `${ this.props.className }__${ name }`;
    }

    render () {
        const classes = [
            this.buildClassName( 'status-bar' ),
            this.props.isSelected ? this.buildClassName( 'status-bar--selected' ) : '',
        ]

        return (
            <div className={ classes.join( ' ' ) }>
                { __( 'Context Block', 'block-context' ) }
            </div>
        );
    }

}

export default StatusBar;