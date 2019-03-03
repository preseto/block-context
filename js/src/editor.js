import BlockContextControls from './components/block-context-controls';
import blockContextAttributes from './block-context-attributes';

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
