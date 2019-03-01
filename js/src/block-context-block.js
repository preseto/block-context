import StatusBar from './components/status-bar';

const { InnerBlocks } = wp.editor;
const { __ } = wp.i18n;

export default {
	title: __( 'Block Context Container', 'block-context' ),

	icon: 'visibility',

	category: 'layout',

	edit ( props ) {
		const { className, isSelected } = props;

		const classNames = [
			className,
			isSelected ? className + '--selected' : '',
		];

		return (
			<div className={ classNames.join( ' ' ) }>
				<InnerBlocks />
			</div>
		);
	},

	save () {
		return <InnerBlocks.Content />;
	},
}
