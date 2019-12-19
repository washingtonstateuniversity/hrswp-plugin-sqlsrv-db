/**
 * Internal dependencies
 */
import { registerBlocks } from './blocks';
import { registerStores } from './store';

async function loadFilterHandler() {
	const input = document.querySelector( 'input#search_table_input' );
	if ( null !== input ) {
		const { default: filterInit } = await import( /* webpackChunkName: "filter" */ './lib/filter' );
		filterInit();
	}
}

registerBlocks();
registerStores();
loadFilterHandler();
