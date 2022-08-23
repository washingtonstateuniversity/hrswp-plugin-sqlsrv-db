/**
 * WordPress dependencies
 */
const { registerBlockType } = wp.blocks;

/**
 * Internal dependencies
 */
import * as salaryData from './salary-data';
import * as jobClassifications from './job-classifications';

/**
 * Function to register plugin blocks.
 *
 * @example
 * ```js
 * import { registerBlocks } from './blocks';
 *
 * registerBlocks();
 * ```
 */
export const registerBlocks = () => {
	[ salaryData, jobClassifications ].forEach( ( block ) => {
		if ( ! block ) {
			return;
		}
		const { metadata, settings, name } = block;
		registerBlockType( { name, ...metadata }, settings );
	} );
};
