/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;

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
	attributes,
} = metadata;

export { name };

export const settings = {
	title: __( 'Course Online URL' ),
	category,
	description: __( 'The URLs for an online course.' ),
	icon,
	keywords: [ __( 'link' ) ],
	attributes,
	edit,
	save,
};
