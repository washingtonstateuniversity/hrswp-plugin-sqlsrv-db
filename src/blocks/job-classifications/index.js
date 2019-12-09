/**
 * WordPress dependencies
 */
const { __, _x } = wp.i18n;

/**
 * Internal dependencies
 */
import edit from './edit';
import metadata from './block.json';
import save from './save';

const {
	name,
	category,
	supports,
} = metadata;

export { name };

export const settings = {
	title: __( 'HRS Job Classifications' ),
	category,
	description: __( 'Display WSU job classification data.' ),
	icon: 'archive',
	keywords: [ __( 'table data compensation jobs' ) ],
	supports,
	styles: [
		{ name: 'default', label: _x( 'Table', 'block style' ), isDefault: true },
		{ name: 'list', label: _x( 'List', 'block style' ) },
	],
	edit,
	save,
};
