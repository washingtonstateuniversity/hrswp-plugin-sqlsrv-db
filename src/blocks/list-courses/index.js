/**
 * WordPress dependencies
 */
const { __, _x } = wp.i18n;

/**
 * Internal dependencies
 */
import edit from './edit';
import icon from './icon';
import metadata from './block.json';
import save from './save';

const {
	name,
	category,
	supports,
} = metadata;

export { name };

export const settings = {
	title: __( 'List Courses' ),
	category,
	description: __( 'Display a list of the most recent courses.' ),
	icon,
	keywords: [ __( 'recent posts' ) ],
	supports,
	styles: [
		{ name: 'default', label: _x( 'Default', 'block style' ), isDefault: true },
		{ name: 'bulleted', label: _x( 'Bullets', 'block style' ) },
	],
	edit,
	save,
};
