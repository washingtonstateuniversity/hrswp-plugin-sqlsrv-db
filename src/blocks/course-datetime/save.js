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
				{ __( 'Date: ' ) }
			</span>
			<RichText.Content
				tagName="span"
				className="course-datetime"
				value={ displayValue }
			/>
		</p>
	);
}
