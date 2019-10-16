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
	title: __( 'HRS Salary Grid' ),
	category,
	description: __( 'Display a table of WSU salary grid data.' ),
	icon,
	keywords: [ __( 'table data salary' ) ],
	supports,
	styles: [
		{ name: 'default', label: _x( 'Table', 'block style' ), isDefault: true },
		{ name: 'list', label: _x( 'List', 'block style' ) },
	],
	edit,
	save,
};
