/**
 * WordPress dependencies
 */
const { registerBlockType } = wp.blocks;

/**
 * Internal dependencies
 */
import * as salaryGrid from './salary-grid';

/**
 * Function to register WSUWP HRS Courses blocks.
 *
 * @example
 * ```js
 * import { registerBlocks } from './blocks';
 *
 * registerBlocks();
 * ```
 */
export const registerBlocks = () => {
	[
		salaryGrid,
	].forEach( ( block ) => {
		if ( ! block ) {
			return;
		}
		const { settings, name } = block;
		registerBlockType( name, settings );
	} );
};
