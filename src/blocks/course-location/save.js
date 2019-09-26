/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { RichText } = wp.blockEditor;

export default function save( { attributes, className } ) {
	const {	displayValue } = attributes;

	if ( ! displayValue ) {
		return null;
	}

	return (
		<p className={ className }>
			<span className="label">
				{ __( 'Location: ' ) }
			</span>
			<RichText.Content
				tagName="span"
				className="course-location"
				value={ displayValue }
			/>
		</p>
	);
}
