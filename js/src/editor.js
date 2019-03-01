import BlockContextControls from './components/block-context-controls';
import BlockContextBlock from './block-context-block';
import blockContextAttributes from './block-context-attributes';

const { registerBlockType } = wp.blocks;
const { addFilter } = wp.hooks;

// Add context attributes to all blocks.
addFilter(
	'blocks.registerBlockType',
	'preseto/block-context/block-attributes',
	blockContextAttributes
);

// Add context controls to all blocks.
addFilter(
	'editor.BlockEdit',
	'preseto/block-context/block-controls',
	BlockContextControls
);

// Register our context wrapper block.
registerBlockType(
	'preseto/block-context-block',
	BlockContextBlock
);
