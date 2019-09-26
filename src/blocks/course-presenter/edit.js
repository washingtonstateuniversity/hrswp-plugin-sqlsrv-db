/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const {	RichText } = wp.blockEditor;

export default function CoursePresenterEdit( {
	attributes,
	className,
	setAttributes,
} ) {
	const {
		presenterMetaValue,
		displayValue, /* eslint-disable-line no-unused-vars */
		placeholder,
	} = attributes;

	return (
		<div className={ className }>
			<div className={ 'components-base-control' }>
				<span className="components-base-control__label">
					{ __( 'Presenter: ' ) }
				</span>
			</div>
			<RichText
				tagName="span"
				className="course-presenter"
				label={ __( 'Course presenter' ) }
				placeholder={ placeholder || __( 'Add presenter(s)…' ) }
				keepPlaceholderOnFocus={ true }
				value={ presenterMetaValue }
				onChange={ ( value ) => setAttributes( { presenterMetaValue: value, displayValue: value } ) }
				formattingControls={ [ 'bold' ] }
			/>
		</div>
	);
}
