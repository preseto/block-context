import BlockContextControls from './components/block-context-controls';
import BlockContextBlock from './block-context-block';
import blockContextAttributes from './block-context-attributes';

const { registerBlockType } = wp.blocks;
const { addFilter } = wp.hooks;

addFilter(
	'blocks.registerBlockType',
	'preseto/block-context/block-attributes',
	blockContextAttributes
);

addFilter(
	'editor.BlockEdit',
	'preseto/block-context/block-controls',
	BlockContextControls
);

registerBlockType(
	'preseto/block-context-block',
	BlockContextBlock
);
