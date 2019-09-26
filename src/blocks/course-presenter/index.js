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

const {
	name,
	category,
	attributes,
} = metadata;

export { name };

export const settings = {
	title: __( 'Course Presenter(s)' ),
	category,
	description: __( 'The course presenter(s).' ),
	icon: 'id',
	keywords: [ __( 'courses' ), __( 'people' ), __( 'presenters' ) ],
	attributes,
	edit,
	save,
};
