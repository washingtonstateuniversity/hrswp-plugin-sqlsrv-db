/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const {	RichText } = wp.blockEditor;

export default function CourseDateEdit( {
	attributes,
	className,
	setAttributes,
} ) {
	const {
		datetimeMetaValue,
		displayValue, /* eslint-disable-line no-unused-vars */
		placeholder,
	} = attributes;

	return (
		<div className={ className }>
			<div className="components-base-control">
				<span className="components-base-control__label">
					{ __( 'Date: ' ) }
				</span>
			</div>
			<RichText
				tagName="span"
				className="course-datetime"
				label={ __( 'Course date and time' ) }
				placeholder={ placeholder || __( 'Add date and / or time…' ) }
				keepPlaceholderOnFocus={ true }
				value={ datetimeMetaValue }
				onChange={ ( value ) => setAttributes( { datetimeMetaValue: value, displayValue: value } ) }
				formattingControls={ [] }
			/>
		</div>
	);
}
