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
import icon from './icon';

const {
	name,
	category,
	supports,
} = metadata;

export { name };

export const settings = {
	title: __( 'HRS Awards' ),
	category,
	description: __( 'Display employee recognition awards.' ),
	icon,
	keywords: [ __( 'awards employees recognition' ) ],
	supports,
	styles: [
		{ name: 'default', label: _x( 'Grid', 'block style' ), isDefault: true },
		{ name: 'list', label: _x( 'List', 'block style' ) },
	],
	edit,
	save,
};
